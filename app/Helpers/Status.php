<?php

namespace App\Helpers;
use Carbon\Carbon;

class Status
{
    public static function tipeUser($type)
    {
        switch($type) {
            case 1 : 
                $string = "Administrator";
            break;
            case 2 : 
                $string = "Operator";
            break;
            
            default : 
                $string = "Administrator";
            break;
        }

        return $string;
    }

    public static function tipeStatus($type)
    {
        switch($type) {
            case 1 : 
                $string = "Aktif";
            break;
            case 2 : 
                $string = "Tdk Aktif";
            break;

            default : 
                $string = "Tdk Aktif";
            break;
        }

        return $string;
    }

    public static function tipeNews($type)
    {
        switch($type) {
            case 1 : 
                $string = "Diterbitkan";
            break;
            case 2 : 
                $string = "Diturunkan";
            break;

            default : 
                $string = "Diturunkan";
            break;
        }

        return $string;
    }

    public static function tipeSatker($type)
    {
        switch($type) {
            case 0 : 
                $string = "Kejagung";
            break;
            case 1 : 
                $string = "Kejati";
            break;
            case 2 : 
                $string = "Kejari";
            break;
            case 3 : 
                $string = "Cabjari";
            break;
            case 4 : 
                $string = "Badiklat";
            break;

            default : 
                $string = "-";
            break;
        }

        return $string;
    }

    public static function tipeVideo($type)
    {
        switch($type) {
            case 1 : 
                $string = "Semat Tautan";
            break;
            case 2 : 
                $string = "Unggah berkas";
            break;
            
            default : 
                $string = "Semat Tautan";
            break;
        }

        return $string;
    }

    public static function categoryNews($type)
    {
        switch($type) {
            case 1 : 
                $string = "Berita";
            break;
            case 2 : 
                $string = "Pengumuman";
            break;
            case 3 : 
                $string = "Kegiatan";
            break;
            case 4 : 
                $string = "Artikel";
            break;
            case 5 : 
                $string = "Siaran Pers";
            break;
            
            default : 
                $string = "Berita";
            break;
        }

        return $string;
    }

    public static function categoryNewsId($type)
    {
        switch($type) {
            case "Berita" : 
                $string = 1;
            break;
            case "Pengumuman" : 
                $string = 2;
            break;
            case "Kegiatan" : 
                $string = 3;
            break;
            case "Artikel" : 
                $string = 4;
            break;
            case "Siaran Pers" : 
                $string = 5;
            break;
            
            default : 
                $string = 1;
            break;
        }

        return $string;
    }

    public static function generateYear()
    {
        $now = Carbon::now();
        $yearNow  = Carbon::createFromFormat('Y-m-d H:i:s', $now)->format('Y'); 
        
        $arr = array();
        for($i=0; $i<=2; $i++) {
            $arr[] = intval($yearNow) - $i;
        }
        
        return $arr;
    }

