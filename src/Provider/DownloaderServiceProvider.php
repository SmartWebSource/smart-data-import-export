<?php

namespace Smartwebsource\UniversalExcelDownloader\Provider;

use Illuminate\Support\ServiceProvider;

class DownloaderServiceProvider extends ServiceProvider
{
  public function register()
  {
    //
  }

  public function boot()
  {
    $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');

    $this->loadViewsFrom(__DIR__.'/../../resources/views', 'universal-excel-downloader');

    $this->publishes([
      __DIR__.'/../../config/universalExcelDownloader.php' => config_path('universalExcelDownloader.php'),
    ]);

    // $this->mergeConfigFrom(
    //   __DIR__.'/../../config/universalExcelDownloader.php', 'universalExcelDownloader.php'
    // );
  }

}