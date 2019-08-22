<?php

use Laracasts\Commander\Events\EventGenerator;

class ImportDL extends \Eloquent {

	use EventGenerator;

	protected $table = 'import_dl';

	protected $fillable = ['cargo_id'];

	public function cargo()
	{
		return $this->belongsTo('Cargo', 'cargo_id');
	}

	public static function register($cargo_id)
	{
		$importDL = new static(compact('cargo_id'));
		$importDL->save();

		return $importDL;
	}

}