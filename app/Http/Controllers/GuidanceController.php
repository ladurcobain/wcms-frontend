<?php

namespace App\Http\Controllers;
use App\Helpers\Curl;
use Session;

class GuidanceController extends Controller
{
    private $title = "Dokumen Panduan";
    private $subtitle = "";

    public function index()
    {
        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;
       
        $uri = Curl::endpoint();
        $url = $uri .'/'.'active/get-tutorial';
        $res = Curl::requestGet($url);

        if($res->status == true) {
            $data['status']  = $res->status;
            $data['message'] = $res->message;
            $data['list']    = $res->data; 
        }
        else {
            $data['list'] = array(); 
            Session::flash('alrt', 'error');    
            Session::flash('msgs', $res->message);   
        }

        return view('guidance', $data);
    }
}
