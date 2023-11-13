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

class ReportContactusExcell implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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
        $url = $uri .'/'.'activity/get-contactus';
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
                    "contactus_date"    => $r->contactus_date,
                    "contactus_time"    => $r->contactus_time,
                    "contactus_satker"  => $r->contactus_satker,
                    "contactus_name"    => $r->contactus_name,
                    "contactus_email"   => $r->contactus_email,
                    "contactus_subject" => $r->contactus_subject,
                    "contactus_message" => $r->contactus_message,
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
            "Nama Lengkap",
            "Alamat Surel",
            "Subyek",
            "Isi Pesan",
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:G1'; // All headers
                
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