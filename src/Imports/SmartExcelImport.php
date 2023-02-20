<?php

namespace SmartWebSource\SmartDataExportImport\Imports;

use DB;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToModel;

// class SmartExcelImport implements ToCollection, WithHeadingRow
class SmartExcelImport implements ToModel, WithHeadingRow
{
    private $table, $columns, $primary_column, $processing_data, $niddle, $count, $success;

    public function __construct($table, $equivalent_columns, $primary_column)
    {  
        $this->table = $table;

        $this->columns = $equivalent_columns;

        $this->primary_column = $primary_column;

        $this->count = 0;

        $this->success = 0;
    }
    
    // public function collection(Collection $rows)
    // {   
        // $count = 0;
    //     $success = 0;
    //     foreach ($rows as $row) 
    //     {
    //         dd($rows);
    //         ++$count;

    //         foreach($this->columns as $table_column => $equivalent_file_heading){
    //             $this->processing_data[$table_column] = $row[$equivalent_file_heading];
    //         }

    //         if(count($this->primary_column)){
    //             foreach($this->primary_column as $column){
    //                 $this->niddle[$column] = $this->processing_data[$column];
    //             }
    //         }

    //         try{
    //             DB::table($this->table)->updateOrInsert($this->niddle, $this->processing_data);
    //             ++$success;
    //         }catch(Exception|QueryException $exception){
    //             $message = "smart-data-export-import: Importing data error. Message: {$exception->getMessage()}. Data:\n".json_encode($this->processing_data);
    //             Log::warning($message);
    //         }  

    //         $message = "Excel import has been completed. {$success} rows are successfully imported out of {$count}.";
    //         Session::put(['smart-data-export-import-message' => $message]);
    //     }
    // }

    public function model(array $row)
    {
        ++$this->count;

        foreach($this->columns as $table_column => $equivalent_file_heading){
            $this->processing_data[$table_column] = $row[$equivalent_file_heading];
        }

        if(count($this->primary_column)){
            foreach($this->primary_column as $column){
                $this->niddle[$column] = $this->processing_data[$column];
            }
        }

        try{
            DB::table($this->table)->updateOrInsert($this->niddle, $this->processing_data);
            ++$this->success;
        }catch(Exception|QueryException $exception){
            $message = "smart-data-export-import: Importing data error. Message: {$exception->getMessage()}. Data:\n".json_encode($this->processing_data);
            Log::warning($message);
        }  

        $message = "Excel import has been completed. {$this->success} rows are successfully imported out of {$this->count}.";
        Session::put(['smart-data-export-import-message' => $message]);
    }
}