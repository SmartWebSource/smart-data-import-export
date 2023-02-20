<?php

namespace SmartWebSource\SmartDataExportImport\Http\Controllers;

use SmartWebSource\SmartDataExportImport\Exports\SmartExcelExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Excel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
Use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Support\Str;
use SmartWebSource\SmartDataExportImport\Imports\SmartExcelImport;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{    
    public function index()
    {
        $models = $this->allModelInTheProject();
        return view("smart-data-export-import::index", compact('models'));
    }

    public function tableColumns(string $model){
        if(in_array($model, $this->allModelInTheProject())){
            $table = (new $model)->getTable();
            $columns = Schema::getColumnListing($table);
            return view("smart-data-export-import::column-form", compact('columns', 'table'));
        }else{
            abort(404);
        }
    }

    public function downloadExcel(Request $request){
        return Excel::download(new SmartExcelExport($request), "{$request->table}.xlsx");
    }

    public function fileUpload(string $model){
        if(in_array($model, $this->allModelInTheProject())){
            $table = (new $model)->getTable();
            return view("smart-data-export-import::import.file-upload", compact('table'));
        }else{
            abort(404);
        }
    }

    public function storeFileUpload(Request $request){
        $file = $request->file('excel_file');

        $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $file_name = Str::slug($file_name, '-');
        $file_name = $file_name.'-'.time();
        $file_name = $file_name.'.'.$extension;

        $file_name_with_location = $file->storeAs('smart-data-export-import/temp/import', $file_name);

        $headings = (new HeadingRowImport)->toArray($request->file('excel_file'));
        $headings = $headings[0][0];

        $table = $request->table;
        $columns = Schema::getColumnListing($table);

        return view("smart-data-export-import::import.configure-excel-file-with-table", compact('headings', 'columns', 'table', 'file_name_with_location'));
    }

    public function processImportExcelFile(Request $request){
        $equivalency = [];
        foreach($request->columns as $db_column => $info){
            if(isset($info['import']) && $info['import']=='yes'){
                /* 
                    Array's index is database table's column name
                    and array's value is excel file column name.

                */
                $equivalency[$db_column] = $info['equivalent'];
            }
        }
        $primary_colum = ['email'];
        self::importExcel($request->file_name_with_location, $request->table, $equivalency, $primary_colum);
        return redirect()->route('smart-data-export-import.index');
    }

    public static function importExcel($excel_file, $table, $equivalent_columns, $primary_colum = []){
        Excel::import(new SmartExcelImport($table, $equivalent_columns, $primary_colum), $excel_file);
    } 

    private function allModelInTheProject()
    {
        if(app()->version() > "7.0"){
            $namespace = "\App\\Models";
            $path = app_path('Models') ;
        }else{
            $namespace = "\App";
            $path = app_path();
        }

        $files = File::files($path);

        $filenames = array_map(function ($file): string {
            $pathinfo = pathinfo($file);

            return $pathinfo['filename'];
        }, $files);

        $mapped = array_map(
            function ($filename) use ($namespace): ?string {
                $class = "{$namespace}\\{$filename}";

                if (!class_exists($class)) {
                    return null;
                }

                $object = new $class;

                if (!$object instanceof Model) {
                    return null;
                }

                return $class;
            },
            $filenames
        );

        $skip_models = config('smart-data-export-import.skip') ? config('smart-data-export-import.skip') : [];

        $models = array_filter($mapped, function($value) use($skip_models){
            return ! in_array($value, $skip_models);
        });

        return array_values($models);
    }

    private function allTablesInDB(){
        $tables = DB::select('SHOW TABLES');
        foreach($tables as $index => $table){
            foreach ($table as $value) {
                $tables[$index] = $value;
            }
        }
        return $tables;
    }
}