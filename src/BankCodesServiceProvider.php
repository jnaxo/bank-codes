<?php

namespace Jnaxo\BankCodes;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Jnaxo\BankCodes\BankStore;

class BankCodesServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap the application services.
   *
   * @return void
   */
  public function boot()
  {
      if (!$this->app->routesAreCached())
      {
          require __DIR__ . '/config/routes.php';
      }
      $this->setupMigrations($this->app);
      $this->setupSeeds($this->app);
  }

  /**
   * Register the application services.
   *
   * @return void
   */
  public function register()
  {
      $this->app->singleton('BankStore', function ()
      {
        return new BankStore();
      });
  }

  /**
   * Setup the migrations.
   *
   * @param \Illuminate\Contracts\Foundation\Application $app
   *
   * @return void
   */
  protected function setupMigrations(Application $app)
  {
      $source = realpath(__DIR__.'/../database/migrations/');

      if ($app instanceof LaravelApplication && $app->runningInConsole()) {
          $this->publishes([$source => database_path('migrations')], 'migrations');
      }
  }

  /**
   * Setup the seeds.
   *
   * @param \Illuminate\Contracts\Foundation\Application $app
   *
   * @return void
   */
  protected function setupSeeds(Application $app)
  {
      $source = realpath(__DIR__.'/../database/seeds/');

      if ($app instanceof LaravelApplication && $app->runningInConsole()) {
          $this->publishes([$source => database_path('seeds')], 'seeds');
      }
  }

}
