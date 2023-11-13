<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Helpers\Curl;
use Session;
use Carbon\Carbon;

class NotificationController extends Controller
{
    private $module = 8;   
    private $title = "Notifikasi";
    private $subtitle = "";
    private $path = 'notification/search';

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

        return redirect()->route('notification.search');
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
        $url = $uri .'/'.'notification/get-all';
        $param = array(
            'limit'   => $perPage,
            'offset'  => $offset,
            'user_id' => Session::get('user_id'),
            'start'   => Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d'),
            'end'     => Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d'),
            'title'   => (($q == null)?"":$q),
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
        
        return view('notification.index', $data, compact('results'));
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
            
            return redirect()->route('notification.search');
        } else {
            return redirect()->route('notification.index');
        }
    }

    public function detail($id)
    {
        if(Session::get('user_type') == 1) {
            $arrModule = Session::get('access');
            if (!in_array($this->module, $arrModule)) {
                return redirect()->route('error.index');
            }
        }

        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;
        
        $uri = Curl::endpoint();
        $url = $uri .'/'.'notification/get-single';
        
        $param = array(
            'notification_id' => $id,
        );
            
        $res = Curl::requestPost($url, $param);
        
        if($res->status == true) {
            if(Session::get('user_type') == 2) {
                if($res->data->user_id != Session::get('user_id')) {
                    Session::flash('alrt', 'error');    
                    Session::flash('msgs', 'Data tidak ditemukan');  
                    
                    return redirect()->route('notification.index');
                }
            }
            
            $data['status']  = $res->status;
            $data['message'] = $res->message;
            $data['info']    = $res->data; 

            return view('notification.detail', $data);
        }
        else {
            Session::flash('alrt', 'error');    
            Session::flash('msgs', $res->message);  
            
            return redirect()->route('notification.search');
        }
    }
    
    public function destroy($id)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'notification/delete-data';
        
        $param = array(
            'notification_id' => $id,
            'last_user'       => Session::get('user_id'),
        );
            
        $res = Curl::requestPost($url, $param);
        
        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return redirect()->route('notification.search');
    }

    public function edit($id)
    {
        if(Session::get('user_type') == 1) {
            $arrModule = Session::get('access');
            if (!in_array($this->module, $arrModule)) {
                return redirect()->route('error.index');
            }
        }
        
        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;
        
        $uri = Curl::endpoint();
        $url = $uri .'/'.'notification/get-single';
        
        $param = array(
            'notification_id' => $id,
        );
            
        $res = Curl::requestPost($url, $param);
        
        if($res->status == true) {
            if(Session::get('user_type') == 2) {
                if($res->data->user_id != Session::get('user_id')) {
                    Session::flash('alrt', 'error');    
                    Session::flash('msgs', 'Data tidak ditemukan');  
                    
                    return redirect()->route('notification.index');
                }
            }

            $data['status']  = $res->status;
            $data['message'] = $res->message;
            $data['info']    = $res->data; 

            return view('notification.edit', $data);
        }
        else {
            Session::flash('alrt', 'error');    
            Session::flash('msgs', $res->message);  
            
            return redirect()->route('notification.search');
        }
    }

    public function update(Request $request)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'notification/update-data';
        
        $param = array(
            'notification_id'   => $request->notification_id,
            'published'         => (($request->published == 1)? 1:0),
            'last_user'         => Session::get('user_id')
        );
        
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return redirect()->route('notification.search');
    }
}
