<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Helpers\Curl;
use Session;
use Carbon\Carbon;

class LogActivityController extends Controller
{
    private $module = 9;   
    private $title = "Catatan Aktivitas";
    private $subtitle = "";
    private $path = 'log-activity/search';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {
        // unset session
		Session::forget('q');  
        Session::forget('start');
        Session::forget('end');

        return redirect()->route('log-activity.search');
	}

    public function search()
    {
        if(Session::get('user_type') == 1) {
            $arrModule = Session::get('access');
            if (!in_array($this->module, $arrModule)) {
                return redirect()->route('error.index');
            }
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
        $data['start'] = $start;
        $data['end'] = $end;
        
        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;
       
        $page = request()->has('page') ? request('page') : 1;
        $perPage = request()->has('per_page') ? request('per_page') : 10;
        $offset = ($page * $perPage) - $perPage;

        $uri = Curl::endpoint();
        $url = $uri .'/'.'activity/get-log';
        $param = array(
            'limit'   => $perPage,
            'offset'  => $offset,
            'user_id' => Session::get('user_id'),
            'start'   => Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d'),
            'end'     => Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d'),
            'keyword' => (($q == null)?"":$q),
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
        
        return view('activity.log.index', $data, compact('results'));
    }

    public function filter(Request $request)
    {
        if($request->has('_token')) {
            $q      = $request->q;
            $start  = $request->start;
            $end    = $request->end;

            Session::put('q', $q); 
            Session::put('start', $start); 
            Session::put('end', $end); 
            
            return redirect()->route('log-activity.search');
        } else {
            return redirect()->route('log-activity.index');
        }
    }
}
