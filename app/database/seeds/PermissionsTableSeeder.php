<?php

class PermissionsTableSeeder extends Seeder
{

	public function run()
	{
		Permission::create([
			'route_name' => 'home',
			'description' => 'Access this system'
		]);

		Permission::create([
			'route_name' => 'manifest.schedule',
			'description' => 'View Vessel Schedule'
		]);		

		Permission::create([
			'route_name' => 'manifest.vessels',
			'description' => 'View Vessels'
		]);		

		Permission::create([
			'route_name' => 'receiving',
			'description' => 'View Receiving'
		]);		

		Permission::create([
			'route_name' => 'workorders',
			'description' => 'View Work Orders'
		]);
		
		Permission::create([
			'route_name' => 'containers',
			'description' => 'View Containers'
		]);	
			
		Permission::create([
			'route_name' => 'confirmation',
			'description' => 'View Container Confirmation List'
		]);	
		
		Permission::create([
			'route_name' => 'cargo',
			'description' => 'View Cargoes'
		]);

		Permission::create([
			'route_name' => 'cargo.confirmation.import',
			'description' => 'View Import Cargo List'
		]);

		Permission::create([
			'route_name' => 'cargo.confirmation.export',
			'description' => 'View Export Cargo List'
		]);
		
		Permission::create([
			'route_name' => 'reports',
			'description' => 'View Reports'
		]);

		Permission::create([
			'route_name' => 'tariff',
			'description' => 'View Tariff'
		]);
		
		Permission::create([
			'route_name' => 'portusers',
			'description' => 'View Port Users'
		]);	
			
		Permission::create([
			'route_name' => 'users',
			'description' => 'View Users'
		]);	
				
		Permission::create([
			'route_name' => 'roles',
			'description' => 'View User Roles'
		]);	
					
		Permission::create([
			'route_name' => 'permissions',
			'description' => 'View Permissions'
		]);		
					
		Permission::create([
			'route_name' => 'settings.fees',
			'description' => 'View Fees'
		]);

		Permission::create([
			'route_name' => 'manifest.schedule.create',
			'description' => 'Register Vessel Schedule'
		]);
		
		Permission::create([
			'route_name' => 'manifest.vessels.create',
			'description' => 'Register New Vessel'
		]);	
			
		Permission::create([
			'route_name' => 'receiving.containers.create',
			'description' => 'Register Empty Containers for Receiving'
		]);	

		Permission::create([
			'route_name' => 'receiving.cargoes.create',
			'description' => 'Register Export Cargo'
		]);
				
		Permission::create([
			'route_name' => 'workorders.create',
			'description' => 'Register Work Order'
		]);	
					
		Permission::create([
			'route_name' => 'portusers.create',
			'description' => 'Register New Port User'
		]);	
						
		Permission::create([
			'route_name' => 'register',
			'description' => 'Register New User'
		]);	

		Permission::create([
			'route_name' => 'roles.create',
			'description' => 'Register New User Role'
		]);

	}
}