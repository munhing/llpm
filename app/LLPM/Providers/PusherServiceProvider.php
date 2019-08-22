<?php namespace LLPM\Providers;

use Illuminate\Support\ServiceProvider;
use Pusher;

class PusherServiceProvider extends ServiceProvider {

	public function register()
	{
        $this->app->bindShared('Pusher', function($app)
        {
        	$key = $app['config']->get('services.pusher');

            return new Pusher($key['key'], $key['secret'], $key['app_id']);
        });
	}
}