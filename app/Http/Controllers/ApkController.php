<?php

namespace App\Http\Controllers;

class ApkController extends Controller
{
    private $title = "Scan Apk Android";
    private $subtitle = "";

    public function index()
    {
        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;
        
        return view('apk', $data);
    }
}
