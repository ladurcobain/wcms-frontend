<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Helpers\Module;
use App\Helpers\Curl;
use App\Helpers\Status;
use Session;
use Illuminate\Http\Request;
use Carbon\Carbon;
use GuzzleHttp\Client;

class ConferenceNewsController extends Controller
{
    private $title = "Siaran Pers";
    private $subtitle = "Berita";
    private $path = 'conference/news/search';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {
        // unset session
		Session::forget('q');  
        Session::forget('satker');
        
        return redirect()->route('news.search');
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
        $url = $uri .'/'.'conference/news/get-all';
        $param = array(
            'limit'     => $perPage,
            'offset'    => $offset,
            'satker_id' => $satker,
            'title'     => (($q == null)?"":$q),
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
        
        return view('conference.news.index', $data, compact('results'));
    }

    public function filter(Request $request)
    {
        if($request->has('_token')) {
            $q      = $request->q;
            $satker = $request->satker;
            
            Session::put('q', $q); 
            Session::put('satker', $satker); 
            
            return redirect()->route('news.search');
        } else {
            return redirect()->route('news.index');
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

        return view('conference.news.create', $data);
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
        $url = $uri .'/'.'conference/news/insert-data';

        $date = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
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
                        'contents'  => $request->satker,
                    ],
                    [
                        'name'      => 'date',
                        'contents'  => $date,
                    ],
                    [
                        'name'      => 'broadcast',
                        'contents'  => $request->broadcast,
                    ],
                    [
                        'name'      => 'title',
                        'contents'  => $request->title,
                    ],
                    [
                        'name'      => 'category',
                        'contents'  => Status::categoryNews($request->category),
                    ],
                    [
                        'name'      => 'text_in',
                        'contents'  => $request->text_in,
                    ],
                    [
                        'name'      => 'text_en',
                        'contents'  => $request->text_en,
                    ],
                    [
                        'name'      => 'status',
                        'contents'  => $request->status,
                    ],
                    [
                        'name'      => 'link_instagram',
                        'contents'  => $request->link_instagram,
                    ],
                    [
                        'name'      => 'link_youtube',
                        'contents'  => $request->link_youtube,
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
                'satker_id'      => $request->satker,
                'date'           => $date,
                'broadcast'      => $request->broadcast,
                'status'         => $request->status,
                'title'          => $request->title,
                'category'       => Status::categoryNews($request->category),
                'text_in'        => $request->text_in,
                'text_en'        => $request->text_en,
                'link_instagram' => $request->link_instagram,
                'link_youtube'   => $request->link_youtube,
                'last_user'      => Session::get('user_id')
            );
    
            $res = Curl::requestPost($url, $param);
        }

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message); 
        
        return redirect()->route('news.search');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('news.index');
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
        $url = $uri .'/'.'conference/news/get-single';
        $param = array('news_id' => $id);
        $res = Curl::requestPost($url, $param);

        if($res->status == true) {
            $data['status']  = $res->status;
            $data['message'] = $res->message;
            $data['info']    = $res->data; 

            if(Session::get('user_type') == 2) {
                if(Session::get('satker_id') != $data['info']->satker_id) {
                    Session::flash('alrt', 'error');    
                    Session::flash('msgs', 'Data tidak ditemukan'); 
                    
                    return redirect()->route('news.search');
                }
            }
        }
        else {
            $data['list'] = array(); 
            Session::flash('alrt', 'error');    
            Session::flash('msgs', $res->message);   

            return redirect()->route('news.search');
        }

        return view('conference.news.edit', $data);
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
        $url = $uri .'/'.'conference/news/update-data';

        $date = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
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
                        'name'      => 'news_id',
                        'contents'  => $request->news_id,
                    ],
                    [
                        'name'      => 'satker_id',
                        'contents'  => $request->satker,
                    ],
                    [
                        'name'      => 'date',
                        'contents'  => $date,
                    ],
                    [
                        'name'      => 'broadcast',
                        'contents'  => $request->broadcast,
                    ],
                    [
                        'name'      => 'title',
                        'contents'  => $request->title,
                    ],
                    [
                        'name'      => 'category',
                        'contents'  => Status::categoryNews($request->category),
                    ],
                    [
                        'name'      => 'text_in',
                        'contents'  => $request->text_in,
                    ],
                    [
                        'name'      => 'text_en',
                        'contents'  => $request->text_en,
                    ],
                    [
                        'name'      => 'status',
                        'contents'  => $request->status,
                    ],
                    [
                        'name'      => 'link_instagram',
                        'contents'  => $request->link_instagram,
                    ],
                    [
                        'name'      => 'link_youtube',
                        'contents'  => $request->link_youtube,
                    ],
                    [
                        'name'      => 'news_image',
                        'contents'  => $request->news_image,
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
                'news_id'        => $request->news_id,
                'news_image'     => $request->news_image,
                'news_size'      => $request->news_size,
                'date'           => $date,
                'title'          => $request->title,
                'category'       => $request->category,
                'text_in'        => $request->text_in,
                'text_en'        => $request->text_en,
                'link_instagram' => $request->link_instagram,
                'link_youtube'   => $request->link_youtube,
                'status'         => (($request->status == 1)? 1:0),
                'last_user'      => Session::get('user_id')
            );
            
            $res = Curl::requestPost($url, $param);
        }

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return redirect()->route('news.search');
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
        $url = $uri .'/'.'conference/news/delete-data';
        
        $param = array(
            'news_id'   => $id,
            'last_user' => Session::get('user_id')
        );
        
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return redirect()->route('news.search');
    }
}
