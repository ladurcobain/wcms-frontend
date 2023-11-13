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
use App\Exports\ReportVisitorExcell;

class ReportArticleController extends Controller
{
    private $title = "Laporan";
    private $subtitle = "Konten Berita";
    private $path = 'report/article/search';
    
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
        Session::forget('status');
        Session::forget('category');  

        return redirect()->route('article.search');
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
        $status = Session::get('status');
        $category = Session::get('category');

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
        $data['status'] = $status;
        $data['category'] = $category;
        
        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;
       
        $page = request()->has('page') ? request('page') : 1;
        $perPage = request()->has('per_page') ? request('per_page') : 10;
        $offset = ($page * $perPage) - $perPage;

        $uri = Curl::endpoint();
        $url = $uri .'/'.'activity/get-article';
        $param = array(
            'limit'     => $perPage,
            'offset'    => $offset,
            'satker_id' => $satker,
            'status'    => $status,
            'user_id'   => Session::get('user_id'),
            'start'     => Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d'),
            'end'       => Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d'),
            'category'  => (($category == null)?"":$category),
            'title'     => (($q == null)?"":$q),
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
        
        return view('report.article.index', $data, compact('results'));
    }

    public function filter(Request $request)
    {
        if($request->has('_token')) {
            $q        = $request->q;
            $satker   = $request->satker;
            $start    = $request->start;
            $end      = $request->end;
            $status   = $request->status;
            $category = $request->category;

            Session::put('q', $q); 
            Session::put('satker', $satker); 
            Session::put('start', $start); 
            Session::put('end', $end);
            Session::put('status', $status); 
            Session::put('category', $category); 
            
            return redirect()->route('article.search');
        } else {
            return redirect()->route('article.index');
        }
    }

    public function excell(Request $request)
    {
        return Excel::download(new ReportVisitorExcell($request->_q, $request->_satker, $request->_start, $request->_end), 'laporan-statistik-kunjungan.xlsx');
    }

    public function download(Request $request)
    {
        $q = $request->_q;
        $satker = $request->_satker;
        $start = $request->_start;
        $end = $request->_end;

        $uri = Curl::endpoint();
        $url = $uri .'/'.'activity/get-visitor';
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
            
            return redirect()->route('article.search');
        }
    }

    public function status($id)
    {
        if($id == '9') {
            return redirect()->route('article.index');
        }
        else if($id == '1') {
            Session::put('status', 1); 
        }
        else {
            Session::put('status', 0); 
        }
        
        return redirect()->route('article.search');
    }
}
