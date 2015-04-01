<?php namespace Kyalo\NeoClient;

use Illuminate\Support\ServiceProvider;

class NeoClientServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->publishes([
		    __DIR__.'/../../../config/neoclient.php' => config_path('neoclient.php'),
		]);
	}

	/**
 * Register the service provider.
 *
 * @return void
 */
public function register()
{
	$this->mergeConfigFrom(__DIR__.'/../../../config/neoclient.php', 'neoclient'); 
    
    $this->app->singleton('neo', function($app)
	{
		return new ClientManager;
	});
}


}
