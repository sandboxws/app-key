<?php 

namespace Dutkan\AppKey;

use Illuminate\Support\ServiceProvider;
use Dutkan\AppKey\Commands\AppKeyCommand;

class AppKeyServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		//$this->package('dutkan/app-key');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['app.key'] = $this->app->share(function($app)
        {
            return new AppKeyCommand();
        });

        $this->commands('app.key');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [];
	}

}
