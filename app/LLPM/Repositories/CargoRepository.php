<?php namespace LLPM\Repositories;

use Cargo;
use Container;
use Paginator;
use Carbon\Carbon;
use DB;

class CargoRepository {

	public function save(Cargo $cargo)
	{
		$cargo->save();
		return $cargo;
	}

	public function getAll()
	{
		return Cargo::all();
	}

	public function getAllWithStatus2And3()
	{
		return Cargo::whereIn('status', [2,3])
				->orderBy('bl_no')
				->get();
	}

	public function getImportLooseCargoWithStatus1And3()
	{
		// return Cargo::where('containerized', 0)
		// 		->whereIn('status', [1,3])
		// 		->where('import_vessel_schedule_id', '!=', 0)
		// 		->orderBy('bl_no')
		// 		->get();
		$today = Carbon::now();
		// dd($today);
		return Cargo::select('cargoes.*', 'vessel_schedule.eta')
				->join('vessel_schedule', 'import_vessel_schedule_id', '=', 'vessel_schedule.id')
				->whereIn('status', [1,3])
				->where('vessel_schedule.eta', '<=', $today)
				->where('containerized', 0)
				->where('import_vessel_schedule_id', '!=', 0)
				->orderBy('bl_no')
				->get();
				
		// return DB::table('cargoes')
		//             ->join('vessel_schedule', 'cargoes.import_vessel_schedule_id', '=', 'vessel_schedule.id')
		//             ->select('cargoes.*', 'vessel_schedule.eta')
		//             ->where('cargoes.containerized', '=', 0)
		//             ->whereIn('cargoes.status', [1,3])
		//             ->where('cargoes.import_vessel_schedule_id', '!=', 0)
		//             ->orderBy('bl_no')
		//             ->get();

	}

	public function getExportLooseCargoWithStatus2And3()
	{
		$today = Carbon::now();
		// dd($today);
		return Cargo::select('cargoes.*', 'vessel_schedule.eta')
				->join('vessel_schedule', 'cargoes.export_vessel_schedule_id', '=', 'vessel_schedule.id')
				->whereIn('status', [2,3])
				->where('vessel_schedule.eta', '<=', $today)
				->where('containerized', 0)
				->where('export_vessel_schedule_id', '!=', 0)
				->orderBy('bl_no')
				->get();

		// return Cargo::with('exportSchedule')
		// 		->where('containerized', 0)
		// 		->whereIn('status', [2,3])
		// 		->where('export_vessel_schedule_id', '!=' , 0)
		// 		->orderBy('bl_no')
		// 		->get();
	}

	public function containerizedIncrement($cargo_id, $int)
	{
		$cargo = cargo::find($cargo_id);
		$cargo->increment('containerized', $int);
	}

	public function containerizedDecrement($cargo_id, $int)
	{
		$cargo = cargo::find($cargo_id);
		$cargo->decrement('containerized', $int);
	}

	public function getByBlNo($blNo)
	{
		return Cargo::where('bl_no', $blNo)
			->first();
	}

	public function getById($id)
	{
		return Cargo::with('containers', 'm_containers')->find($id);
	}
	
	public function getImportById($id)
	{
		return Cargo::with('importSchedule', 'consignor', 'consignee', 'containers','m_containers')
			->find($id);
	}

	public function getImportByYear($year)
	{
		return Cargo::selectRaw('sum(mt) as total_mt, month(received_date) as monthly')
					->where('import_vessel_schedule_id', '!=', 0)
					->whereYear('received_date', '=', $year)
					->groupBy('monthly')
					->get();
	}

	public function getExportByYear($year)
	{
		return Cargo::selectRaw('sum(mt) as total_mt, month(released_date) as monthly')
					->where('export_vessel_schedule_id', '!=', 0)
					->whereYear('released_date', '=', $year)
					->groupBy('monthly')
					->get();
	}

	public function getExportById($id)
	{
		return Cargo::with('consignor', 'consignee', 'containers', 'exportSchedule')
			->find($id);
	}

