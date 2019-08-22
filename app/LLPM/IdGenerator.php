<?php 

namespace LLPM;

use VesselSchedule;
// use LLPM\Repositories\SettingRepository;

class IdGenerator {

	// protected $settingRepository;

	// function __construct(SettingRepository)
	// {
	// 	$this->settingRepository = $settingRepository;
	// }

	// public function generateWorkOrderNo()
	// {
	// 	//get latest ID
	// 	$workOrderNo = $this->settingRepository->getAll()->first()->work_order_no;

	// 	// increment ID by 1
	// 	$this->settingRepository->incrementWorkOrderNo();

	// 	return $workOrderNo;
	// }
	
	// public function generateImportDlNo()
	// {
	// 	//get latest ID
	// 	$dlNo = $this->settingRepository->getAll()->first()->import_dl_no;

	// 	// increment ID by 1
	// 	$this->settingRepository->incrementImportDlNo();

	// 	return $dlNo;
	// }

	// public function generateExportDlNo()
	// {
	// 	//get latest ID
	// 	$dlNo = $this->settingRepository->getAll()->first()->export_dl_no;

	// 	// increment ID by 1
	// 	$this->settingRepository->incrementExportDlNo();

	// 	return $dlNo;
	// }

	public function generateVesselId()
	{
		$registered_vessel_id = 0;
		$isSameYear = true;

		// it's better that the number displayed in the settings table show the current id used.
		// To make things simpler, the id generated will be based on the time the vessel schedule is being created rather than the vessel eta.
		// Eg. If today is 2015-12-31, and the FDesk is registering a vessel with eta 2106-01-02, the vessel id generated will still start with 1512.
		
		// get the last used id
		// $id = $this->settingRepository->getAll()->first()->registered_vessel_id;
		$id = VesselSchedule::orderBy('id', 'desc')->first()->registered_vessel_id;

		// Compare the current year
		$isSameYear = $this->compareYear($id);

		if(! $isSameYear) {
			$id = date("y") . date("m") . '000';
		}

		// Increment the last id used by 1
		$registered_vessel_id = (int)$id + 1;

		return $registered_vessel_id;
	}

	public function compareYear($id)
	{
		// Extract first to digit from id
		$year = substr($id, 0, 2);
		$currentYear = date("y");
		// $currentYear = 16;

		return ((int)($year) == (int)$currentYear);
	}
}