    public static function generateStar($val)
    {
        $string = '';
        $string .= '<div class="stars-wrapper">';

        if($val >= 5) {
            $string .= '<i class="fas fa-star" style="color: orange;"></i>';
            $string .= '<i class="fas fa-star" style="color: orange;"></i>';
            $string .= '<i class="fas fa-star" style="color: orange;"></i>';
            $string .= '<i class="fas fa-star" style="color: orange;"></i>';
            $string .= '<i class="fas fa-star" style="color: orange;"></i>';
        } 
        else if(($val >= 4.5) && ($val < 5)) {
            $string .= '<i class="fas fa-star" style="color: orange;"></i>';
            $string .= '<i class="fas fa-star" style="color: orange;"></i>';
            $string .= '<i class="fas fa-star" style="color: orange;"></i>';
            $string .= '<i class="fas fa-star" style="color: orange;"></i>';
            $string .= '<i class="fas fa-star-half" style="color: orange;"></i>';
        }  
        else if(($val >= 4) && ($val < 4.5)) {
            $string .= '<i class="fas fa-star" style="color: orange;"></i>';
            $string .= '<i class="fas fa-star" style="color: orange;"></i>';
            $string .= '<i class="fas fa-star" style="color: orange;"></i>';
            $string .= '<i class="fas fa-star" style="color: orange;"></i>';
            $string .= '<i class="fas fa-star"></i>';
        } 
        else if(($val >= 3.5) && ($val < 4)) {
            $string .= '<i class="fas fa-star" style="color: orange;"></i>';
            $string .= '<i class="fas fa-star" style="color: orange;"></i>';
            $string .= '<i class="fas fa-star" style="color: orange;"></i>';
            $string .= '<i class="fas fa-star-half" style="color: orange;"></i>';
            $string .= '<i class="fas fa-star"></i>';
        }    
        else if(($val >= 3) && ($val < 3.5)) {
            $string .= '<i class="fas fa-star" style="color: orange;"></i>';
            $string .= '<i class="fas fa-star" style="color: orange;"></i>';
            $string .= '<i class="fas fa-star" style="color: orange;"></i>';
            $string .= '<i class="fas fa-star"></i>';
            $string .= '<i class="fas fa-star"></i>';
        } 
        else if(($val >= 2.5) && ($val < 3)) {
            $string .= '<i class="fas fa-star" style="color: orange;"></i>';
            $string .= '<i class="fas fa-star" style="color: orange;"></i>';
            $string .= '<i class="fas fa-star-half" style="color: orange;"></i>';
            $string .= '<i class="fas fa-star"></i>';
            $string .= '<i class="fas fa-star"></i>';
        }  
        else if(($val >= 2) && ($val < 2.5)) {
            $string .= '<i class="fas fa-star" style="color: orange;"></i>';
            $string .= '<i class="fas fa-star" style="color: orange;"></i>';
            $string .= '<i class="fas fa-star"></i>';
            $string .= '<i class="fas fa-star"></i>';
            $string .= '<i class="fas fa-star"></i>';
        } 
        else if(($val >= 1.5) && ($val < 2)) {
            $string .= '<i class="fas fa-star" style="color: orange;"></i>';
            $string .= '<i class="fas fa-star-half" style="color: orange;"></i>';
            $string .= '<i class="fas fa-star"></i>';
            $string .= '<i class="fas fa-star"></i>';
            $string .= '<i class="fas fa-star"></i>';
        }
        else if(($val >= 1) && ($val < 1.5)) {
            $string .= '<i class="fas fa-star" style="color: orange;"></i>';
            $string .= '<i class="fas fa-star"></i>';
            $string .= '<i class="fas fa-star"></i>';
            $string .= '<i class="fas fa-star"></i>';
            $string .= '<i class="fas fa-star"></i>';
        } 
        else if(($val >= 0.5) && ($val < 1)) {
            $string .= '<i class="fas fa-star-half" style="color: orange;"></i>';
            $string .= '<i class="fas fa-star"></i>';
            $string .= '<i class="fas fa-star"></i>';
            $string .= '<i class="fas fa-star"></i>';
            $string .= '<i class="fas fa-star"></i>';
        }
        else {
            $string .= '<i class="fas fa-star"></i>';
            $string .= '<i class="fas fa-star"></i>';
            $string .= '<i class="fas fa-star"></i>';
            $string .= '<i class="fas fa-star"></i>';
            $string .= '<i class="fas fa-star"></i>';
        }

        $string .= '</div>';
        return $string;
    }

    public static function generateColor($val) {
        switch($val) {
            case 1 : 
                $string = "#734ba9";
            break;
            case 2 : 
                $string = "#2baab1";
            break;
            case 3 : 
                $string = "#0088cc";
            break;
            case 4 : 
                $string = "#e2a917";
            break;
            case 5 : 
                $string = "#e36159";
            break;
            default : 
                $string = "#EA4C89";
            break;
        }

        return $string;
    }

