<?php namespace LLPM\Containers\Events;

use Container;

class ContainerWasUpdated {

    public $container;

    public function __construct(Container $container) /* or pass in just the relevant fields */
    {
        $this->container = $container;
    }

}