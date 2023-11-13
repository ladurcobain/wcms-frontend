<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Module;
use App\Helpers\Curl;
use App\Helpers\Status;
use Session;
use App\Models\MasterMenu;

class ConfigureController extends Controller
{

    private $title = "Konfigurasi";
    private $subtitle = "";
    
    public function edit(Request $request)
    {
        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;

        $uri = Curl::endpoint();
        $url = $uri .'/'.'satker/get-single';
        $param = array('satker_id' => Session::get('satker_id'));
        $res = Curl::requestPost($url, $param);

        $navigations = array(); 
        if($res->status == true) {
            $data['status']  = $res->status;
            $data['message'] = $res->message;
            $data['info']    = $res->data; 

            $uri = Curl::endpoint();
            $url = $uri .'/'.'satker/get-access';
            $param = array('satker_id' => Session::get('satker_id'));
            $resp = Curl::requestPost($url, $param);
            
            if($resp->status == true) {
                $navigations = $resp->data; 
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
        
        return view('configure.edit', $data);
    }

    public function show($id)
    {
        return redirect()->route('configure.edit');
    }

    public function update(Request $request)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'satker/update-data';
        
        $param = array(
            'satker_id'     => $request->satker_id,
            'status'        => (($request->status == 1)? 1:0),
            'url'           => $request->url,
            'name'          => $request->name,
            'phone'         => $request->phone,
            'email'         => $request->email,
            'address'       => $request->address,
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

        return redirect()->route('configure.edit');
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

        return redirect()->route('configure.edit');
    }

    
    public function updateinfo(Request $request)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'satker/update-info';
        
        $param = array(
            'status'        => 1,
            'satker_id'     => $request->satker_id,
            'url'           => $request->url,
            'name'          => $request->name,
            'phone'         => $request->phone,
            'email'         => $request->email,
            'address'       => $request->address,
            'overlay'       => $request->overlay,
            'last_user'     => Session::get('user_id')
        );
        
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);

        return redirect()->route('configure.edit');
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

        return redirect()->route('configure.edit');
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

        return redirect()->route('configure.edit');
    }

    public function updatevideos(Request $request)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'satker/update-videos';
        
        $param = array(
            'satker_id'     => $request->satker_id,
            'videotitle'    => $request->videotitle,
            'videosubtitle' => $request->videosubtitle,
            'videolink'     => $request->videolink,
            'last_user'     => Session::get('user_id')
        );
        
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);

        return redirect()->route('configure.edit');
    }

    public function updatepatterns(Request $request)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'satker/update-patterns';
        
        $param = array(
            'satker_id'     => $request->satker_id,
            'pattern'       => $request->pattern,
            "is_cover"      => $request->is_cover,
            'last_user'     => Session::get('user_id')
        );
        
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return redirect()->route('configure.edit');
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

        return redirect()->route('configure.edit');
    }
}
