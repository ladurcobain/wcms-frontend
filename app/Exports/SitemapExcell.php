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

class SitemapExcell implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    function __construct() {
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'active/get-satker';
        
        $arr = array();
        $res = Curl::requestGet($url);
        if($res->data != "[]") {
            $temp = $res->data;
            foreach($temp as $r) {
                $arr[] = array(
                    //'type'        => Status::tipeSatker($r->satker_type),
                    'code'        => $r->satker_code,
                    'name'        => $r->satker_name,
                    'slug'        => $r->satker_slug,
                    'akronim'     => $r->satker_akronim,
                    'url'         => $r->satker_url,
                    //'link'        => $r->satker_link,
                    //'description' => $r->satker_description,
                    'folder'      => str_replace(" ","", strtolower($r->satker_description)),
                    'version'     => $r->satker_version,
                );
            }
        }
        
        $data = $arr;
        return collect($data);
    }
    public function headings(): array
    {
        return [
            //"Tipe",
            "Kode",
            "Nama",
            "Slug",
            "Akronim",
            "Url",
            //"Link",
            //"Keterangan",
            "Folder",
            "Versi",
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:J1'; // All headers
                
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