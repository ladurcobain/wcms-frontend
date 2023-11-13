<?php

namespace App\Http\Controllers;

use App\Helpers\Curl;
use App\Helpers\Status;
use Carbon\Carbon;
use Session;

class DashboardController extends Controller
{
    private $title = "Beranda";
    private $subtitle = "";

    public function index()
    {
        if(Session::get('login') == TRUE) {
            $data['title'] = $this->title;
            $data['subtitle'] = $this->subtitle;

            $uri = Curl::endpoint();
            $url = $uri .'/'.'activity/get-dashboard';
            $param = array(
                'user_id' => Session::get('user_id')
            );

            $res = Curl::requestPost($url, $param);

            $data['status']  = $res->status;
            $data['message'] = $res->message;

            $now = Carbon::now();
            //$data['year']  = Carbon::createFromFormat('Y-m-d H:i:s', $now)->format('m');
            $data['month'] = Carbon::createFromFormat('Y-m-d H:i:s', $now)->format('m');
            //$data['day']   = Carbon::createFromFormat('Y-m-d H:i:s', $now)->format('d');

            $resp          = $res->data;

            //$data['latest_activity']     = $resp->latest_activity;
            //$data['latest_notification'] = $resp->latest_notification;
            $data['article']             = $resp->article;
            $data['news_latest']         = $resp->news_latest;
            //$data['news_popular']        = $resp->news_popular;
            $data['latest_rating']       = $resp->latest_rating;
            //$data['latest_survey']       = $resp->latest_survey;
            
            //$data['linechart']   = $resp->linechart->arr;
            $data['barchart']    = $resp->barchart->arr;
            $data['piechart']    = $resp->piechart->arr;
            $data['plotchart']   = $resp->plotchart->arr;
            $data['visitor']     = $resp->visitor;
            //$data['filemanager'] = $resp->filemanager;
            return view('dashboard', $data);
        }
    }
}
