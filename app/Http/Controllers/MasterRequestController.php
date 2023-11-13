<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Helpers\Curl;
use Session;
use Illuminate\Http\Request;

class MasterRequestController extends Controller
{
    private $module = 304;
    private $title = "Data Induk";
    private $subtitle = "Integrasi API";
    private $path = 'master/request/search';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {
        // unset session
		Session::forget('q');   
        return redirect()->route('request.search');
	}

    public function search()
    {
        $arrmenu = Session::get('access');
        if (!in_array($this->module, $arrmenu)) {
             return redirect()->route('error.index');
        }

        $q = Session::get('q');   
        $data['q'] = $q;
        
        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;
       
        $page = request()->has('page') ? request('page') : 1;
        $perPage = request()->has('per_page') ? request('per_page') : 10;
        $offset = ($page * $perPage) - $perPage;

        $uri = Curl::endpoint();
        $url = $uri .'/'.'master/request/get-all';
        $param = array(
            'limit'   => $perPage,
            'offset'  => $offset,
            'name'    => (($q == null)?"":$q),
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
        
        return view('master.request.index', $data, compact('results'));
    }

    public function filter(Request $request)
    {
        if($request->has('_token')) {
            $q = $request->q;
            Session::put('q', $q); 
            
            return redirect()->route('request.search');
        } else {
            return redirect()->route('request.index');
        }
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arrModule = Session::get('access');
        if (!in_array($this->module, $arrModule)) {
             return redirect()->route('error.index');
        }
        
        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;

        return view('master.request.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'master/request/insert-data';

        $param = array(
            'name'          => $request->name,
            'method'        => $request->method,
            'url'           => $request->url,
            'description'   => $request->desc,
            'last_user'     => Session::get('user_id')
        );
        $res = Curl::requestPost($url, $param);

        $alrt = (($res->status == false)?'error':'success');    
        $msgs = $res->message;

        Session::flash('alrt', $alrt);    
        Session::flash('msgs', $msgs);
        
        return redirect()->route('request.search');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('request.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $arrModule = Session::get('access');
        if (!in_array($this->module, $arrModule)) {
            return redirect()->route('error.index');
        }
        
        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;
       
        $uri = Curl::endpoint();
        $url = $uri .'/'.'master/request/get-single';
        $param = array('request_id' => $id);
        $res = Curl::requestPost($url, $param);

        if($res->status == true) {
            $data['status']  = $res->status;
            $data['message'] = $res->message;
            $data['info']    = $res->data;

            $uri = Curl::endpoint();
            $url = $uri .'/'.'master/request/get-param';
            $param = array('request_id' => $id);
            $res = Curl::requestPost($url, $param);

            if($res->status == true) {
                $data['list'] = $res->data; 
            }
            else {
                $data['list'] = array();
            }
        }
        else {
            Session::flash('alrt', 'error');    
            Session::flash('msgs', $res->message);   

            return redirect()->route('request.index');
        }

        return view('master.request.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'master/request/update-data';
        
        $param = array(
            'request_id'    => $request->request_id,
            'status'        => (($request->status == 1)? 1:0),
            'name'          => $request->name,
            'method'        => $request->method,
            'url'           => $request->url,
            'description'   => $request->desc,
            'last_user'     => Session::get('user_id')
        );
        
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return redirect()->route('request.search');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'master/request/delete-data';
        
        $param = array(
            'request_id' => $id,
            'last_user'  => Session::get('user_id')
        );
        
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return redirect()->route('request.search');
    }

    public function process(Request $request)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'master/request/process-param';
        
        $param = array(
            'request_id'    => $request->parentId,
            'type'          => $request->type,
            'initial'       => $request->initial,
            'description'   => $request->desc,
        );
        
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return redirect('master/request/'. $request->parentId .'/edit');
    }

    public function remove($id, $parent)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'master/request/remove-param';
        
        $param = array(
            'param_id'  => $id,
        );
        
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return redirect('master/request/'. $parent .'/edit');
    }
}