    public static function convertHtmlToText($str) {
        $str = strip_tags($str);
        $str = utf8_decode($str);
        $str = str_replace("&nbsp;", " ", $str);
        $str = preg_replace('/\s+/', ' ',$str);
        $str = trim($str);

        return $str;
    }

    public static function str_ellipsis($text, $length) {
        $text = Status::convertHtmlToText($text);
        if(strlen($text) > $length) {
            $str = substr($text, 0, $length) ." ...";
        }
        else {
            $str = $text;
        }

        return $str;
    }

    public static function medsosIcon($value) {
        switch($value) {
            case 1 :
                $string = '<i class="fab fa-facebook"></i>';
            break;
            case 2 :
                $string = '<i class="fab fa-twitter"></i>';
            break;
            case 3 :
                $string = '<i class="fab fa-instagram"></i>';
            break;
            case 4 :
                $string = '<i class="fab fa-youtube"></i>';
            break;
            case 5 :
                $string = '<i class="fab fa-linkedin"></i>';
            break;
            
            default :
                $string = '<i class="fab fa-facebook"></i>';
            break;
        }
        
        return $string;
    }

    public static function medsosName($value) {
        switch($value) {
            case 1 :
                $string = 'Facebook';
            break;
            case 2 :
                $string = 'Twitter';
            break;
            case 3 :
                $string = 'Instagram';
            break;
            case 4 :
                $string = 'Youtube';
            break;
            case 5 :
                $string = 'Linkedin';
            break;
            
            default :
                $string = 'Facebook';
            break;
        }

        return $string;
    }

    public static function monthName($value) {
        switch($value) {
            case "01" :
                $string = 'Januari';
            break;
            case "02" :
                $string = 'Februari';
            break;
            case "03" :
                $string = 'Maret';
            break;
            case "04" :
                $string = 'April';
            break;
            case "05" :
                $string = 'Mei';
            break;
            case "06" :
                $string = 'Juni';
            break;
            case "07" :
                $string = 'Juli';
            break;
            case "08" :
                $string = 'Agustus';
            break;
            case "09" :
                $string = 'September';
            break;
            case "10" :
                $string = 'Oktober';
            break;
            case "11" :
                $string = 'November';
            break;
            case "12" :
                $string = 'Desember';
            break;
            
            default :
                $string = '-';
            break;
        }

        return $string;
    }

    public static function loadingOverlay($value) {
        switch($value) {
            case 1 :
                $string = 'Percentage Progress 1';
            break;
            case 2 :
                $string = 'Percentage Progress 2';
            break;
            case 3 :
                $string = 'Cubes';
            break;
            case 4 :
                $string = 'Cube Progress';
            break;
            case 5 :
                $string = 'Float Rings';
            break;
            case 6 :
                $string = 'Float Bars';
            break;
            case 7 :
                $string = 'Speeding Wheel';
            break;
            case 8 :
                $string = 'Zenith';
            break;
            case 9 :
                $string = 'Spinning Square';
            break;
            case 10 :
                $string = 'Pulse';
            break;
            
            default :
                $string = 'Default';
            break;
        }

        return $string;
    }

    public static function shortNumber($value) {
        $number = str_replace(",", "", $value);
        
        $number = (int) preg_replace('/[^0-9]/', '', $number);
        if ($number >= 1000) {
            $rn = round($number);
            $format_number = number_format($rn);
            $ar_nbr = explode(',', $format_number);
            $x_parts = array('K', 'M', 'B', 'T', 'Q');
            $x_count_parts = count($ar_nbr) - 1;
            $dn = $ar_nbr[0] . ((int) $ar_nbr[1][0] !== 0 ? '.' . $ar_nbr[1][0] : '');
            $dn .= $x_parts[$x_count_parts - 1];

            return $dn;
        }
        
        return $number;
    }
}
