<?php namespace JSila\Animate;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class AnimateServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('JSila\Animate\Session\SessionInterface', 'JSila\Animate\Session\IlluminateSession');
        $this->app->bind('animate', 'JSila\Animate\Animate');
	}

	public function boot()
	{
	    $this->package('jsila/animate');

	    include __DIR__ . '/routes.php';

	    AliasLoader::getInstance()->alias('Animate', 'JSila\Animate\Facades\Animate');

	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['animate'];
	}
}
