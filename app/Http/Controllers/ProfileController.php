<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Helpers\Curl;
use App\Helpers\Status;
use Session;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ProfileController extends Controller
{

    private $title = "Profil";
    private $subtitle = "";
    
    public function edit(Request $request)
    {
        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;

        $uri = Curl::endpoint();
        $url = $uri .'/'.'user/get-single';
        $param = array('user_id' => Session::get('user_id'));
        $res = Curl::requestPost($url, $param);

        if($res->status == true) {
            $data['status']  = $res->status;
            $data['message'] = $res->message;
            $data['info']    = $res->data; 
        }
        else {
            $data['list'] = array(); 
            Session::flash('alrt', 'error');    
            Session::flash('msgs', $res->message);   
        }

        return view('profile.edit', $data);
    }

    public function show($id)
    {
        return redirect()->route('profile.edit');
    }

    public function update(Request $request)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'auth/update-profile';

        if($request->hasFile('userfile')) {
            $file = request('userfile');
            $file_path = $file->getPathName();
            $file_mime = $file->getMimeType('image');
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
                        'name'      => 'user_id',
                        'contents'  => Session::get('user_id'),
                    ],
                    [
                        'name'      => 'fullname',
                        'contents'  => $request->fullname,
                    ],
                    [
                        'name'      => 'email',
                        'contents'  => $request->email,
                    ],
                    [
                        'name'      => 'user_image',
                        'contents'  => $request->user_image,
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
                'user_id'       => Session::get('user_id'),
                'status'        => (($request->status == 1)? 1:0),
                'fullname'      => $request->fullname,
                'email'         => $request->email,
                'user_image'    => $request->user_image,
                'last_user'     => Session::get('user_id')
            );
            
            $res = Curl::requestPost($url, $param);
        }

        $user_fullname = $res->data->user_fullname;
        $user_path     = $res->data->user_path;

        Session::put('user_fullname', $user_fullname);
        Session::put('user_path', $user_path);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return redirect()->route('profile.edit');
    }

    public function password(Request $request)
    {
        if($request->input('strength') < 3) {
            Session::flash('alrt', 'error');    
            Session::flash('msgs', 'Kata sandi Anda lemah');  

            return redirect()->route('profile.edit');
        }
        else {
            $uri = Curl::endpoint();
            $url = $uri .'/'.'auth/change-password';
            
            $param = array(
                'user_id'           => Session::get('user_id'),
                'oldpassword'       => $request->oldpassword,
                'newpassword'       => $request->newpassword,
                'confirmpassword'   => $request->confirmpassword
            );
            
            $res = Curl::requestPost($url, $param);

            Session::flash('alrt', (($res->status == false)?'error':'success'));    
            Session::flash('msgs', $res->message);  

            return redirect()->route('profile.edit');
        }
    }
}
