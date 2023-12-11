<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Helpers\Curl;
use Session;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class SettingCoverController extends Controller
{
    private $title = "Data Gambar Sampul";
    private $subtitle = "Gambar Sampul";
    private $path = 'setting/cover/search';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index() {
        // unset session
		Session::forget('q');   
        return redirect()->route('covers.search');
	}

    public function search()
    {
        $q = Session::get('q');   
        $data['q'] = $q;
        
        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;
       
        $page = request()->has('page') ? request('page') : 1;
        $perPage = request()->has('per_page') ? request('per_page') : 10;
        $offset = ($page * $perPage) - $perPage;

        $uri = Curl::endpoint();
        $url = $uri .'/'.'master/cover/get-all';
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
        
        return view('setting.covers.index', $data, compact('results'));
    }

    public function filter(Request $request)
    {
        if($request->has('_token')) {
            $q = $request->q;
            Session::put('q', $q); 
            
            return redirect()->route('covers.search');
        } else {
            return redirect()->route('covers.index');
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

        return view('setting.covers.create', $data);
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
        $url = $uri .'/'.'master/cover/insert-data';

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
                        'name'      => 'name',
                        'contents'  => $request->name,
                    ],
                    [
                        'name'      => 'description',
                        'contents'  => $request->desc,
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
                'name'        => $request->name,
                'description' => $request->desc,
                'last_user'   => Session::get('user_id')
            );
    
            $res = Curl::requestPost($url, $param);
        }

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message); 
        
        return redirect()->route('covers.search');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('covers.index');
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
        $url = $uri .'/'.'master/cover/get-single';
        $param = array('cover_id' => $id);
        $res = Curl::requestPost($url, $param);

        if($res->status == true) {
            $data['status']  = $res->status;
            $data['message'] = $res->message;
            $data['info']    = $res->data; 

            return view('setting.covers.edit', $data);
        }
        else {
            Session::flash('alrt', 'error');    
            Session::flash('msgs', $res->message);   

            return redirect()->route('covers.search');
        }
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
        $url = $uri .'/'.'master/cover/update-data';

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
                        'name'      => 'cover_id',
                        'contents'  => $request->cover_id,
                    ],
                    [
                        'name'      => 'name',
                        'contents'  => $request->name,
                    ],
                    [
                        'name'      => 'description',
                        'contents'  => $request->desc,
                    ],
                    [
                        'name'      => 'status',
                        'contents'  => (($request->status == 1)? 1:0),
                    ],
                    [
                        'name'      => 'cover_image',
                        'contents'  => $request->cover_image,
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
                'cover_id'      => $request->cover_id,
                'cover_image'   => $request->cover_image,
                'cover_size'    => $request->cover_size,
                'name'          => $request->name,
                'description'   => $request->desc,
                'status'        => (($request->status == 1)? 1:0),
                'last_user'     => Session::get('user_id')
            );
            
            $res = Curl::requestPost($url, $param);
        }
        
        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);

        return redirect()->route('covers.search');
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
        $url = $uri .'/'.'master/cover/delete-data';
        
        $param = array(
            'cover_id' => $id,
            'last_user'   => Session::get('user_id')
        );
        
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return redirect()->route('covers.search');
    }
}
