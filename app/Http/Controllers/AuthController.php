<?php

namespace App\Http\Controllers;

use App\Helpers\Curl;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function myIp() {
        echo "_SERVER['REMOTE_ADDR'] = ". $_SERVER['REMOTE_ADDR'];
        echo "<br />";
        //echo "". getClientIp();
    }
    
    public function index()
    {
        if (Session::get('login')) {
            return redirect()->route('dashboard.index');
        }

        return view('auth.login');
    }

    public function loginPost(Request $request)
    {
        request()->validate([
            'captcha' => 'required|captcha'
        ],
        ['captcha.captcha'=>'Kode captcha salah']);
        
        $uri = Curl::endpoint();
        $url = $uri . '/' . 'auth/login';

        $param = array(
            'ip'       => $request->ip(),
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'token'    => ''
        );

        $res = Curl::requestPost($url, $param);
        if ($res->status == true) {
            $request->session()->regenerate();
            $users = $res->data->user;

            Session::put('user_id', $users->user_id);
            Session::put('user_type', $users->user_type);
            Session::put('user_account', $users->user_account);
            Session::put('user_fullname', $users->user_fullname);
            Session::put('user_token', $users->user_token);
            Session::put('user_image', $users->user_image);
            Session::put('user_path', $users->user_path);
            Session::put('satker_id', $users->satker_id);
            Session::put('satker_name', $users->satker_name);
            Session::put('satker_slug', $users->satker_slug);
            Session::put('satker_url', $users->satker_url);
            Session::put('role_id', $users->role_id);
            Session::put('role_name', $users->role_name);

            $access = $res->data->access;
            Session::put('access', $access);
            Session::put('login', TRUE);

            return redirect()->route('dashboard.index');
        } else {
            return redirect('/')->with('alert', $res->message);
        }
    }

    public function logout()
    {
        $uri = Curl::endpoint();
        $url = $uri . '/' . 'auth/logout';

        $param = array(
            'ip'      => Curl::getClientIps(),
            'user_id' => Session::get('user_id')
        );

        $res = Curl::requestPost($url, $param);
        if ($res->status == true) {
            Session::flush();

            return redirect('login');
        } else {
            Session::flush();

            return redirect('/')->with('alert', $res->message);
        }
    }

    public function refreshCaptcha()
    {
        return response()->json([
            'captcha'=> captcha_img()
        ]);
    }

    public function scheduleBackup()
    {
        echo "Coklat"; die();
        return response()->json([
            'captcha'=> captcha_img()
        ]);
    }
}
