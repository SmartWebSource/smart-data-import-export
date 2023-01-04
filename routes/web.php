<?php

use Illuminate\Support\Facades\Route;
use Smartwebsource\UniversalExcelDownloader\Http\Controllers\DownloadController;

Route::group(
    [
        'prefix'     => config('universalExcelDownloader.route.prefix'), 
        'middleware' => config('universalExcelDownloader.route.middleware')
    ], 
    function () {
        Route::get('/tables', [DownloadController::class, 'tables'])->name('universal-excel-download.tables');
        Route::get('/{table}/columns', [DownloadController::class, 'tableColumns'])->name('universal-excel-download.table.columns');
        Route::post('/download-excel', [DownloadController::class, 'downloadExcel'])->name('universal-excel-download.download.excel');
    }
);