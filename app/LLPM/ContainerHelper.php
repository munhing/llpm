<?php namespace LLPM;

trait ContainerHelper {
	
	public function filterValidContainers($input)
	{

		$containers = array_filter($input['container']);

		if(!$containers) {
			return false;
		}

		foreach($containers as $key => $value)
		{
			$container = new \stdClass;
			$container->container_no = $value;
			$container->size = $input['size'][$key];
			$container->content = $input['content'][$key];

			$arrContainer[] = $container; 
		}

		return $arrContainer;
	}

	public function filterContainers($string, $content = 'E', $status = 1)
	{
		if(! $string) {
			return false;
		}

		$arrContainer = [];

		//explode(",", $string)	// convert string to array
		//array_map('trim', explode()) // remove whitespace
		//array_filter // remove empty array
		$array = array_filter(array_map('trim', explode(',', $string)));
		
		foreach ($array as $item) {
			if(count($c = explode("-", $item)) == 2) {

				$container = new \stdClass;
				$container->container_no = $c[0];
				$container->size = $c[1];
				$container->content = $content;
				$container->status = $status;

				$arrContainer[] = $container; 				
			}
		}
		
		//dd($arrContainer);

		return $arrContainer;

	}

}