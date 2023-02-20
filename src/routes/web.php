<?php

use Illuminate\Support\Facades\Route;
use SmartWebSource\SmartDataExportImport\Http\Controllers\DownloadController;

Route::group(
    [
        'prefix'     => config('smart-data-export-import.route.prefix'), 
        'middleware' => config('smart-data-export-import.route.middleware')
    ], 
    function () {
        Route::get('/', [DownloadController::class, 'index'])->name('smart-data-export-import.index');
        Route::get('/{model}/columns', [DownloadController::class, 'tableColumns'])->name('smart-data-export-import.export.columns');
        Route::post('/download-excel', [DownloadController::class, 'downloadExcel'])->name('smart-data-export-import.export.download.excel');
        Route::get('/{model}/file-upload', [DownloadController::class, 'fileUpload'])->name('smart-data-export-import.import.file-upload');
        Route::post('/file-upload', [DownloadController::class, 'storeFileUpload'])->name('smart-data-export-import.import.file-upload.store');
        Route::post('/import-excel', [DownloadController::class, 'processImportExcelFile'])->name('smart-data-export-import.import.excel');
    }
);