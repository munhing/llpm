<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('TruncateTables');
		// $this->call('PortUserTableSeeder');
		// $this->call('VesselTableSeeder');
		// $this->call('VesselScheduleTableSeeder');
        // $this->call('CargoExportTableSeeder');
        // $this->call('CargoTableSeeder');
        // $this->call('WorkOrderTableSeeder2');	// Set the value for $import_vessel_schedule_id
        // $this->call('ContainerTableSeeder7'); // Set the value for $import_vessel_schedule_id
        $this->call('CalculateDaysByWorkorder'); // Set the value for $import_vessel_schedule_id
        // $this->call('ConvertEMToActivity');
		// $this->call('RoleTableSeeder');
		// $this->call('UserTableSeeder');		
        // $this->call('PermissionsTableSeeder');
		// $this->call('FeesTableSeeder');
        // $this->call('TariffTableSeeder');
		// $this->call('ContainerConfirmationProcessTableSeeder');
        // $this->call('WorkOrderTransformMovementTableSeeder');	// Update workorder movement to latest code and update who_is_involved
        

        // $this->call('ChangeWorkorderNo');
        
        // $this->call('ContainerConfirmationTableSeeder');	// Set the value for $import_vessel_schedule_id

	}

}
