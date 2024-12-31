<?php

namespace App\Http\Controllers;
use App\Helpers\Curl;
use App\Helpers\Status;
use Session;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SitemapExcell;

class SitemapController extends Controller
{
    private $title = "Sitemap";
    private $subtitle = "";

    public function index()
    {
        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;

        $uri = Curl::endpoint();
        $url = $uri .'/'.'active/get-satker';
        $res = Curl::requestGet($url);
        
        $data['status']  = $res->status;
        $data['message'] = $res->message;
        $data['list']    = $res->data;
        
        return view('sitemap', $data);
    }

    public function excell(Request $request)
    {
        return Excel::download(new SitemapExcell(), 'satkers.xlsx');
    }
}
