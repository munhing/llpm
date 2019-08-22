<?php

use Carbon\Carbon;

class ContainerTableSeeder5 extends Seeder
{

	public function run()
	{
		$faker = Faker\Factory::create();

        $containers = Container::where('location', 5)
            ->get();

        $count = 0;
			// var_dump(count($results));
			
		// dd(count($containers));

        foreach($containers as $container) {
            // dd($row->container);
            // dd()
            $count++;

            var_dump($count. ": " . $container->container_no . " - Location: " . $container->location);
           
               
            $this->changeContainerLocation($container);

               
        }

	}

    public function changeContainerLocation($container)
    {
        $container->location = 3;
        $container->save();
        var_dump($container->container_no . ": Changed location to CY3");
    }

    public function getContainerMovements($container)
    {
        $workorders = $container->workorders;

        if($workorders){
            foreach($workorders as $wo) {
                var_dump($wo->id . " : " . $wo->movement . " : " . $wo->date);
            }

        } 
    }
}