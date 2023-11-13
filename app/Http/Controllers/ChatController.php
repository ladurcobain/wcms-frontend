<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use App\Helpers\Curl;
use App\Helpers\Module;
use Session;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    private $module = 7;   
    private $title = "Percakapan";
    private $subtitle = "";
    
    public function index()
    {
        if(Session::get('user_type') == 1) {
            $arrModule = Session::get('access');
            if (!in_array($this->module, $arrModule)) {
                return redirect()->route('error.index');
            }
        }

        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;

        $data['type']  = Session::get('user_type');
        $data['users'] = Module::getActiveUser(2);

        $uri = Curl::endpoint();
        $url = $uri .'/'.'chat/get-by-type';
        $param = array(
            'user_id'   => Session::get('user_id'),
            'user_type' => Session::get('user_type'),
        );

        $res = Curl::requestPost($url, $param);
        $data['list_user'] = $res->data;
        
        return view('chat.index', $data);
        
    }

    public function process(Request $request)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'chat/process-data';
        
        $param = array(
            'type'      => $request->type,
            'user_from' => ($request->type == 1)?Session::get('user_id'):$request->user,
            'user_to'   => ($request->type == 2)?Session::get('user_id'):$request->user,
            'message'   => $request->message,
        );
        
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  
        Session::flash('chat_id', $res->data->chat_id);

        return redirect('chat');
    }

    public function remove(Request $request)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'chat/remove-data';
        
        $param = array(
            'chat_id' => $request->parentId,
        );
        
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return redirect('chat');
    }
}
