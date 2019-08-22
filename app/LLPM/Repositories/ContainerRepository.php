<?php namespace LLPM\Repositories;

use Cargo;
use Container;
use Carbon\Carbon;
use DB;
use Paginator;

class ContainerRepository {

	public function save(Container $container)
	{
		$container->save();
		
		return $container;
	}

	public function getAllActive()
	{
		return Container::with('workorders')
				->where('status', 3)
				->orderBy('container_no')
				->get();
	}

	public function getSpecificContainer($container_id)
	{
		return Container::with('workorders')
				->where('id', $container_id)
				->get();
	}

	public function getAllWithStatus3And4()
	{
		return Container::with('workorders')
				->whereIn('status', [3,4])
				->orderBy('container_no')
				->skip(25000)
				->take(5000)
				->get();
	}

	public function getAll()
	{
		return Container::all();
	}

	public function getContainersStatus1ByVessel($vessel_schedule_id)
	{
		return Container::where('import_vessel_schedule_id', '=', $vessel_schedule_id)
				->where('status', '=', 1)
				->get();
	}

	public function getContainersStatus3ByVessel($vessel_schedule_id)
	{
		return Container::where('export_vessel_schedule_id', '=', $vessel_schedule_id)
				->where('status', '=', 3)
				->get();
	}

	public function getTotalActive()
	{
		return Container::selectRaw('count(container_no) as count, containers.location')
				->where('status', '=', 3)
				->groupBy('containers.location')
				->get();
	}

	public function getActiveByContainerNo($container_no)
	{
		// don't remove the with->m_cargoes
		// if removed, the containerRepository->m_attachToCargo() will have error
		
		return Container::with('cargoes', 'm_cargoes')->where('container_no', $container_no)
				->whereIn('status', [1,2,3])
				->orderBy('container_no')
				->get()
				->first();
	}

	public function getActiveMovementByContainerNo($container_no)
	{
		// don't remove the with->m_cargoes
		// if removed, the containerRepository->m_attachToCargo() will have error
		
		return Container::with('workorders')
				->where('container_no', $container_no)
				->where('current_movement', '!=', 0)
				->get()
				->first();
	}

	public function getActiveLadenContainers()
	{
		return Container::where('status', 3)
				->where('current_movement', 0)
				->where('content', 'L')
				->where('dl_check', 0)
				->orderBy('container_no')
				->get();
	}

	public function getActiveLadenContainersForUnstuffing($location)
	{
		return Container::where('status', 3)
				->where('current_movement', 0)
				->where('content', 'L')
				->where('dl_check', 0)
				->where('location', $location)
				->orderBy('container_no')
				->get();
	}

	public function getActiveLadenContainersForVGM()
	{
		return Container::select('containers.*')
				->join('cargo_container', 'containers.id', '=', 'cargo_container.container_id')
				->join('cargoes', 'cargo_container.cargo_id', '=', 'cargoes.id')
				->where('containers.location', 1)
				->where('containers.content', 'L')
				->where('containers.status', 3)
				->where('containers.current_movement', 0)
				->where('containers.dl_check', 0)
				->where('cargoes.export_vessel_schedule_id', '!=', 0)
				->orderBy('container_no')
				->get();
	}

	public function getActiveEmptyContainersForStuffing($location)
	{
		return Container::where('status', 3)
				->where('current_movement', 0)
				->where('content', 'E')
				->where('location', $location)
				->orderBy('container_no')
				->get();
	}

	public function getAllByReceivingId($id)
	{
		return Container::with([
				'workorders'
				])->where('receiving_id', $id)
				->orderBy('container_no')
				->get();
	}

	public function getForStatus($status, $location = 0)
	{
		// For Transfer
		// Inactive: List only empty containers. Laden containers not allowed.
		// Active: List laden & empty containers.
		if($location != 0) {
			return Container::where('status', $status)
					->where('current_movement', 0)
					->where('location', $location)
					->orderBy('container_no')
					->get();
		}
		
		// For Remove In
		return Container::where('status', $status)
				->where('current_movement', 0)
				->where('dl_check', 0)
				->orderBy('container_no')
				->get();
	}

