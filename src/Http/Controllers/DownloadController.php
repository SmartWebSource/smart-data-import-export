<?php

namespace Smartwebsource\UniversalExcelDownloader\Http\Controllers;

use Smartwebsource\UniversalExcelDownloader\Exports\UniversalExcelExport;
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
        return view("universal-excel-downloader::table", compact('tables'));
    }

    public function tableColumns(string $table){
        if(Schema::hasTable($table)){
            $columns = Schema::getColumnListing($table);
            return view("universal-excel-downloader::column-form", compact('columns', 'table'));
        }else{
            abort(404);
        }
    }

    public function downloadExcel(Request $request){
        return Excel::download(new UniversalExcelExport($request), "{$request->table}.xlsx");
    }

    private function allModelInTheProject(){
        
    }
}