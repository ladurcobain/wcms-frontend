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

class UserExcell implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    function __construct($_type, $_name) {
        $this->_type = $_name;
        $this->_name = $_type;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $name = $this->_name;
        $type = $this->_type;

        $uri = Curl::endpoint();
        $url = $uri .'/'.'active/get-user';
        $param = array(
            'name' => $name,
            'type' => $type
        );

        $arr = array();
        $res = Curl::requestPost($url, $param);
        if($res->data != "[]") {
            $temp = $res->data;
            foreach($temp as $r) {
                $arr[] = array(
                    'type'          => Status::tipeUser($r->user_type),
                    'username'      => $r->user_account,
                    //'password'      => $r->user_password,
                    'fullname'      => $r->user_fullname,
                    //'code'          => $r->user_code,
                    //'phone'         => $r->user_phone,
                    'email'         => $r->user_email,
                    //'address'       => $r->user_address,
                    'lastactivity'  => $r->user_activity,
                    'lastlogin'     => $r->user_login,
                );
            }
        }
        
        $data = $arr;
        return collect($data);
    }
    public function headings(): array
    {
        return [
            "Tipe",
            "Nama Akun",
            //"Password",
            "Nama Lengkap",
            //"NIK",
            //"No. Telepon",
            "Email",
            //"Alamat",
            "Aktivitas Terakhir",
            "Akses Terakhir",
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:I1'; // All headers
                
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