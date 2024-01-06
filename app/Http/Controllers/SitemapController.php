<?php

namespace App\Http\Controllers;

use App\Helpers\Curl;
use Session;

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
}
