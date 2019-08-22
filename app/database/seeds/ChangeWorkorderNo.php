<?php

class ChangeWorkorderNo extends Seeder
{

	public function run()
	{

		// dd('Hello');
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		$w1 = 120098;
		$w2 = 120096;
		// $temp = 111;

		// change the workorder id that you want to a temporary small number

		// *******************************************
		// Change w2 to temp
		// *******************************************
		
		// change the container_workorder first
/*
		$tempNo = WorkOrder::find($w2);
		var_dump($tempNo->id);
		foreach($tempNo->containers as $container) {
			var_dump($container->container_no);

			// update containers.current_movement if it is not 0
			if($container->current_movement != 0) {
				$container->current_movement = $temp;
				$container->save();
			}

			// update container_workorder.workorder_id
			$cc = ContainerConfirmation::where('container_id', $container->id)->where('workorder_id', $w2)->get();
			$cc[0]->workorder_id = $temp;
			$cc[0]->save();

			// update container_workorder_confirmation.workorder_id
			$cwc = ContainerWorkorderConfirmation::where('container_id', $container->id)->where('workorder_id', $w2)->get();

			foreach($cwc as $row) {
				$row->workorder_id = $temp;
				$row->save();
			}

		}

		$tempNo->id = $temp;
		$tempNo->save();
*/
		// *******************************************
		// Change w1 to w2
		// *******************************************
		
		$workorder1 = WorkOrder::find($w1);
		var_dump($workorder1->id);

		foreach($workorder1->containers as $container) {
			var_dump($container->container_no);

			// update containers.current_movement if it is not 0
			if($container->current_movement != 0) {
				$container->current_movement = $w2;
				$container->save();
			}

			// update container_workorder.workorder_id
			$cc = ContainerConfirmation::where('container_id', $container->id)->where('workorder_id', $w1)->get();
			$cc[0]->workorder_id = $w2;
			$cc[0]->save();			

			// update container_workorder_confirmation.workorder_id
			$cwc = ContainerWorkorderConfirmation::where('container_id', $container->id)->where('workorder_id', $w1)->get();

			foreach($cwc as $row) {
				$row->workorder_id = $w2;
				$row->save();
			}

		}

		$workorder1->id = $w2;
		$workorder1->save();		

		// *******************************************
		// Change temp to w1
		// *******************************************
/*		
		$workorder2 = WorkOrder::find($temp);
		var_dump($workorder2->id);

		foreach($workorder2->containers as $container) {
			var_dump($container->container_no);

			// update containers.current_movement if it is not 0
			if($container->current_movement != 0) {
				$container->current_movement = $w1;
				$container->save();
			}

			// update container_workorder.workorder_id
			$cc = ContainerConfirmation::where('container_id', $container->id)->where('workorder_id', $temp)->get();
			$cc[0]->workorder_id = $w1;
			$cc[0]->save();	

			// update container_workorder_confirmation.workorder_id
			$cwc = ContainerWorkorderConfirmation::where('container_id', $container->id)->where('workorder_id', $temp)->get();

			foreach($cwc as $row) {
				$row->workorder_id = $w1;
				$row->save();
			}

		}

		$workorder2->id = $w1;
		$workorder2->save();
*/
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');		

	}
}
