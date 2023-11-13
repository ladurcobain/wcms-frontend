<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Helpers\Module;
use App\Helpers\Curl;
use Carbon\Carbon;
use Session;

class ContentsController extends Controller
{

    private $title = "Pencarian Mutakhir";
    private $subtitle = "";
    private $path = 'contents/search';
    
    public function index() {
		// unset session
		Session::forget('q');  
        Session::forget('satker');
        Session::forget('start');
        Session::forget('end');
        Session::forget('menu');  

        return redirect()->route('contents.search');
	}

    public function search()
    {
        if(Session::get('user_type') == 2) {
            $satker = Session::get('satker_id'); 
            $data['satkers'] = Module::getLevelingSatker($satker);
        }
        else {
            $satker = Session::get('satker');  
            $data['satkers'] = Module::getActiveSatker();
        }

        $data['menus'] = Module::getActiveMenu();

        $q = Session::get('q');  
        $start = Session::get('start');   
        $end = Session::get('end');
        $menu = Session::get('menu');

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
        $data['menu'] = $menu;

        
        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;
       
        $page = request()->has('page') ? request('page') : 1;
        $perPage = request()->has('per_page') ? request('per_page') : 10;
        $offset = ($page * $perPage) - $perPage;

        $uri = Curl::endpoint();
        $url = $uri .'/'.'activity/get-search-content';
        $param = array(
            'limit'     => $perPage,
            'offset'    => $offset,
            'user_id'   => Session::get('user_id'),
            'satker_id' => $satker,
            'user_id'   => Session::get('user_id'),
            'start'     => Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d'),
            'end'       => Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d'),
            'menu_id'   => (($menu == null)?"":$menu),
            'keyword'   => (($q == null)?"":$q),
        );

        $res = Curl::requestPost($url, $param);

        $newCollection = collect($res->data->list);
        $results =  new LengthAwarePaginator(
            $newCollection,
            $res->data->total,
            $perPage,
            $page,
            ['path' => url($this->path)]
        );
        
        return view('activity.content.index', $data, compact('results'));
    }

    public function filter(Request $request)
    {
        if($request->has('_token')) {
            $q      = $request->q;
            $satker = $request->satker;
            $start  = $request->start;
            $end    = $request->end;
            $menu   = $request->menu;

            Session::put('q', $q); 
            Session::put('satker', $satker); 
            Session::put('start', $start); 
            Session::put('end', $end);
            Session::put('menu', $menu); 
            
            return redirect()->route('contents.search');
        } else {
            return redirect()->route('contents.index');
        }
    }
}
