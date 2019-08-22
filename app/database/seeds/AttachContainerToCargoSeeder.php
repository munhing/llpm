<?php

use Laracasts\Commander\CommanderTrait;
use LLPM\ContainerHelper;
use LLPM\Schedule\AssociateContainersWithCargoCommand;

class AttachContainerToCargoSeeder extends Seeder
{
	use ContainerHelper;
	use CommanderTrait;

	public function run()
	{
		$input = [];
		$input['import_vessel_schedule_id'] = 284;

		for ($i=0;$i<80;$i++) {
			
			$container = Container::orderBy(DB::raw('RAND()'))->first();
			$input['containers'] = $this->filterContainers($container->container_no . '-' . $container->size, 'L', 1);
			$input['cargo_id'] = Cargo::orderBy(DB::raw('RAND()'))->first()->id;

			$this->execute(AssociateContainersWithCargoCommand::class, $input);
		}
	}
}