<?php

class UpdateAutoIncrement extends Seeder
{

	public function run()
	{
		DB::statement("ALTER TABLE `llpm`.`workorders` AUTO_INCREMENT = 350250");
		DB::statement("ALTER TABLE `llpm`.`import_dl` AUTO_INCREMENT = 35216");
		DB::statement("ALTER TABLE `llpm`.`export_dl` AUTO_INCREMENT = 25125");    
	}
}