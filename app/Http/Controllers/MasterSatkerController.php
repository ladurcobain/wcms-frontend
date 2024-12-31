<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Helpers\Module;
use App\Helpers\Curl;
use App\Helpers\Status;
use Session;
use App\Models\MasterMenu;
use GuzzleHttp\Client;

class MasterSatkerController extends Controller
{
    private $module = 305;
    private $title = "Data Induk";
    private $subtitle = "Satuan Kerja";
    private $path = 'master/satker/search';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {
        // unset session
		Session::forget('q');  
        Session::forget('t');

        return redirect()->route('satker.search');
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
        $url = $uri .'/'.'satker/get-full';
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
        
        return view('master.satker.index', $data, compact('results'));
    }

    public function filter(Request $request)
    {
        if($request->has('_token')) {
            $q = $request->q;
            $t = $request->t;
            
            Session::put('q', $q); 
            Session::put('t', $t); 
            
            return redirect()->route('satker.search');
        } else {
            return redirect()->route('satker.index');
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
        
        return view('master.satker.create', $data);
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
        $url = $uri .'/'.'satker/insert-data';
        
        $param = array(
            'code'          => $request->code,
            'akronim'       => $request->akronim,
            'name'          => $request->name,
            'phone'         => $request->phone,
            'email'         => $request->email,
            'address'       => $request->address,
            'overlay'       => $request->overlay,
            'embed_map'     => $request->embed_map,
            'url_facebook'  => $request->url_facebook,
            'url_twitter'   => $request->url_twitter,
            'url_instagram' => $request->url_instagram,
            'description'   => $request->description,
            'type'          => $request->type,
            'last_user'     => Session::get('user_id')
        );

        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return redirect()->route('satker.search');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('satker.index');
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
        $url = $uri .'/'.'satker/get-single';
        $param = array('satker_id' => $id);
        $res = Curl::requestPost($url, $param);

        $navigations = array(); 
        if($res->status == true) {
            $data['status']  = $res->status;
            $data['message'] = $res->message;
            $data['info']    = $res->data; 

            $uri = Curl::endpoint();
            $url = $uri .'/'.'satker/get-access';
            $param = array('satker_id' => $id);
            $res = Curl::requestPost($url, $param);

            if($res->status == true) {
                $navigations = $res->data; 
            }
        }
        else {
            $data['list'] = array(); 
            Session::flash('alrt', 'error');    
            Session::flash('msgs', $res->message);   
        }

        $getChild = MasterMenu::where('menu_nav', 0)->orderBy('menu_id', 'ASC')->get();
        $data['menu'] = $getChild;
        
        $getParent = MasterMenu::where('menu_parent', 1)->orderBy('menu_id', 'ASC')->get();
        $data['link'] = $getParent;

        $getPattern = Module::getActivePattern();
        $data['pattern'] = $getPattern;

        $getCover = Module::getActiveCover();
        $data['cover'] = $getCover;

        $data['navigations'] = $navigations;
        return view('master.satker.edit', $data);
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
        $url = $uri .'/'.'satker/update-data';
        
        $param = array(
            'satker_id'     => $request->satker_id,
            'status'        => (($request->status == 1)? 1:0),
            'code'          => $request->code,
            'akronim'       => $request->akronim,
            'name'          => $request->name,
            'phone'         => $request->phone,
            'email'         => $request->email,
            'address'       => $request->address,
            'overlay'       => $request->overlay,
            'embed_map'     => $request->embed_map,
            'url_facebook'  => $request->url_facebook,
            'url_twitter'   => $request->url_twitter,
            'url_instagram' => $request->url_instagram,
            'description'   => $request->description,
            'last_user'     => Session::get('user_id')
        );
        
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return redirect()->route('satker.search');
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
        $url = $uri .'/'.'satker/delete-data';
        
        $param = array(
            'satker_id' => $id,
        );
        
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return redirect()->route('satker.search');
    }

    public function process(Request $request)
    {
        $id  = $request->satker_id;
        $tab = $request->tab_name;
        
        Session::flash('tab', $tab); 

        $parent  = $request->parent;
        $menus   = $request->menus;
        
        $uri = Curl::endpoint();
        $url = $uri .'/'.'satker/process-data';
        
        $param = array(
            'satker_id'   => $id,
            'menu_id'     => $menus,
            'menu_parent' => $parent,
            'last_user'   => Session::get('user_id')
        );
        
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return $this->edit($id);
    }


    public function updateinfo(Request $request)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'satker/update-info';
        
        $param = array(
            'satker_id'     => $request->satker_id,
            'status'        => (($request->status == 1)? 1:0),
            'url'           => $request->url,
            'phone'         => $request->phone,
            'email'         => $request->email,
            'address'       => $request->address,
            'overlay'       => $request->overlay,
            'last_user'     => Session::get('user_id')
        );
        
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return $this->edit($request->satker_id);
    }

