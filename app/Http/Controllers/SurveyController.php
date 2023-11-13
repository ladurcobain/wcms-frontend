<?php

namespace App\Http\Controllers;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Helpers\Curl;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    private $title = "Survei Aplikasi";
    private $subtitle = "";
    private $path = 'survey/search';

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

        return redirect()->route('survey.search');
	}

    public function search()
    {
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
        $url = $uri .'/'.'survey/get-all';
        $param = array(
            'limit'     => $perPage,
            'offset'    => $offset,
            'start'     => Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d'),
            'end'       => Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d'),
            'user'      => (($q == null)?"":$q),
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
        
        return view('survey.index', $data, compact('results'));
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
            
            return redirect()->route('survey.search');
        } else {
            return redirect()->route('survey.index');
        }
    }

    public function indexss($start = "", $end = "", $keyword = "")
    {
        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;
        
        $now = Carbon::now();
        
        $firstDay = $now->firstOfMonth(); 
        $startDay = Carbon::createFromFormat('Y-m-d H:i:s', $firstDay)
                    ->format('d-m-Y'); 

        $lastDay = $now->lastOfMonth();        
        $endDay  = Carbon::createFromFormat('Y-m-d H:i:s', $lastDay)
                    ->format('d-m-Y'); 

        $start = (($start == "")?$startDay:$start);
        $end   = (($end == "")?$endDay:$end);

        $uri = Curl::endpoint();
        $url = $uri .'/'.'survey/get-all';
        $param = array(
            'start'   => Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d'),
            'end'     => Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d'),
            'user'    => $keyword
        );

        $res = Curl::requestPost($url, $param);

        $data['status']  = $res->status;
        $data['message'] = $res->message;
        $data['list']    = $res->data;
        
        return view('survey.index', $data, compact('start', 'end', 'keyword'));
    }

    public function detail($id)
    {
        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;
        
        $uri = Curl::endpoint();
        $url = $uri .'/'.'survey/get-single';
        
        $param = array(
            'survey_id' => $id,
        );
            
        $res = Curl::requestPost($url, $param);
        
        if($res->status == true) {
            $data['status']  = $res->status;
            $data['message'] = $res->message;
            $data['info']    = $res->data; 

            return view('survey.detail', $data);
        }
        else {
            Session::flash('alrt', 'error');    
            Session::flash('msgs', $res->message);  
            
            return redirect()->route('survey.search');
        }
    }

    public function destroy($id)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'survey/delete-data';
        
        $param = array(
            'survey_id' => $id,
            'last_user' => Session::get('user_id'),
        );
            
        $res = Curl::requestPost($url, $param);
        
        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return redirect()->route('survey.search');
    }
}
