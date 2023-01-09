<?php

namespace SmartWebSource\SmartDataExportImport\Imports;

use DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SmartExcelImport implements ToCollection, WithHeadingRow
{
    private $request, $table, $columns;

    public function __construct($request)
    {
        $this->request = $request;   
        $this->table = $request->table;

        $columns = [];

        foreach($this->request->columns as $name => $info){
            if(isset($info['import']) && $info['import'] == 'yes' && isset($info['equivalent'])){
               $columns[$name] = $info['equivalent'];
            }
        } 

        $this->columns = $columns;
    }
    
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $data = [];

            foreach($this->columns as $table_column => $equivalent_file_heading){
                $data[$table_column] = $row[$equivalent_file_heading];
            }

            dd($data);
            
            DB::table($this->table)->insert($data);
        }
    }
}