<?php

class ContainerConfirmationProcess extends \Eloquent {

	protected $fillable = ['movement', 'total_check_points', 'cp1', 'cp2', 'cp3', 'cp4', 'cp5', 'cp6', 'cp7', 'cp8', 'cp9', 'cp10'];

	protected $table = "container_confirmation_process";
}