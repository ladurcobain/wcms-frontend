<?php

namespace App\Http\Controllers;

use App\Helpers\Curl;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    
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
        return response()->json([
            'captcha'=> captcha_img()
        ]);
    }



    public function myIp() {
        echo "_SERVER['REMOTE_ADDR'] = ". $_SERVER['REMOTE_ADDR'];
        echo "<br />";
        //echo "". getClientIp();
    }

    public function response() {
        $offset = 500;
        $limit  = 600;
        $satkers = DB::table('tm_satker')->where('satker_status', 1)->skip($offset)->take($limit)->get();
        
        $ch = curl_init(); 
        $arr = array();

        foreach($satkers as $row) {
            $satker_name = $row->satker_name;
            $satker_url  = $row->satker_url;
        
            $url = $satker_url ."ajax/response";  
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
            $output = curl_exec($ch); 
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if($httpcode != 200) {
                $arr[] = $satker_name;
            }
        }

        curl_close($ch);    
        echo json_encode($arr); die();  
        //echo $httpcode;
    }


    // public function resetUser($account) {
    //     $user_id = Dbase::dbGetFieldById('tm_user', 'user_id', 'user_account', $account);
    //     if($user_id != "") {
    //         $rst = DB::table('tm_user')
    //             ->where('user_id', $user_id)
    //             ->update([
    //                 "user_count"  => 0,
    //                 "user_status" => 1
    //             ]); 
    //     }
    //     else {
    //         $rst = 0;
    //     }
            
    //     return response()->json([
    //         'status'    => Init::responseStatus($rst),
    //         'message'   => Init::responseMessage($rst, 'Logout'),
    //         'data'      => array()],
    //         200
    //     );
    // }


    public function resetAccount()
    {
        if (Session::get('login')) {
            return redirect()->route('dashboard.index');
        }

        return view('auth.reset');
    }

    public function processAccount(Request $request)
    {
        $account = $request->input('username');
        if($account != "") {
            $rst = DB::table('tm_user')
                ->where('user_account', $account)
                ->update([
                    "user_count"  => 0,
                    "user_status" => 1
                ]); 

            $rst = 1;
        }
        else {
            $rst = 0;
        }
            
        return redirect('auth/reset-account')->with('alert', "Proses ". (($rst == 1)?'Berhasil':'Gagal'));
    }
}
