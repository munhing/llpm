<?php

use Laracasts\Commander\Events\EventGenerator;

class ExportDL extends \Eloquent {

	use EventGenerator;

	protected $table = 'export_dl';

	protected $fillable = ['cargo_id'];

	public function cargo()
	{
		return $this->belongsTo('Cargo', 'cargo_id');
	}

	public static function register($cargo_id)
	{
		$exportDL = new static(compact('cargo_id'));
		$exportDL->save();

		return $exportDL;
	}

}