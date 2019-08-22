<?php namespace LLPM\Repositories;

use Setting;

class SettingRepository {

	public function save(Setting $setting)
	{
		return $setting->save();
	}

	public function getAll()
	{
		return Setting::all()->first();
	}

	public function incrementWorkOrderNo()
	{
		$settings = $this->getAll();
		
		$settings->work_order_no += 1;
		$this->save($settings); 	
	}
	
	public function incrementImportDlNo()
	{
		$settings = $this->getAll();
		
		$settings->import_dl_no += 1;
		$this->save($settings); 
	}

	public function incrementExportDlNo()
	{
		$settings = $this->getAll();
		
		$settings->export_dl_no += 1;
		$this->save($settings); 
	}

	public function saveRegisteredVesselId($id)
	{
		$settings = $this->getAll();
		
		$settings->registered_vessel_id = $id;
		$this->save($settings);
	}
}