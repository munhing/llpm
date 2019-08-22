<?php

use Carbon\Carbon;

class FeesTableSeeder extends Seeder
{

	public function run()
	{

        $fee = Fee::register(
            'haulage',
            '["HI","HE"]',
            '{"20E":100,"20L":225,"40E":150,"40L":350}',
            '2006-01-26 00:00:00'
        );     
        $fee->save();         

        $fee = Fee::register(
            'lifting',
            '["RI", "RO"]',
            '{"20E":60,"20L":150,"40E":120,"40L":250}',
            '2006-01-26 00:00:00'
        );     
        $fee->save();         

        $fee = Fee::register(
            'activity',
            '["ST", "US"]',
            '{"20":150,"40":250}',
            '2006-01-26 00:00:00'
        );     
        $fee->save();  

        $fee = Fee::register(
            'transfer',
            '["TF"]',
            '{"20":60,"40":120}',
            '2006-01-26 00:00:00'
        );     
        $fee->save();  

        $fee = Fee::register(
            'storage',
            '["HE", "RO"]',
            '{"20":6,"40":12}',
            '2006-01-26 00:00:00'
        );     
        $fee->save();                             
	}
}