<?php

use Carbon\Carbon;

class ContainerTableSeeder2 extends Seeder
{

	public function run()
	{
		$faker = Faker\Factory::create();

            $results = DB::select('select * from containermovement where ctnmconfirmdelivered = ? and ctnmwonoin != ? and ctnmlanded != ? and ctnmid > ? order by ctnmid', array(0,0, '0000-00-00', 149146));
            // $results = DB::select('select * from containermovement where ctnmconfirmdelivered = ? and ctnmwonoin != ? and ctnmlanded != ? and ctnmid > ? order by ctnmid limit 500 offset 500', array(0,0, '0000-00-00', 149146));
            // $results = DB::select('select * from containermovement where ctnmconfirmdelivered = ? and ctnmwonoin != ? and ctnmlanded != ? and ctnmid > ? order by ctnmid limit 500 offset 1000', array(0,0, '0000-00-00', 149146));

            // dd('Total records: ' . count($results));

            foreach($results as $row) {

                // if($results[0]->ctnmcurloc != 1) {
                // 	var_dump($sheet->container);
                // }

                // if($results[0]->ctnmwonoout != 0) {
                // 	var_dump($sheet->container);
                // 	$workorder = DB::select('select * from workorder where wono = ?', array($results[0]->ctnmwonoout));
                // 	var_dump($workorder[0]->wom . ' - ' . $workorder[0]->wono);
                // }

                // if($results[0]->ctnmconfirmdelivered != 0) {
                // 	var_dump($sheet->container);
                // } // There are 6 iso tanks

                // if(count($results) == 0) {
                // 	var_dump($sheet->container);
                // }
                
				// var_dump($row->ctnmid . ' | ' . $row->ctnmctnno);

				$container = [];
				$container['id'] = $row->ctnmid;
				$container['container_no'] = $row->ctnmctnno;
				$container['size'] = $row->ctnmctnsize;
				$container['import_vessel_schedule_id'] = $row->ctnmvsidin;
				$container['export_vessel_schedule_id'] = $row->ctnmvsidout;

				$workorders = [];

				// dd($container);

				//validate container information
				$proceed = $this->validateContainerInfo($row);

				if(! $proceed) {
					var_dump($row->ctnmid . ' | ' . $row->ctnmctnno . ' - Skipped! No valid info');
					continue;
				}

				// get all workorders and content
				// firstly get the wonoin
				// 
				$proceed = $this->validateWorkOrderStatusPair($row);

				if($proceed) {
					$workorders = $this->getAllWorkOrders($row);
				} else {
					var_dump($row->ctnmid . ' | ' . $row->ctnmctnno . ' - Skipped! Incompatible pairing');
				}

				ksort($workorders);

				$proceed = $this->validateWorkOrders($workorders);

				if($proceed) {
					$this->migrateContainer($container, $workorders, $row);
				} else {
					var_dump($row->ctnmid . ' | ' . $row->ctnmctnno . ' - Skipped! Work Order # not found in the new DB');
				}

				// die();      
            }
	}

	public function validateContainerInfo($row)
	{
		if($row->ctnmwonoin == 0) {
			if($row->ctnmvsidin == 0) {
				return false;
			}

			if(! ($row->ctnmstatusin == 'L' || $row->ctnmstatusin == 'E')) {
				return false;
			}			
		}

		if($row->ctnmwonoin != 0) {

			if(! ($row->ctnmstatusin == 'L' || $row->ctnmstatusin == 'E')) {
				return false;
			}

		}

		return true;	
	}

	public function getAllWorkOrders($row)
	{
		// get wonoin
		$workorders = [];
		$workorders = $this->extractWorkOrder($row->ctnmwonoin, $row->ctnmstatusin);

		// get other wo
		$workorders += $this->extractWorkOrder($row->ctnmwonoxtra, $row->ctnmstatusxtra);
		$workorders += $this->extractWorkOrder($row->ctnmwonot1, $row->ctnmstatust1);
		$workorders += $this->extractWorkOrder($row->ctnmwonot2, $row->ctnmstatust2);

		// get wonoout
		$workorders += $this->extractWorkOrder($row->ctnmwonoout, $row->ctnmstatusout);
		// dd($workorders);

		return $workorders;
	}	

