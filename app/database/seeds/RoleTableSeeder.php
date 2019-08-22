<?php

class RoleTableSeeder extends Seeder
{

	public function run()
	{
		Role::create([
			'role' => 'AD',
			'description' => 'ADMINISTRATOR'
		]); // 1

		Role::create([
			'role' => 'FD',
			'description' => 'FRONT DESK'
		]); // 2

		Role::create([
			'role' => 'WF',
			'description' => 'WHARF OPERATOR'
		]); // 3

		Role::create([
			'role' => 'MG',
			'description' => 'MAIN GATE'
		]); // 4

		Role::create([
			'role' => 'PB',
			'description' => 'POLIS BANTUAN'
		]); // 5

		Role::create([
			'role' => 'CY1',
			'description' => 'CY1 OPERATOR'
		]); // 6

		Role::create([
			'role' => 'CY3',
			'description' => 'CY3 OPERATOR'
		]); // 7

		Role::create([
			'role' => 'WH',
			'description' => 'WAREHOUSE OPERATOR'
		]); // 8

		Role::create([
			'role' => 'AC',
			'description' => 'ACCOUNTS'
		]); // 9	

		Role::create([
			'role' => 'IT',
			'description' => 'Information Technology'
		]); // 10			
	}
}