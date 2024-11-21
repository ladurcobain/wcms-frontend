<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Helpers\Module;
use App\Helpers\Curl;
use App\Helpers\Status;
use Session;
use Illuminate\Http\Request;

class AboutIntroController extends Controller
{
    private $title = "Tentang Kami";
    private $subtitle = "Kata Sambutan";
    private $path = 'about/intro/search';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {
        // unset session
		Session::forget('q');  
        Session::forget('satker');
        
        return redirect()->route('intro.search');
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
        
        $data['q'] = $q;
        $data['satker'] = $satker;
        
        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;
       
        $page = request()->has('page') ? request('page') : 1;
        $perPage = request()->has('per_page') ? request('per_page') : 10;
        $offset = ($page * $perPage) - $perPage;

        $uri = Curl::endpoint();
        $url = $uri .'/'.'about/intro/get-all';
        $param = array(
            'limit'     => $perPage,
            'offset'    => $offset,
            'satker_id' => $satker,
            'keyword'   => (($q == null)?"":$q),
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
        
        return view('about.intro.index', $data, compact('results'));
    }

    public function filter(Request $request)
    {
        if($request->has('_token')) {
            $q      = $request->q;
            $satker = $request->satker;
            
            Session::put('q', $q); 
            Session::put('satker', $satker); 
            
            return redirect()->route('intro.search');
        } else {
            return redirect()->route('intro.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;

        if(Session::get('user_type') == 2) {
            $data['satker']  = Session::get('satker_id'); 
            $data['satkers'] = Module::getSessionSatker(Session::get('satker_id'));
        }
        else {
            $data['satker']  = "";
            $data['satkers'] = Module::getActiveSatker();
        }

        return view('about.intro.create', $data);
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
        $url = $uri .'/'.'about/intro/insert-data';
        
        $param = array(
            'satker_id' => $request->satker,
            'text_in'   => $request->text_in,
            'text_en'   => $request->text_en,
            'last_user' => Session::get('user_id')
        );
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);
        
        return redirect()->route('intro.search');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('intro.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;
       
        $uri = Curl::endpoint();
        $url = $uri .'/'.'about/intro/get-single';
        $param = array('intro_id' => $id);
        $res = Curl::requestPost($url, $param);

        if($res->status == true) {
            $data['status']  = $res->status;
            $data['message'] = $res->message;
            $data['intro']    = $res->data; 

            if(Session::get('user_type') == 2) {
                if(Session::get('satker_id') != $data['intro']->satker_id) {
                    Session::flash('alrt', 'error');    
                    Session::flash('msgs', 'Data tidak ditemukan'); 
                    
                    return redirect()->route('intro.search');
                }
            }
        }
        else {
            $data['list'] = array(); 
            Session::flash('alrt', 'error');    
            Session::flash('msgs', $res->message);   
        }

        return view('about.intro.edit', $data);
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
        $url = $uri .'/'.'about/intro/update-data';
        
        $param = array(
            'intro_id'   => $request->intro_id,
            'status'    => (($request->status == 1)? 1:0),
            'text_in'   => $request->text_in,
            'text_en'   => $request->text_en,
            'last_user' => Session::get('user_id')
        );
        
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return redirect()->route('intro.search');
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
        $url = $uri .'/'.'about/intro/delete-data';
        
        $param = array(
            'intro_id'   => $id,
            'last_user' => Session::get('user_id')
        );
        
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return redirect()->route('intro.search');
    }
}
