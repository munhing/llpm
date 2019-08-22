<?php

class ContainerConfirmationProcessTableSeeder extends Seeder
{

	public function run()
	{
		ContainerConfirmationProcess::create([
			'movement' => 'HI',
			'total_check_points' => '2',
			'cp1' => 'WF',
			'cp2' => 'CY1',
			'cp3' => '',
			'cp4' => ''
		]);

		ContainerConfirmationProcess::create([
			'movement' => 'HE',
			'total_check_points' => '2',
			'cp1' => 'CY1',
			'cp2' => 'WF',
			'cp3' => '',
			'cp4' => ''
		]);

		ContainerConfirmationProcess::create([
			'movement' => 'RI-1',
			'total_check_points' => '2',
			'cp1' => 'MG',
			'cp2' => 'CY1',
			'cp3' => '',
			'cp4' => ''
		]);

		ContainerConfirmationProcess::create([
			'movement' => 'RI-3',
			'total_check_points' => '2',
			'cp1' => 'PB',
			'cp2' => 'CY3',
			'cp3' => '',
			'cp4' => ''
		]);

		ContainerConfirmationProcess::create([
			'movement' => 'RO-1',
			'total_check_points' => '2',
			'cp1' => 'CY1',
			'cp2' => 'MG',
			'cp3' => '',
			'cp4' => ''
		]);

		ContainerConfirmationProcess::create([
			'movement' => 'RO-3',
			'total_check_points' => '2',
			'cp1' => 'CY3',
			'cp2' => 'PB',
			'cp3' => '',
			'cp4' => ''
		]);

		ContainerConfirmationProcess::create([
			'movement' => 'TF-1-3',
			'total_check_points' => '4',
			'cp1' => 'CY1',
			'cp2' => 'MG',
			'cp3' => 'PB',
			'cp4' => 'CY3'
		]);


		ContainerConfirmationProcess::create([
			'movement' => 'TF-3-1',
			'total_check_points' => '4',
			'cp1' => 'CY3',
			'cp2' => 'PB',
			'cp3' => 'MG',
			'cp4' => 'CY1'
		]);

		ContainerConfirmationProcess::create([
			'movement' => 'ST',
			'total_check_points' => '1',
			'cp1' => 'CY1',
			'cp2' => '',
			'cp3' => '',
			'cp4' => ''
		]);

		ContainerConfirmationProcess::create([
			'movement' => 'US',
			'total_check_points' => '1',
			'cp1' => 'CY1',
			'cp2' => '',
			'cp3' => '',
			'cp4' => ''
		]);

		// ContainerConfirmationProcess::create([
		// 	'movement' => 'EM',
		// 	'total_check_points' => '1',
		// 	'cp1' => 'CY1',
		// 	'cp2' => '',
		// 	'cp3' => '',
		// 	'cp4' => ''
		// ]);
	}
}