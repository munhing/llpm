<?php namespace LLPM\Repositories;

use Receiving;

class ReceivingRepository {

	public function save(Receiving $receiving)
	{
		return $receiving->save();
	}

	public function getAllByMonth($month)
	{
		return Receiving::where('date', 'like', $month . '%')
				->orderBy('date', 'desc')
				->get();
	}

	public function getDetailsById($id)
	{
		return Receiving::with([
				'cargoes', 
				'containers'
			])->find($id);
	}

	// public function getDetailsById($id)
	// {
	// 	return Receiving::with([
	// 			'cargoes', 
	// 			'containers' => function($query){
	// 				$query->selectRaw('containers.*, container_workorder.confirm, workorders.workorder_no, workorders.movement')
	// 						->join('container_workorder', 'containers.id', '=', 'container_workorder.container_id')
	// 						->join('workorders', 'workorders.id', '=', 'container_workorder.workorder_id')
	// 						->where('workorders.movement', 'RI')
	// 						->get();
	// 			}
	// 		])->find($id);
	// }

	public function getReceivingByDate($date = null)
	{
		if(! $date){
			$date = \Carbon\Carbon::now()->format('Y-m-d');
		}

		return Receiving::where('date', 'like', $date . '%')
				->get();
	}

	public function generateReceivingId()
	{
        if (! $receiving = $this->getReceivingByDate()->first())
        {
            $receiving = Receiving::create(['date' => \Carbon\Carbon::now()]);
            $receiving->save();
        }

        return $receiving;
	}

}