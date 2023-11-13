<?php

namespace App\Http\Controllers;
use App\Helpers\Curl;
use Session;
use PDF;

class IntegrationController extends Controller
{
    private $title = "Integration API";
    private $subtitle = "";

    public function index()
    {
        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;
       
        $uri = Curl::endpoint();
        $url = $uri .'/'.'active/get-integration';
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

        return view('integration', $data);
    }

    public function download()
    {
    	$uri = Curl::endpoint();
        $url = $uri .'/'.'active/get-integration';
        $res = Curl::requestGet($url);

        if($res->status == true) {
            $list    = $res->data; 
        }
        else {
            $list = array();  
        }
        
        $pdf = PDF::loadview('integration_pdf', ['list'=>$list]);
        return $pdf->download('integration-api.pdf');
    }
}
