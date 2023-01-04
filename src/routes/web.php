<?php

use Illuminate\Support\Facades\Route;
use Smartwebsource\SmartDataExportImport\Http\Controllers\DownloadController;

Route::group(
    [
        'prefix'     => config('smart-data-export-import.route.prefix'), 
        'middleware' => config('smart-data-export-import.route.middleware')
    ], 
    function () {
        Route::get('/index', [DownloadController::class, 'index'])->name('smart-data-export-import.index');
        Route::get('/{model}/columns', [DownloadController::class, 'tableColumns'])->name('smart-data-export-import.table.columns');
        Route::post('/download-excel', [DownloadController::class, 'downloadExcel'])->name('smart-data-export-import.download.excel');
    }
);