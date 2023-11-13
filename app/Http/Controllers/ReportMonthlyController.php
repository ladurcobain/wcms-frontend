<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Helpers\Module;
use App\Helpers\Curl;
use App\Helpers\Status;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportMonthlyExcell;

class ReportMonthlyController extends Controller
{
    private $title = "Laporan";
    private $subtitle = "Kunjungan Perbulan";
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {
        // unset session
		Session::forget('satker');
        Session::forget('year');
        Session::forget('month');

        return redirect()->route('monthly.search');
	}

    public function search()
    {
        if(Session::get('user_type') == 2) {
            if(Session::get('satker') == "") {
                $satker = Session::get('satker_id'); 
            }
            else {
                $satker = Session::get('satker'); 
            }

            $data['satkers'] = Module::getLevelingSatker(Session::get('satker_id'));
        }
        else {
            $satker = Session::get('satker');  
            $data['satkers'] = Module::getActiveSatker();
        }

        $data['years'] = Status::generateYear();
        $year  = Session::get('year');  
        $month = Session::get('month');  
        
        $now = Carbon::now();     
        $yearNow  = Carbon::createFromFormat('Y-m-d H:i:s', $now)
                    ->format('Y'); 
        $monthNow  = Carbon::createFromFormat('Y-m-d H:i:s', $now)
                    ->format('m'); 

        $year = (($year == "")?$yearNow:$year);
        $month = (($month == "")?$monthNow:$month);
        
        $data['satker'] = $satker;
        $data['year']  = $year;
        $data['month'] = $month;
        
        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;
       
        $uri = Curl::endpoint();
        $url = $uri .'/'.'activity/get-monthly';
        $param = array(
            'satker_id' => $satker,
            'year'      => (($year == null)?"":$year),
            'month'     => (($month == null)?"":$month),
        );

        $res = Curl::requestPost($url, $param);
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
        
        return view('report.monthly.index', $data);
    }

    public function filter(Request $request)
    {
        if($request->has('_token')) {
            $satker = $request->satker;
            $year   = $request->year;
            $month  = $request->month;
            
            Session::put('satker', $satker); 
            Session::put('year', $year); 
            Session::put('month', $month); 
            
            return redirect()->route('monthly.search');
        } else {
            return redirect()->route('monthly.index');
        }
    }

    public function excell(Request $request)
    {
        return Excel::download(new ReportMonthlyExcell($request->_satker, $request->_year, $request->_month), 'laporan-kunjungan-perbulan.xlsx');
    }

    public function download(Request $request)
    {
        $satker = $request->_satker;
        $year  = $request->_year;
        $month = $request->_month;

        $uri = Curl::endpoint();
        $url = $uri .'/'.'activity/get-monthly';
        $param = array(
            'satker_id' => $satker,
            'year'      => $year,
            'month'     => $month
        );

        $res = Curl::requestPost($url, $param);
        if($res->status == true) {
            $data['list']    = $res->data->lists; 
        }
        else {
            Session::flash('alrt', 'error');    
            Session::flash('msgs', $res->message);  
            
            return redirect()->route('monthly.search');
        }
    }
}
