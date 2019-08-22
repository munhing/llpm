<?php

class Setting extends \Eloquent {

	protected $fillable = ['work_order_no', 'import_dl_no', 'export_dl_no'];

	protected $table = "settings";

	public $timestamps = false;
	
}