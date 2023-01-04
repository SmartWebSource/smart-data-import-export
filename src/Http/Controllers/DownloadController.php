<?php

namespace Smartwebsource\SmartDataExportImport\Http\Controllers;

use Smartwebsource\SmartDataExportImport\Exports\SmartExcelExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Excel;

class DownloadController extends Controller
{    
    public function tables()
    {
        $tables = DB::select('SHOW TABLES');
        foreach($tables as $index => $table){
            foreach ($table as $key => $value) {
                $tables[$index] = $value;
            }
        }
        return view("smart-data-export-import::table", compact('tables'));
    }

    public function tableColumns(string $table){
        if(Schema::hasTable($table)){
            $columns = Schema::getColumnListing($table);
            return view("smart-data-export-import::column-form", compact('columns', 'table'));
        }else{
            abort(404);
        }
    }

    public function downloadExcel(Request $request){
        return Excel::download(new SmartExcelExport($request), "{$request->table}.xlsx");
    }

    private function allModelInTheProject(){
        
    }
}