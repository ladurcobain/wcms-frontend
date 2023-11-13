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

class ReportDailyExcell implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    function __construct($_satker, $_year, $_month, $_day) {
        $this->_satker = $_satker;
        $this->_year = $_year;
        $this->_month = $_month;
        $this->_day = $_day;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $satker = $this->_satker;
        $year  = $this->_year;
        $month = $this->_month;
        $day = $this->_day;

        $uri = Curl::endpoint();
        $url = $uri .'/'.'activity/get-daily';
        $param = array(
            'satker_id' => $satker,
            'year'      => $year,
            'month'     => $month,
            'day'       => $day,
        );

        $arr = array();
        $res = Curl::requestPost($url, $param);
        if($res->status == true) {
            $list = $res->data;
            foreach($list as $r) {
                $arr[] = array(
                    "title"  => $day .' '. Status::monthName($month) .' '. $year .' '. $r->title,
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
            "Pukul",
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