	public function getAllByScheduleId($vesselScheduleId)
	{
		return Cargo::with('consignor', 'consignee', 'importContainers')
			->where('vessel_schedule_id', $vesselScheduleId)
			->orderBy('bl_no')
			->get();		
	}

	public function attachToVesselSchedule($importCargo, $vessel_schedule_id)
	{
		return $importCargo->schedule()->attach($vessel_schedule_id);
	}

	public function attachToContainer(Cargo $cargo, Container $container)
	{
		// check whether both id's already listed in the pivot table
		if (!$cargo->containers->contains($container->id)) {
	    	$cargo->containers()->attach($container);
		}
	}

	public function m_attachToContainer(Cargo $cargo, Container $container)
	{
		// check whether both id's already listed in the pivot table
		if (!$cargo->m_containers->contains($container->id)) {
	    	$cargo->m_containers()->attach($container);
		}
	}

	public function detachFromContainer(Cargo $cargo, Container $container)
	{
	    $cargo->containers()->detach($container);
	}

	public function m_detachFromContainer(Cargo $cargo, Container $container)
	{
	    $cargo->m_containers()->detach($container);
	}

	public function getAllForSelectList()
	{
		return Cargo::selectRaw("id, bl_no AS text")->orderBy('text')->get();
	}

	public function getActiveExportCargoForSelectList()
	{
		return Cargo::selectRaw("id, bl_no AS text")
			->where('export_vessel_schedule_id', '!=', 0)
			->where('status', 3)
			->orderBy('text')
			->get();
	}

	public function getTopConsigneeByYear($year, $limit)
	{
		return Cargo::selectRaw('count(cargoes.consignee_id) as count, port_users.name')
				->join('port_users', 'cargoes.consignee_id', '=', 'port_users.id')
				->whereYear('cargoes.received_date', '=', $year)
				->where('cargoes.import_vessel_schedule_id', '!=', 0)
				->orderBy('count', 'desc')
				->groupBy('cargoes.consignee_id')
				->take($limit)
				->get();
	}

	public function getTopConsignorByYear($year, $limit)
	{
		return Cargo::selectRaw('count(cargoes.consignor_id) as count, port_users.name')
				->join('port_users', 'cargoes.consignor_id', '=', 'port_users.id')
				->whereYear('cargoes.released_date', '=', $year)
				->where('cargoes.export_vessel_schedule_id', '!=', 0)
				->orderBy('count', 'desc')
				->groupBy('cargoes.consignor_id')
				->take($limit)
				->get();
	}

	public function search($bl_no, $page = 1)
	{
		Paginator::setCurrentPage($page);

		return Cargo::with('Consignee','Consignor', 'ImportSchedule', 'ExportSchedule')
				->where('cargoes.bl_no', 'like', '%' . $bl_no . '%')
				->whereYear('cargoes.received_date', '>', 2015)
				->orderBy('cargoes.bl_no')
				->paginate(10);
	}	

	public function getImportCargoListByConsigneeAndYear($consignee_id, $year)
	{
		return Cargo::with('m_containers')
				->selectRaw('port_users.name, vessel_schedule.*, vessels.name as vessel_name, cargoes.*')
				->join('port_users', 'cargoes.consignee_id', '=', 'port_users.id')
				->join('vessel_schedule', 'cargoes.import_vessel_schedule_id', '=', 'vessel_schedule.id')
				->join('vessels', 'vessel_schedule.vessel_id', '=', 'vessels.id')
				->where('cargoes.consignee_id', '=', $consignee_id)
				->whereYear('cargoes.received_date', '=', $year)
				->where('cargoes.import_vessel_schedule_id', '!=', 0)
				->orderBy('cargoes.mt', 'desc')
				->get();
	}

	public function getExportCargoListByConsignorAndYear($consignor_id, $year)
	{
		return Cargo::with('containers')
				->selectRaw('port_users.name, vessel_schedule.*, vessels.name as vessel_name, cargoes.*')
				->join('port_users', 'cargoes.consignor_id', '=', 'port_users.id')
				->join('vessel_schedule', 'cargoes.export_vessel_schedule_id', '=', 'vessel_schedule.id')
				->join('vessels', 'vessel_schedule.vessel_id', '=', 'vessels.id')
				->where('cargoes.consignor_id', '=', $consignor_id)
				->whereYear('cargoes.released_date', '=', $year)
				->where('cargoes.export_vessel_schedule_id', '!=', 0)
				->orderBy('cargoes.mt', 'desc')
				->get();
	}	

