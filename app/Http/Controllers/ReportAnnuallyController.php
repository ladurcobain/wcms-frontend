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
use App\Exports\ReportAnnuallyExcell;

class ReportAnnuallyController extends Controller
{
    private $title = "Laporan";
    private $subtitle = "Kunjungan Pertahun";
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {
        // unset session
		Session::forget('satker');
        Session::forget('year');

        return redirect()->route('annually.search');
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
        $year = Session::get('year');  
        
        $now = Carbon::now();     
        $yearNow  = Carbon::createFromFormat('Y-m-d H:i:s', $now)
                    ->format('Y'); 

        $year = (($year == "")?$yearNow:$year);
        
        $data['satker'] = $satker;
        $data['year'] = $year;
        
        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;
       
        $uri = Curl::endpoint();
        $url = $uri .'/'.'activity/get-annually';
        $param = array(
            'satker_id' => $satker,
            'year'      => (($year == null)?"":$year),
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
        
        return view('report.annually.index', $data);
    }

    public function filter(Request $request)
    {
        if($request->has('_token')) {
            $satker = $request->satker;
            $year   = $request->year;
            
            Session::put('satker', $satker); 
            Session::put('year', $year); 
            
            return redirect()->route('annually.search');
        } else {
            return redirect()->route('annually.index');
        }
    }

    public function excell(Request $request)
    {
        return Excel::download(new ReportAnnuallyExcell($request->_satker, $request->_year), 'laporan-kunjungan-pertahun.xlsx');
    }

    public function download(Request $request)
    {
        $satker = $request->_satker;
        $year = $request->_year;

        $uri = Curl::endpoint();
        $url = $uri .'/'.'activity/get-annually';
        $param = array(
            'satker_id' => $satker,
            'year'      => $year
        );

        $res = Curl::requestPost($url, $param);
        if($res->status == true) {
            $data['list']    = $res->data->lists; 
        }
        else {
            Session::flash('alrt', 'error');    
            Session::flash('msgs', $res->message);  
            
            return redirect()->route('annually.search');
        }
    }
}
