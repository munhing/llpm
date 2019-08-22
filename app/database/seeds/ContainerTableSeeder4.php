<?php

use Carbon\Carbon;

class ContainerTableSeeder4 extends Seeder
{

	public function run()
	{
		$faker = Faker\Factory::create();


        Excel::load('cy3.xls', function($reader) {

            $results = $reader->all();
            $count = 0;
			// var_dump(count($results));
			
			// dd($results);

            foreach($results as $row) {
                // dd($row->container);
                // dd()
                $count++;

                // var_dump($sheet->container);

                // check whether this container is in the db
                $ctn = Container::where('container_no', $row->container)
                     ->first();

                // if(!$ctn) {
                //     var_dump($count. ": " . $row->container . " - Container Not Listed");
                // } else {
                //     var_dump($count. ": " . $ctn->container_no . " - Location: " . $ctn->location);
                // }
                
                if($ctn) {
                    // if($ctn->location == 1) {
                    //     var_dump($count. ": " . $ctn->container_no . " - Location 1");
                    //     // $this->getContainerMovements($ctn);

                    //     $this->changeContainerLocation($ctn);
                    // }
                    
                    $this->changeContainerLocation($ctn);

                } else {
                    var_dump($count. ": " . $row->container . " - Container Not Listed");
                }

                // $ctnLoc3 = Container::where('container_no', $sheet->container)
                //      ->where('location', 3)
                //      ->first();

                // var_dump($ctn->container_no . ", Location:" . $ctn->location);
                // var_dump(count($c) . ", Location:" . $ctn->location);

                // dd($ctn->container_no);

                // if(!$ctn) {
                //  var_dump($sheet->container . ": Not listed!");
                // } else {
                //  if($ctn->location != 3) {
                //      var_dump($sheet->container . ": Not in CY3");
                //  }
                // }                
            }

        });
	}

    public function changeContainerLocation($container)
    {
        $container->location = 5;
        $container->save();
        var_dump($container->container_no . ": Changed location to CY5");
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