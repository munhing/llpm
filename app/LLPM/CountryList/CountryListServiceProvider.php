<?php namespace LLPM\CountryList;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Collection as Collection;
use Config;

class CountryListServiceProvider extends ServiceProvider
{

	public function register()
	{
		$this->app->singleton('countryList', function() {
			return new Collection(
				[
					Config::get('countrylist.list')
				]);
		});
	}
}