<?php

namespace SmartWebSource\SmartDataExportImport\Http\Controllers;

use SmartWebSource\SmartDataExportImport\Exports\SmartExcelExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Excel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

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

        $models = array_filter($mapped);

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