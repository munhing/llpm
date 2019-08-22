<?php

use Carbon\Carbon;

class ContainerConfirmationTableSeeder extends Seeder
{

	public function run()
	{
		$faker = Faker\Factory::create();

		// $workorders = WorkOrder::take(5000)->get();
		// $workorders = WorkOrder::skip(5000)->take(5000)->get();
		// $workorders = WorkOrder::skip(10000)->take(5000)->get();
		// $workorders = WorkOrder::skip(15000)->take(5000)->get();
		// $workorders = WorkOrder::skip(20000)->take(5000)->get();
		$workorders = WorkOrder::skip(25000)->take(5000)->get();
		// $workorders = WorkOrder::skip(10000)->take(5000)->get();

		foreach($workorders as $wo) {

			var_dump($wo->id);

			// var_dump('Container Count: ' . count($wo->containers));

			if(count($wo->containers) != 0) {

				$this->processContainers($wo->containers, $wo);

			}

		}
	}

	public function processContainers($containers, $workorder)
	{
		foreach($containers as $container) {
			var_dump($container->id . ' | ' . $container->container_no . ' | ' . $workorder->id);

			// get the id for container_workorder_id
			$container_workorder = ContainerConfirmation::where('container_id', $container->id)
										->where('workorder_id', $workorder->id)
										->first();

			// dd($container_workorder_id);

			$this->insertIntoTable($container, $workorder, $container_workorder);
		}
	}

	public function insertIntoTable($container, $workorder, $container_workorder)
	{
		$arr_roles = json_decode($workorder->who_is_involved, true);

		foreach($arr_roles as $role) {

			$id = DB::table('container_workorder_confirmation')->insertGetId([
				'container_id' => $container->id, 
				'container_no' => $container->container_no, 
				'workorder_id' => $workorder->id,
				'container_workorder_id' => $container_workorder->id,
				'confirmed_by' => 100,
				'operator_id' => 100,
				'role' => $role,
				'confirmed_at' => $workorder->date
			]);

			var_dump('Inserted: ' . $id);
		}

	}


}