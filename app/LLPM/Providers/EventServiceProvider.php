<?php namespace LLPM\Providers;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider {

	public function register()
	{
		//$this->app['events']->listen('LLPM.*', 'LLPM\Handlers\EmailNotifier');
		$this->app['events']->listen('LLPM.*', function(){
			//dd('User was registered!');
		});
	}
}