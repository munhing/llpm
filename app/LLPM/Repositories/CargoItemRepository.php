<?php namespace LLPM\Repositories;

use CargoItem;

class CargoItemRepository {

	public function save(CargoItem $cargoItem)
	{
		$cargoItem->save();
		return $cargoItem;
	}

	public function getAll()
	{
		return CargoItem::all();
	}

	public function getById($id)
	{
		return CargoItem::with('cargo')->find($id);
	}
	
	public function getAllByCargoId($cargo_id)
	{
		return CargoItem::with('cargo', 'customTariff')
			->where('cargo_id', $cargo_id)
			->orderBy('custom_tariff_code')
			->get();		
	}

	public function getTopImportCargoItemByYear($year, $limit)
	{
		return CargoItem::selectRaw('count(cargo_items.custom_tariff_code) as count, cargo_items.custom_tariff_code, sum(cargo_items.quantity) as qty, custom_tariff.description, custom_tariff.uoq, custom_tariff.group')
				->join('custom_tariff', 'cargo_items.custom_tariff_code', '=', 'custom_tariff.code')
				->join('cargoes', 'cargo_items.cargo_id', '=', 'cargoes.id')
				->whereYear('cargoes.received_date', '=', $year)
				->where('cargoes.import_vessel_schedule_id', '!=', 0)
				->orderBy('count', 'desc')
				->groupBy('cargo_items.custom_tariff_code')
				->take($limit)
				->get();
	}

	public function getTopExportCargoItemByYear($year, $limit)
	{
		return CargoItem::selectRaw('count(cargo_items.custom_tariff_code) as count, cargo_items.custom_tariff_code, sum(cargo_items.quantity) as qty, custom_tariff.description, custom_tariff.uoq, custom_tariff.group')
				->join('custom_tariff', 'cargo_items.custom_tariff_code', '=', 'custom_tariff.code')
				->join('cargoes', 'cargo_items.cargo_id', '=', 'cargoes.id')
				->whereYear('cargoes.released_date', '=', $year)
				->where('cargoes.export_vessel_schedule_id', '!=', 0)
				->orderBy('count', 'desc')
				->groupBy('cargo_items.custom_tariff_code')
				->take($limit)
				->get();
	}
}