	public function getROForStatus($status, $location)
	{
		return Container::where('status', $status)
				->where('current_movement', 0)
				->where('location', $location)
				->where('dl_check', 0)
				->orderBy('container_no')
				->get();
	}

	public function getHEForStatus($status, $location)
	{
		return Container::where('status', $status)
				->where('current_movement', 0)
				->where('location', $location)
				->where('dl_check', 0)
				->orderBy('container_no')
				->get();
	}

	public function getContainersToConfirm()
	{
		return Container::with(['workorders' => function($q) {
					$q->orderBy('workorders.id');
				}])
				->select('containers.*', 'workorders.id as workorder_id', 'workorders.movement')
				->join('workorders', 'containers.current_movement', '=', 'workorders.id')
				->where('current_movement', '!=', 0)
				->orderBy('container_no')
				->get();

		// return Container::with('workorders')
		// 		->where('current_movement', '!=', 0)
		// 		->orderBy('container_no')
		// 		->get();				
	}	

	public function getContainersToConfirmByRole($role)
	{
		return Container::with('workorders')
				->where('to_confirm_by', $role)
				->orderBy('updated_at', 'desc')
				->get();
	}	

	public function getWithScheduleId($scheduleId)
	{
		return Container::where('import_vessel_schedule_id', $scheduleId)
				->where('current_movement', 0)
				->where('status', 1)
				->orderBy('container_no')
				->get();	
	}
	
	public function getById($id)
	{
		return Container::with('cargoes', 'm_cargoes', 'workorders')->find($id);
	}

	public function getLatestByContainerNo($containerNo)
	{
		return Container::with('import_schedule', 'export_schedule', 'receiving')
				->where('container_no', $containerNo)
				->where('status', '<>', 0)
				->orderBy('id', 'desc')
				->take(1)
				->get();
	}

	public function getByContainerNoWithStatus3And4($containerNo)
	{
		return Container::where('container_no', $containerNo)
				->whereIn('status', [3,4])
				->get();
	}

	public function attachToReceiving($container, $receiving)
	{
		return $container->receiving()->attach($receiving);
	}	

	public function attachToCargo(Cargo $cargo, Container $container)
	{
		// check whether both id's already listed in the pivot table
		if (!$container->cargoes->contains($cargo->id)) {
	    	$container->cargoes()->attach($cargo);
		}
	}

	public function m_attachToCargo(Cargo $cargo, Container $container)
	{
		// check whether both id's already listed in the pivot table
		if (!$container->m_cargoes->contains($cargo->id)) {
	    	$container->m_cargoes()->attach($cargo);
		}
	}

	public function updateContainerContent($container_id, $content)
	{
		$container = $this->getById($container_id);
		$container->content = $content;
		$this->save($container);
	}	

	public function m_updateContainerContent($container_id, $content)
	{
		$container = $this->getById($container_id);
		$container->m_content = $content;
		$this->save($container);
	}	

	public function updateCurrentMovement($container_id, $workorder_no = 0)
	{
		$container = $this->getById($container_id);
		$container->current_movement = $workorder_no;
		$this->save($container);		
	}

	public function updateCurrentMovementWithCheckPoint($container_id, $workorder_no = 0, $to_confirm_by, $check_point)
	{
		$container = $this->getById($container_id);
		$container->current_movement = $workorder_no;
		$container->to_confirm_by = $to_confirm_by;
		$container->check_point = $check_point;
		$this->save($container);		
	}

	public function updateDays($container_id, $days)
	{	
		$container = $this->getById($container_id);
		$container->days_empty = $days['E'];
		$container->days_laden = $days['L'];
		$container->days_total = $days['total'];
		$container->synced_at = Carbon::now();
		$this->save($container);				
	}	

	public function updateBondDays($container_id, $days)
	{	
		$container = $this->getById($container_id);
		$container->days_bond_import = $days['import'];
		$container->days_bond_export = $days['export'];
		$this->save($container);				
	}

	public function search($container_no, $page = 1)
	{
		Paginator::setCurrentPage($page);

		return Container::selectRaw('count(container_no) as count, containers.*')
				->where('container_no', 'like', '%' . $container_no . '%')
				->orderBy('containers.container_no')
				->groupBy('containers.container_no')
				->paginate(10);
	}			
}