    public function updatemedsos(Request $request)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'satker/update-medsos';
        
        $param = array(
            'satker_id'     => $request->satker_id,
            'embed_map'     => $request->embed_map,
            'url_facebook'  => $request->url_facebook,
            'url_twitter'   => $request->url_twitter,
            'url_instagram' => $request->url_instagram,
            'description'   => $request->description,
            'last_user'     => Session::get('user_id')
        );
        
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return $this->edit($request->satker_id);
    }

    public function updatesupport(Request $request)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'satker/update-support';
        
        $param = array(
            'satker_id' => $request->satker_id,
            'whatsapp'  => $request->whatsapp,
            'opening'   => $request->opening,
            'last_user' => Session::get('user_id')
        );
        
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return $this->edit($request->satker_id);
    }

    public function updatevideos(Request $request)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'satker/update-videos';
    
        if($request->hasFile('userfile')) {
            $file = request('userfile');
            $file_path = $file->getPathName();
            $file_mime = $file->getClientMimeType();
            $file_uploaded_name = $file->getClientOriginalName('');
            
            $client = new Client();
            $response = $client->request('POST', $url, [
                'connect_timeout' => 10,
                'multipart' => [
                    [
                        'name'      => 'userfile',
                        'filename'  => $file_uploaded_name,
                        'mime-type' => $file_mime,
                        'contents'  => fopen($file_path, 'r'),
                    ],
                    [
                        'name'      => 'satker_id',
                        'contents'  => $request->satker_id,
                    ],
                    [
                        'name'      => 'videotitle',
                        'contents'  => $request->videotitle,
                    ],
                    [
                        'name'      => 'videosubtitle',
                        'contents'  => $request->videosubtitle,
                    ],
                    [
                        'name'      => 'videotype',
                        'contents'  => $request->typeVideo,
                    ],
                    [
                        'name'      => 'videolink',
                        'contents'  => (($request->videolink == null)?"":$request->videolink),
                    ],
                    [
                        'name'      => 'old_videotype',
                        'contents'  => $request->old_videotype,
                    ],
                    [
                        'name'      => 'old_videopath',
                        'contents'  => $request->old_videopath,
                    ],
                    [
                        'name'      => 'last_user',
                        'contents'  => Session::get('user_id'),
                    ]
                ]
            ]);
            
            if($response->getStatusCode() == 200) {
                $body = json_decode($response->getBody());
                if($body != "") {
                    $res = $body;
                }
                else {
                    $res = json_decode('{"status": false, "message": "Kesalahan koneksi internal", "data": "[]"}');
                }
            }
            else {
                $res = json_decode('{"status": false, "message": "Kesalahan respon server", "data": "[]"}');
            }
        }
        else {
            $param = array(
                'satker_id'     => $request->satker_id,
                'videotitle'    => $request->videotitle,
                'videosubtitle' => $request->videosubtitle,
                'videotype'     => $request->typeVideo,
                'videolink'     => $request->videolink,
                'old_videotype' => $request->old_videotype,
                'old_videopath' => $request->old_videopath,
                'last_user'     => Session::get('user_id')
            );
            
            $res = Curl::requestPost($url, $param);
        }
         
        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return $this->edit($request->satker_id);
    }

    public function updatepatterns(Request $request)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'satker/update-patterns';
        
        $param = array(
            'satker_id'     => $request->satker_id,
            'pattern'       => $request->pattern,
            'is_cover'      => $request->is_cover,
            'last_user'     => Session::get('user_id')
        );
        
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return $this->edit($request->satker_id);
    }

    public function updatebackgrounds(Request $request)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'satker/update-backgrounds';
        
        $param = array(
            'satker_id'     => $request->satker_id,
            'background'    => $request->background,
            'last_user'     => Session::get('user_id')
        );
        
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return $this->edit($request->satker_id);
    }
}
