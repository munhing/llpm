<?php namespace LLPM\Validators;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\MessageBag;
// /use LLPM\Validators\StatusOneValidator;

class LLPMValidatorServiceProvider extends ServiceProvider
{

	public function register()
	{
		$this->app->bind('AssociateContainerValidator', function($app) {
			return new LLPMValidator(
				[
					$app->make('LLPM\Validators\ContainerAlreadyAttachedToCargoValidator'),
					$app->make('LLPM\Validators\ContainerStatusOneValidator'),
					$app->make('LLPM\Validators\SameVesselScheduleValidator'),
					$app->make('LLPM\Validators\CargoStatusOneValidator')
				],
			
				new MessageBag
			);
		});

		$this->app->bind('DetachContainerValidator', function($app) {
			return new LLPMValidator(
				[
					$app->make('LLPM\Validators\ContainerStatusOneValidator'),
					$app->make('LLPM\Validators\CargoStatusOneValidator')
				],
			
				new MessageBag
			);
		});		

		$this->app->bind('DeleteContainerValidator', function($app) {
			return new LLPMValidator(
				[
					$app->make('LLPM\Validators\ContainerMustNotBeLadenValidator'),
					$app->make('LLPM\Validators\ContainerMustNotHaveWorkOrdersIssuedValidator')
				],
			
				new MessageBag
			);
		});		
	}
}

					// 
					// $app->make('LLPM\Validators\CargoStatusOneValidator')