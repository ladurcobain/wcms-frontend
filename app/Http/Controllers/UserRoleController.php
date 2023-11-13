<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Helpers\Curl;
use Session;
use App\Models\MasterModule;

class UserRoleController extends Controller
{
    private $module = 401;
    private $title = "Pengguna";
    private $subtitle = "Otoritas Pengguna";
    private $path = 'user/role/search';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index() {
        // unset session
		Session::forget('q');   
        return redirect()->route('role.search');
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
        $url = $uri .'/'.'role-user/get-full';
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
        
        return view('user.role.index', $data, compact('results'));
    }

    public function filter(Request $request)
    {
        if($request->has('_token')) {
            $q = $request->q;
            Session::put('q', $q); 
            
            return redirect()->route('role.search');
        } else {
            return redirect()->route('role.index');
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

        return view('user.role.create', $data);
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
        $url = $uri .'/'.'role-user/insert-data';
        
        $param = array(
            'name'          => $request->name,
            'description'   => $request->desc,
            'last_user'     => Session::get('user_id')
        );
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return redirect()->route('role.search');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('role.index');
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
        $url = $uri .'/'.'role-user/get-single';
        $param = array('role_id' => $id);
        $res = Curl::requestPost($url, $param);

        $authoritys = array(); 
        if($res->status == true) {
            $data['status']  = $res->status;
            $data['message'] = $res->message;
            $data['info']    = $res->data; 

            $uri = Curl::endpoint();
            $url = $uri .'/'.'role-user/get-access';
            $param = array('role_id' => $id);
            $res = Curl::requestPost($url, $param);

            if($res->status == true) {
                $authoritys = $res->data; 
            }
        }
        else {
            $data['list'] = array(); 
            Session::flash('alrt', 'error');    
            Session::flash('msgs', $res->message);   
        }

        $getChild = MasterModule::where('module_nav', 0)->orderBy('module_position', 'ASC')->get();
        $data['menu'] = $getChild;
        
        $getParent = MasterModule::where('module_nav', 1)->orderBy('module_position', 'ASC')->get();
        $data['link'] = $getParent;

        $data['authoritys'] = $authoritys;
        return view('user.role.edit', $data);
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
        $url = $uri .'/'.'role-user/update-data';
        
        $param = array(
            'role_id'       => $request->role_id,
            'status'        => (($request->status == 1)? 1:0),
            'name'          => $request->name,
            'description'   => $request->desc,
            'last_user'     => Session::get('user_id')
        );
        
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return redirect()->route('role.search');
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
        $url = $uri .'/'.'role-user/delete-data';
        
        $param = array(
            'role_id'   => $id,
            'last_user' => Session::get('user_id')
        );
        
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return redirect()->route('role.search');
    }

    public function process(Request $request)
    {
        $id  = $request->role_id;
        $tab = $request->tab_name;
        
        Session::flash('tab', $tab); 

        $parent  = $request->parent;
        $modules = $request->modules;
        
        $uri = Curl::endpoint();
        $url = $uri .'/'.'role-user/process-data';
        
        $param = array(
            'role_id'       => $id,
            'module_id'     => $modules,
            'module_parent' => $parent,
            'last_user'     => Session::get('user_id')
        );
        
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return $this->edit($id);
    }
}
