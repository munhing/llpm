<?php 

namespace LLPM\Repositories;

use VesselSchedule;
use Vessel;
use Carbon\Carbon;
use Paginator;

class VesselScheduleRepository {

	public function save(VesselSchedule $vesselSchedule)
	{
		return $vesselSchedule->save();
	}

	public function getAll()
	{
		return VesselSchedule::with('vessel')
				->selectRaw('vessel_schedule.*, vessels.name')
				->join('vessels', 'vessel_schedule.vessel_id', '=', 'vessels.id')
				->orderBy('vessel_schedule.eta')
				->get();
	}

	public function getAllByMonth($month)
	{
		return VesselSchedule::with('vessel', 'portUser')
				->selectRaw('vessel_schedule.*, vessels.name')
				->join('vessels', 'vessel_schedule.vessel_id', '=', 'vessels.id')
				->where('eta', 'like', $month . '%')
				->orderBy('vessel_schedule.eta', 'desc')
				->get();
	}

	public function getActiveSchedule()
	{
		return VesselSchedule::selectRaw('vessel_schedule.*, vessels.name')
				->join('vessels', 'vessel_schedule.vessel_id', '=', 'vessels.id')
				->whereRaw("(`etd`) >= (NOW() - INTERVAL 1 DAY)")
				->orderBy('vessels.name')
				->get();
	}

	public function getById($id)
	{
		return VesselSchedule::with('vessel', 'portUser')->find($id);
	}

	public function getDetailsById($id)
	{
		return VesselSchedule::with(['vessel', 'portUser', 
				'importCargoes' => function($query){
					$query->with('m_containers')->orderBy('bl_no');
				}, 
				'exportCargoes' => function($query){
					$query->orderBy('bl_no');
				}, 				
				'importContainers' => function($query){
					$query->orderBy('container_no');
				},
				'exportContainers' => function($query){
					$query->orderBy('container_no');
				}				
			])->find($id);
	}

	public function getByVesselId($vessel_id)
	{
		return VesselSchedule::where('vessel_id', $vessel_id)->orderBy('eta', 'desc')->get();
	}

	public function getVesselCountByYear($year)
	{
		return VesselSchedule::selectRaw('count(*) as v_count, month(eta) as v_month')
				->whereYear('eta', '=', $year)
		       	->groupBy('v_month')
		       	->get();
	}

	public function getTopVesselByYear($year, $limit)
	{
		return VesselSchedule::selectRaw('count(vessel_schedule.vessel_id) as v_count, vessels.name' )
				->join('vessels', 'vessel_schedule.vessel_id', '=', 'vessels.id')
				->whereYear('vessel_schedule.eta', '=', $year)
		       	->orderBy('v_count', 'desc')
		       	->groupBy('vessel_id')
		       	->take($limit)
		       	->get();
	}	

	public function getTopAgentByYear($year, $limit)
	{
		return VesselSchedule::selectRaw('count(vessel_schedule.portuser_id) as count, port_users.name' )
				->join('port_users', 'vessel_schedule.portuser_id', '=', 'port_users.id')
				->whereYear('vessel_schedule.eta', '=', $year)
		       	->orderBy('count', 'desc')
		       	->groupBy('portuser_id')
		       	->take($limit)
		       	->get();
	}

	public function search($vessel_name, $page = 1)
	{
		Paginator::setCurrentPage($page);

		return Vessel::selectRaw('vessels.name, vessel_schedule.*')
				->join('vessel_schedule','vessel_schedule.vessel_id', '=', 'vessels.id')
				->where('vessels.name', 'like', '%' . $vessel_name . '%')
				->whereYear('vessel_schedule.eta', '>', 2015)
				->orderBy('vessel_schedule.eta', 'desc')
				->paginate(10);
	}
}
