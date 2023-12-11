<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Helpers\Curl;
use Session;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class SettingPatternController extends Controller
{
    private $title = "Data Gambar Pola";
    private $subtitle = "Gambar Pola";
    private $path = 'setting/patterns/search';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index() {
        // unset session
		Session::forget('q');   
        return redirect()->route('patterns.search');
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
        $url = $uri .'/'.'master/pattern/get-all';
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
        
        return view('setting.patterns.index', $data, compact('results'));
    }

    public function filter(Request $request)
    {
        if($request->has('_token')) {
            $q = $request->q;
            Session::put('q', $q); 
            
            return redirect()->route('patterns.search');
        } else {
            return redirect()->route('patterns.index');
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

        return view('setting.patterns.create', $data);
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
        $url = $uri .'/'.'master/pattern/insert-data';

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
        
        return redirect()->route('patterns.search');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('patterns.index');
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
        $url = $uri .'/'.'master/pattern/get-single';
        $param = array('pattern_id' => $id);
        $res = Curl::requestPost($url, $param);

        if($res->status == true) {
            $data['status']  = $res->status;
            $data['message'] = $res->message;
            $data['info']    = $res->data; 

            return view('setting.patterns.edit', $data);
        }
        else {
            Session::flash('alrt', 'error');    
            Session::flash('msgs', $res->message);   

            return redirect()->route('patterns.search');
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
        $url = $uri .'/'.'master/pattern/update-data';

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
                        'name'      => 'pattern_id',
                        'contents'  => $request->pattern_id,
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
                        'name'      => 'pattern_image',
                        'contents'  => $request->pattern_image,
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
                'pattern_id'    => $request->pattern_id,
                'pattern_image' => $request->pattern_image,
                'pattern_size'  => $request->pattern_size,
                'name'          => $request->name,
                'description'   => $request->desc,
                'status'        => (($request->status == 1)? 1:0),
                'last_user'     => Session::get('user_id')
            );
            
            $res = Curl::requestPost($url, $param);
        }
        
        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);

        return redirect()->route('patterns.search');
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
        $url = $uri .'/'.'master/pattern/delete-data';
        
        $param = array(
            'pattern_id' => $id,
            'last_user'   => Session::get('user_id')
        );
        
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return redirect()->route('patterns.search');
    }
}
