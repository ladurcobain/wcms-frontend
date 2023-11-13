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
use App\Exports\ReportSummaryExcell;

class ReportSummaryController extends Controller
{
    private $title = "Laporan";
    private $subtitle = "Kunjungan Persatker";
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {
        // unset session
		Session::forget('satker');
        return redirect()->route('summary.search');
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

        $data['satker'] = $satker;

        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;
       
        $uri = Curl::endpoint();
        $url = $uri .'/'.'activity/get-summary';
        $param = array(
            'satker_id' => $satker,
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
        
        return view('report.summary.index', $data);
    }

    public function filter(Request $request)
    {
        if($request->has('_token')) {
            $satker = $request->satker;
            Session::put('satker', $satker); 
            
            return redirect()->route('summary.search');
        } else {
            return redirect()->route('summary.index');
        }
    }

    public function excell(Request $request)
    {
        return Excel::download(new ReportSummaryExcell($request->_satker), 'laporan-kunjungan-persatker.xlsx');
    }

    public function download(Request $request)
    {
        $satker = $request->_satker;

        $uri = Curl::endpoint();
        $url = $uri .'/'.'activity/get-summary';
        $param = array(
            'satker_id' => $satker,
        );

        $res = Curl::requestPost($url, $param);
        if($res->status == true) {
            $data['list']    = $res->data->lists; 
        }
        else {
            Session::flash('alrt', 'error');    
            Session::flash('msgs', $res->message);  
            
            return redirect()->route('summary.success');
        }
    }
}