	public function extractWorkOrder($workorder, $status)
	{
		$arr_wo = array_values(array_filter( explode(",", $workorder) ));
		$arr_status = array_values(array_filter( explode(",", $status) ));

		// var_dump($arr_wo);
		// var_dump($arr_status);
		
		$workorders = [];

		foreach($arr_wo as $key => $value) {
			$workorders[(int)$arr_wo[$key]]['workorder_no'] = $arr_wo[$key];
			$workorders[(int)$arr_wo[$key]]['content'] = $arr_status[$key];
		}
		// dd(count($arr_wo) . ' | ' . count($arr_status));
		// dd($arr_wo);


		// dd($workorders);

		return $workorders;
	}

	public function migrateContainer($container, $workorders, $row)
	{
		// dd($container);
		// dd($workorders);
		$container = $this->createContainer($container);

		if($row->ctnmwonoin != 0) {
			$this->attachContainerToWorkorder($container, $workorders);
		}
	}

	public function createContainer($container)
	{
		$con = Container::create([
			'id' => $container['id'],
			'container_no' => $container['container_no'],
			'size' => $container['size'],
			'status' => 2,
			'location' => 0,
			'export_vessel_schedule_id' => $container['export_vessel_schedule_id']
		]);

		if($container['import_vessel_schedule_id'] != 0) {
			$con->status = 1;
			$con->import_vessel_schedule_id = $container['import_vessel_schedule_id'];
			$con->save();
		}

		var_dump($con->id . ' | ' . $con->container_no . ' registered!');

		return $con;
	}