	public function getTotalImportLooseMtByYear($year)
	{
		return Cargo::selectRaw('sum(mt) as total_mt, month(received_date) as monthly')
            			->whereNotExists(function($query)
            			{
                			$query->select(DB::raw(1))
                      		->from('m_cargo_container')
                      		->whereRaw('m_cargo_container.cargo_id = cargoes.id');
            			})
				->whereYear('received_date', '=', $year)
				// ->where('containerized', '!=', 0)
				->where('import_vessel_schedule_id', '!=', 0)
				->groupBy('monthly')
				->get();

		// return Cargo::selectRaw('sum(mt) as total_mt, month(received_date) as monthly')
		// 		->whereYear('received_date', '=', $year)
		// 		->where('containerized', '=', 0)
		// 		->where('import_vessel_schedule_id', '!=', 0)
		// 		->groupBy('monthly')
		// 		->get();
	}	

	public function getTotalExportLooseMtByYear($year)
	{
		return Cargo::selectRaw('sum(mt) as total_mt, month(released_date) as monthly')
            			// ->whereNotExists(function($query)
            			// {
               //  			$query->select(DB::raw(1))
               //        		->from('cargo_container')
               //        		->whereRaw('cargo_container.cargo_id = cargoes.id');
            			// })
				->whereYear('released_date', '=', $year)
				->where('containerized', '=', 0)
				->where('export_vessel_schedule_id', '!=', 0)
				->groupBy('monthly')
				->get();

		// return Cargo::selectRaw('sum(mt) as total_mt, month(released_date) as monthly')
		// 		->whereYear('released_date', '=', $year)
		// 		->where('containerized', '=', 0)
		// 		->where('export_vessel_schedule_id', '!=', 0)
		// 		->groupBy('monthly')
		// 		->get();
	}	
	
	public function getTotalImportContainerizedMtByYear($year)
	{
		return Cargo::selectRaw('sum(mt) as total_mt, month(received_date) as monthly')
            			->whereExists(function($query)
            			{
                			$query->select(DB::raw(1))
                      		->from('m_cargo_container')
                      		->whereRaw('m_cargo_container.cargo_id = cargoes.id');
            			})
				->whereYear('received_date', '=', $year)
				// ->where('containerized', '!=', 0)
				->where('import_vessel_schedule_id', '!=', 0)
				->groupBy('monthly')
				->get();
	}	

	public function getTotalExportContainerizedMtByYear($year)
	{
		return Cargo::selectRaw('sum(mt) as total_mt, month(released_date) as monthly')
            			// ->whereExists(function($query)
            			// {
               //  			$query->select(DB::raw(1))
               //        		->from('cargo_container')
               //        		->whereRaw('cargo_container.cargo_id = cargoes.id');
            			// })
				->whereYear('released_date', '=', $year)
				->where('containerized', '!=', 0)
				->where('export_vessel_schedule_id', '!=', 0)
				->groupBy('monthly')
				->get();
	}

	public function getOriginByYear($year)
	{
		return Cargo::selectRaw('sum(mt) as total_mt, country_code, country.name')
				->leftJoin('country', 'cargoes.country_code', '=', 'country.iso')
				->whereYear('received_date', '=', $year)
				->where('import_vessel_schedule_id', '!=', 0)
				->groupBy('country_code')
				->orderBy('total_mt', 'desc')
				->get();
	}	

	public function getDestinationByYear($year)
	{
		return Cargo::selectRaw('sum(mt) as total_mt, country_code, country.name')
				->leftJoin('country', 'cargoes.country_code', '=', 'country.iso')
				->whereYear('released_date', '=', $year)
				->where('export_vessel_schedule_id', '!=', 0)
				->groupBy('country_code')
				->orderBy('total_mt', 'desc')
				->get();
	}			
}