<?php

class SettingsTableSeeder extends Seeder
{

	public function run()
	{
		Setting::create([
			'work_order_no' => 124569,
			'import_dl_no' => '53698',
			'export_dl_no' => '27541'
		]);
	}
}