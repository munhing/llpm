<?php

namespace LLPM\Schedule;

class UpdateContainerCommand {

	public $container_id;
	public $container_no;
	public $size;
	public $container_no_old;
	public $size_old;

    public function __construct($container_id, $container_no, $size, $container_no_old, $size_old)
    {
		$this->container_id = $container_id;
		$this->container_no = $container_no;
		$this->size = $size;
		$this->container_no_old = $container_no_old;
		$this->size_old = $size_old;		
    }

}