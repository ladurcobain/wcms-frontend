<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Helpers\Curl;
use App\Helpers\Status;
use Illuminate\Http\Request;
use Session;
use DB;
use Carbon\Carbon;

class ReportAnnuallyExcell implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    function __construct($_satker, $_year) {
        $this->_satker = $_satker;
        $this->_year = $_year;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $satker = $this->_satker;
        $year = $this->_year;

        $uri = Curl::endpoint();
        $url = $uri .'/'.'activity/get-annually';
        $param = array(
            'satker_id' => $satker,
            'year'      => $year,
        );

        $arr = array();
        $res = Curl::requestPost($url, $param);
        if($res->status == true) {
            $list = $res->data;
            foreach($list as $r) {
                $arr[] = array(
                    "title"  => $r->title .' '. $year,
                    "count"  => number_format($r->count),
                );
            }
        }
        
        $data = $arr;
        return collect($data);
    }
    public function headings(): array
    {
        return [
            "Nama Bulan",
            "Jumlah",
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:B1'; // All headers
                
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(20);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange)
                    ->getAlignment()->setWrapText(true);

                $event->sheet->getDelegate()->getStyle($cellRange)
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('88888888');
            },
        ];
    }
}