	public function attachContainerToWorkorder($container, $workorders)
	{
		// dd($workorders);
		$container_id = $container->id;

		$total_wo = count($workorders);
		$count_wo = 0;

		// dd('Total Workorder: ' . $total_wo);

		foreach($workorders as $wo) {

			$count_wo ++;

			$container 	= Container::find($container_id);
			$workorder 	= WorkOrder::find($wo['workorder_no']);

			$status 	= $container->status;
			$location 	= $container->location;
			$movement 	= $workorder->movement;

			$type 		= $workorder->movement;

			// HI,RI-1,RI-3,HE, RO-1, RO-3 

			if($type == 'HI') {
				$content = $wo['content'];
				$status = 3;
				$location = 1;
				$container->m_content = $wo['content'];

				if($count_wo == $total_wo) {
					$status = 1;
					$location = 0;
				}	
			}

			if($type == 'HE') {
				$content = $wo['content'];
				$status = 4;
				$location = 0;

				if($count_wo == $total_wo) {
					$status = 3;
					$location = 1;
				}				
			}

			if($type == 'RI') {
				$content = $wo['content'];
				$status = 3;
				$location = 1;
				if($content == 'E') {
					$location = 3;
				}

				$movement = 'RI-' . $location;

				if($count_wo == $total_wo) {
					$status = 2;
					$location = 0;
				}				
			}

			if($type == 'RO') {
				$content 	= $wo['content'];
				$status 	= 4;
				$location	= 0;

				$movement = 'RO-' . $container->location;

				if($count_wo == $total_wo) {
					$status = 3;
					$location = $container->location;
				}				
			}

			if($type == 'T1') {
				$content 	= $wo['content'];
				$location	= 1;

				$movement = 'TF-3-1';
			}

			if($type == 'T2') {
				$content 	= $wo['content'];
				$location	= 3;

				$movement = 'TF-1-3';
			}

			if($type == 'EM') {
				$content 	= $this->changeContent($wo['content']);
				$location	= 1;

				$movement 	= $this->convertEM($wo['content']);
			}

			if($type == 'RI-1') {
				$content = $wo['content'];
				$status = 3;
				$location = 1;

				$movement = 'RI-1';

				if($count_wo == $total_wo) {
					$status = 2;
					$location = 0;
				}				
			}

			if($type == 'RI-3') {
				$content = $wo['content'];
				$status = 3;
				$location = 3;

				$movement = 'RI-3';

				if($count_wo == $total_wo) {
					$status = 2;
					$location = 0;
				}				
			}

			if($type == 'RO-1') {
				$content 	= $wo['content'];
				$status 	= 4;
				$location	= 0;

				$movement = 'RO-1';

				if($count_wo == $total_wo) {
					$status = 3;
					$location = 1;
				}				
			}

			if($type == 'RO-3') {
				$content 	= $wo['content'];
				$status 	= 4;
				$location	= 0;

				$movement = 'RO-3';

				if($count_wo == $total_wo) {
					$status = 3;
					$location = 3;
				}				
			}

			if($type == 'T1-3-1') {
				$content 	= $wo['content'];
				$location	= 1;

				$movement = 'TF-3-1';
			}

			if($type == 'T1-1-3') {
				$content 	= $wo['content'];
				$location	= 3;

				$movement = 'TF-1-3';
			}

			if($type == 'US') {
				$content 	= 'E';
				$location	= 1;

				$movement 	= 'US';
			}

			if($type == 'ST') {
				$content 	= 'L';
				$location	= 1;

				$movement 	= 'ST';
			}

			$container->content = $content;
			$container->status = $status;
			$container->location = $location;

			if($count_wo == $total_wo) {
				if($type == 'HI' || $type == 'HE' || $type == 'RI-1' || $type == 'RI-3' || $type == 'RO-1' || $type == 'RO-3') {
					$container->status = $status;
					$container->location = $location;					
					$container->current_movement = $workorder->id;
				}
			}

			$container->save();

			if($count_wo == $total_wo) {
				if($type == 'HI' || $type == 'HE' || $type == 'RI-1' || $type == 'RI-3' || $type == 'RO-1' || $type == 'RO-3') {
					$id = DB::table('container_workorder')->insertGetId([
						'container_id' => $container->id, 
						'workorder_id' => $workorder->id,
						'movement' => $movement,
						'content' => $wo['content'],
						'updated_at' => $workorder->date
					]);				
				} else {
					$id = DB::table('container_workorder')->insertGetId([
						'container_id' => $container->id, 
						'workorder_id' => $workorder->id,
						'movement' => $movement,
						'content' => $wo['content'],
						'confirmed' => 1,
						'confirmed_by' => 1,
						'confirmed_at' => $workorder->date,
						'updated_at' => $workorder->date
					]);					
				}
			} else {

				$id = DB::table('container_workorder')->insertGetId([
					'container_id' => $container->id, 
					'workorder_id' => $workorder->id,
					'movement' => $movement,
					'content' => $wo['content'],
					'confirmed' => 1,
					'confirmed_by' => 1,
					'confirmed_at' => $workorder->date,
					'updated_at' => $workorder->date
				]);
			}

			var_dump($id . ' | ' . $container->container_no . ' attached to ' . $workorder->id);
		}


		// Only use this if you are certain that all the containers are in CY3
		// --------------------------------------------------------------------
		// $container 	= Container::find($container_id);

		// if($container->location == 1) {
		// 	$container->location = 3;
		// 	$container->save();
		// }
	}

	public function changeContent($content)
	{
		if($content == 'E') {
			return 'L';
		}

		return 'E';
	}

	public function convertEM($content)
	{
		if($content == 'E') {
			return 'ST';
		}

		return 'US';		
	}

	public function validateWorkOrders($workorders)
	{
		foreach($workorders as $wo) {
			if(count(WorkOrder::find($wo['workorder_no'])) == 0) {
				return false;
			}

		}

		return true;
		
	}

	public function validateWorkOrderStatusPair($row)
	{
		$result1 = $this->checkPair($row->ctnmwonoin, $row->ctnmstatusin);
		$result2 = $this->checkPair($row->ctnmwonoxtra, $row->ctnmstatusxtra);
		$result3 = $this->checkPair($row->ctnmwonot1, $row->ctnmstatust1);
		$result4 = $this->checkPair($row->ctnmwonot2, $row->ctnmstatust2);
		$result5 = $this->checkPair($row->ctnmwonoout, $row->ctnmstatusout);

		return ($result1 && $result2 && $result3 && $result4 && $result5);
	}

	public function checkPair($wono, $status)
	{
		$arr_wo = array_filter( explode(",", $wono) );
		$arr_status = array_filter( explode(",", $status) );

		if(count($arr_wo) != count($arr_status)) {		
			return false;
		}

		foreach($arr_status as $status) {
			if(!($status == 'L' || $status == 'E')) {
				return false;
			}
		}

		return true;
	}
}