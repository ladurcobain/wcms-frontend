<?php

namespace App\Http\Controllers;

use App\Helpers\Curl;
use App\Helpers\Status;
use Session;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $title = "Dashboard";
    private $subtitle = "";

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
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

            $resp          = $res->data;
            $count_summary = $resp->count_summary;

            $data['total_satker1'] = $count_summary->total_satker1;
            $data['total_satker2'] = $count_summary->total_satker2;
            $data['total_satker3'] = $count_summary->total_satker3;
            $data['total_satkerAll'] = $count_summary->total_satkerAll;

            $data['latest_activity']     = $resp->latest_activity;
            $data['latest_notification'] = $resp->latest_notification;
            $data['latest_rating']       = $resp->latest_rating;
            $data['latest_survey']       = $resp->latest_survey;
            
            $data['linechart'] = $resp->linechart->arr;
            $data['barchart']  = $resp->barchart->arr;
            $data['piechart']  = $resp->piechart->arr;
            $data['plotchart'] = $resp->plotchart->arr;

            return view('home', $data);
        }
    }
}
