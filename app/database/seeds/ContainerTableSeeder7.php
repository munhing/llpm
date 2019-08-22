<?php

use Carbon\Carbon;

class ContainerTableSeeder7 extends Seeder
{

	public function run()
	{
		$cc = ContainerConfirmation::where('movement', 'EM')->get();

		dd(count($cc));

		foreach($cc as $c) {
			// $this->getContainerNo($c);
			$this->changeEM($c);
		}

	}

	public function changeEM($c)
	{
		$wo = WorkOrder::find($c->workorder_id);
		$c->movement = $wo->movement;
		$c->save();
	}

	public function getContainerNo($c)
	{
		$ctn = Container::find($c->container_id);
		var_dump($ctn->id . " | " . $ctn->container_no . " | " . $c->workorder_id);
	}


}