<?php

namespace SmartWebSource\SmartDataExportImport;

use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider
{
  public function register()
  {
    //
  }

  public function boot()
  {
    $this->loadRoutesFrom(__DIR__.'/routes/web.php');

    $this->loadViewsFrom(__DIR__.'/resources/views', 'smart-data-export-import');

    $this->publishes([
      __DIR__.'/resources/views' => resource_path('views/vendor/smart-data-export-import'),
    ], 'smart-data-export-import-view');

    $this->publishes([
      __DIR__.'/config/smart-data-export-import.php' => config_path('smart-data-export-import.php'),
    ], 'smart-data-export-config');

    $this->mergeConfigFrom(
      __DIR__.'/config/smart-data-export-import.php', 'smart-data-export-import.php'
    );
  }

}