<?php

use Illuminate\Support\Facades\Route;
use Smartwebsource\SmartDataExportImport\Http\Controllers\DownloadController;

Route::group(
    [
        'prefix'     => config('smart-data-export-import.route.prefix'), 
        'middleware' => config('smart-data-export-import.route.middleware')
    ], 
    function () {
        Route::get('/tables', [DownloadController::class, 'tables'])->name('smart-data-export-import.tables');
        Route::get('/{table}/columns', [DownloadController::class, 'tableColumns'])->name('smart-data-export-import.table.columns');
        Route::post('/download-excel', [DownloadController::class, 'downloadExcel'])->name('smart-data-export-import.download.excel');
    }
);