<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Helpers\Module;
use App\Helpers\Curl;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportPollingExcell;

class ReportPollingController extends Controller
{
    private $title = "Laporan";
    private $subtitle = "Indeks Kepuasan";
    private $path = 'report/polling/search';
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {
        // unset session
		Session::forget('q');  
        Session::forget('satker');
        Session::forget('start');
        Session::forget('end');

        return redirect()->route('polling.search');
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

        $q = Session::get('q');  
        $start = Session::get('start');   
        $end = Session::get('end');

        $now = Carbon::now();
        $firstDay = $now->firstOfMonth(); 
        $startDay = Carbon::createFromFormat('Y-m-d H:i:s', $firstDay)
                    ->format('d-m-Y'); 
        $lastDay = $now->lastOfMonth();        
        $endDay  = Carbon::createFromFormat('Y-m-d H:i:s', $lastDay)
                    ->format('d-m-Y'); 

        $start = (($start == "")?$startDay:$start);
        $end   = (($end == "")?$endDay:$end);
        
        $data['q'] = $q;
        $data['satker'] = $satker;
        $data['start'] = $start;
        $data['end'] = $end;
        
        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;
       
        $page = request()->has('page') ? request('page') : 1;
        $perPage = request()->has('per_page') ? request('per_page') : 10;
        $offset = ($page * $perPage) - $perPage;

        $uri = Curl::endpoint();
        $url = $uri .'/'.'activity/get-rating';
        $param = array(
            'limit'     => $perPage,
            'offset'    => $offset,
            'satker_id' => $satker,
            'user_id'   => Session::get('user_id'),
            'start'     => Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d'),
            'end'       => Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d'),
            'ip'        => (($q == null)?"":$q),
        );

        $res = Curl::requestPost($url, $param);

        $newCollection = collect($res->data->lists);
        $results =  new LengthAwarePaginator(
            $newCollection,
            $res->data->total,
            $perPage,
            $page,
            ['path' => url($this->path)]
        );
        
        return view('report.polling.index', $data, compact('results'));
    }

    public function filter(Request $request)
    {
        if($request->has('_token')) {
            $q      = $request->q;
            $satker = $request->satker;
            $start  = $request->start;
            $end    = $request->end;

            Session::put('q', $q); 
            Session::put('satker', $satker); 
            Session::put('start', $start); 
            Session::put('end', $end); 
            
            return redirect()->route('polling.search');
        } else {
            return redirect()->route('polling.index');
        }
    }

    public function destroy($id)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'rating/delete-data';
        
        $param = array(
            'rating_id' => $id,
            'last_user' => Session::get('user_id'),
        );
            
        $res = Curl::requestPost($url, $param);
        
        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return redirect()->route('polling.search');
    }

    public function detail($id)
    {
        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;
        
        $uri = Curl::endpoint();
        $url = $uri .'/'.'rating/get-single';
        
        $param = array(
            'rating_id' => $id,
        );
            
        $res = Curl::requestPost($url, $param);
        
        if($res->status == true) {
            if(Session::get('user_type') == 2) {
                if(Session::get('satker_id') != $res->data->satker_id) {
                    Session::flash('alrt', 'error');    
                    Session::flash('msgs', 'Data tidak ditemukan'); 
                    
                    return redirect()->route('polling.index');
                }
            }

            $data['status']  = $res->status;
            $data['message'] = $res->message;
            $data['info']    = $res->data; 

            return view('report.polling.detail', $data);
        }
        else {
            Session::flash('alrt', 'error');    
            Session::flash('msgs', $res->message);  
            
            return redirect()->route('polling.polling');
        }
    }

    public function excell(Request $request)
    {
        return Excel::download(new ReportPollingExcell($request->_q, $request->_satker, $request->_start, $request->_end), 'laporan-indeks-kepuasan.xlsx');
    }

    public function download(Request $request)
    {
        $q = $request->_q;
        $satker = $request->_satker;
        $start = $request->_start;
        $end = $request->_end;

        $uri = Curl::endpoint();
        $url = $uri .'/'.'activity/get-rating';
        $param = array(
            'satker_id' => $satker,
            'user_id'   => Session::get('user_id'),
            'start'     => Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d'),
            'end'       => Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d'),
            'limit'     => 1000,
            'offset'    => 0,
            'ip'        => $q
        );

        $res = Curl::requestPost($url, $param);
        if($res->status == true) {
            $data['list']    = $res->data->lists; 
        }
        else {
            Session::flash('alrt', 'error');    
            Session::flash('msgs', $res->message);  
            
            return redirect()->route('polling.search');
        }
    }
}
