<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Helpers\Module;
use App\Helpers\Curl;
use App\Helpers\Status;
use Session;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExcell;

class UserExportController extends Controller
{
    private $module = 403;
    private $title = "Pengguna";
    private $subtitle = "Unduh Pengguna";
    private $path = 'user/export/search';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {
        // unset session
		Session::forget('q');  
        Session::forget('t');

        return redirect()->route('export.search');
	}

    public function search()
    {
        $arrmenu = Session::get('access');
        if (!in_array($this->module, $arrmenu)) {
             return redirect()->route('error.index');
        }

        $q = Session::get('q');  
        $t = Session::get('t');   
        
        $data['q'] = $q;
        $data['t'] = $t;
        
        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;
       
        $page = request()->has('page') ? request('page') : 1;
        $perPage = request()->has('per_page') ? request('per_page') : 10;
        $offset = ($page * $perPage) - $perPage;

        $uri = Curl::endpoint();
        $url = $uri .'/'.'user/get-all';
        $param = array(
            'limit'   => $perPage,
            'offset'  => $offset,
            'name'    => (($q == null)?"":$q),
            'type'    => (($t == null)?"":$t),
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
        
        return view('user.Export.index', $data, compact('results'));
    }

    public function filter(Request $request)
    {
        if($request->has('_token')) {
            $q = $request->q;
            $t = $request->t;
            
            Session::put('q', $q); 
            Session::put('t', $t); 
            
            return redirect()->route('export.search');
        } else {
            return redirect()->route('export.index');
        }
    }

    public function excell(Request $request)
    {
        return Excel::download(new UserExcell($request->_name, $request->_type), 'users.xlsx');
    }

    public function download(Request $request)
    {
        $name = $request->_name;
        $type = $request->_type;

        $uri = Curl::endpoint();
        $url = $uri .'/'.'user/get-all';
        $param = array(
            'name' => $name,
            'type' => $type
        );

        $res = Curl::requestPost($url, $param);
        if($res->status == true) {
            $data['list']    = $res->data; 
        }
        else {
            Session::flash('alrt', 'error');    
            Session::flash('msgs', $res->message);  
            
            return redirect()->route('export.index');
        }
    }

    public function detail($id)
    {
        $arrModule = Session::get('access');
        if (!in_array($this->module, $arrModule)) {
             return redirect()->route('error.index');
        }
        
        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;
        
        $uri = Curl::endpoint();
        $url = $uri .'/'.'user/get-single';
        
        $param = array(
            'user_id' => $id,
        );
            
        $res = Curl::requestPost($url, $param);
        if($res->status == true) {
            $data['status']  = $res->status;
            $data['message'] = $res->message;
            $data['info']    = $res->data; 

            $urls = $uri .'/'.'activity/get-log';
            $params = array(
                'user_id' => $id,
                'keyword' => "Aplikasi",
                'limit'   => 20,
                'offset'  => 0
            );

            $resp = Curl::requestPost($urls, $params);
            if($resp->status == true) {
                $dt = $resp->data;
                $data['list'] = $dt->lists; 
            }
            else {
                $data['list'] = array();
            }
            return view('user.Export.detail', $data);
        }
        else {
            Session::flash('alrt', 'error');    
            Session::flash('msgs', $res->message);  
            
            return redirect()->route('export.index');
        }
    }
}
