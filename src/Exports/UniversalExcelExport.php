<?php

namespace Smartwebsource\UniversalExcelDownloader\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class UniversalExcelExport implements FromCollection,WithHeadings
{
    private $table;
    private $columns;

    public function __construct($request)
    {
        $columns = [];
        $this->request = $request;
        $this->table = $request->table;

        foreach($this->request->columns as $name => $info){
            if(isset($info['export']) && $info['export'] == 'yes'){
               $columns[$name] = is_null($info['alias']) ? $name : $info['alias'];
            }
        }
        $this->columns = $columns;

    }

    public function headings(): array
    {
        return array_values($this->columns);
    }

    public function collection()
    {
        return DB::table($this->table)->select(array_keys($this->columns))->get();
    }
}
