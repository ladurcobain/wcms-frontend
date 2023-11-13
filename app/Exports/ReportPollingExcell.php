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

class ReportPollingExcell implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    function __construct($_q, $_satker, $_start, $_end) {
        $this->_q = $_q;
        $this->_satker = $_satker;
        $this->_start = $_start;
        $this->_end = $_end;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $q = $this->_q;
        $satker = $this->_satker;
        $start = $this->_start;
        $end = $this->_end;

        $uri = Curl::endpoint();
        $url = $uri .'/'.'activity/get-rating';
        $param = array(
            'limit'     => 1000,
            'offset'    => 0,
            'satker_id' => $satker,
            'user_id'   => Session::get('user_id'),
            'start'     => Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d'),
            'end'       => Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d'),
            'ip'        => (($q == null)?"":$q),
        );

        $arr = array();
        $res = Curl::requestPost($url, $param);
        if($res->data != "[]") {
            $temp = $res->data->lists;
            foreach($temp as $r) {
                $arr[] = array(
                    "rating_date"        => $r->rating_date,
                    "rating_time"        => $r->rating_time,
                    "rating_satker"      => $r->rating_satker,
                    "rating_ip"          => $r->rating_ip,
                    "rating_value"       => $r->rating_value,
                    "rating_description" => $r->rating_description,
                );
            }
        }
        
        $data = $arr;
        return collect($data);
    }
    public function headings(): array
    {
        return [
            "Tanggal",
            "Pukul",
            "Satuan Kerja",
            "Alamat IP",
            "Penilaian",
            "Keterangan",
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:F1'; // All headers
                
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