<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Helpers\Module;
use App\Helpers\Curl;
use App\Helpers\Status;
use Session;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ArchiveRegulationController extends Controller
{
    private $title = "Arsip Pemberkasan";
    private $subtitle = "Peraturan";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {
        // unset session
		Session::forget('q');  
        Session::forget('satker');
        
        return redirect()->route('regulation.search');
	}

    public function search()
    {
        if(Session::get('user_type') == 2) {
            $satker = Session::get('satker_id'); 
            $data['satkers'] = Module::getLevelingSatker($satker);
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
        $url = $uri .'/'.'archive/regulation/get-all';
        $param = array(
            'limit'     => $perPage,
            'offset'    => $offset,
            'satker_id' => $satker,
            'keyword'   => (($q == null)?"":$q),
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
        
        return view('archive.regulation.index', $data, compact('results'));
    }

    public function filter(Request $request)
    {
        if($request->has('_token')) {
            $q      = $request->q;
            $satker = $request->satker;
            
            Session::put('q', $q); 
            Session::put('satker', $satker); 
            
            return redirect()->route('regulation.search');
        } else {
            return redirect()->route('regulation.index');
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

        return view('archive.regulation.create', $data);
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
        $url = $uri .'/'.'archive/regulation/insert-data';

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
                        'name'      => 'title',
                        'contents'  => $request->title,
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
                'satker_id'   => $request->satker,
                'title'       => $request->title,
                'description' => $request->desc,
                'last_user'   => Session::get('user_id')
            );
    
            $res = Curl::requestPost($url, $param);
        }

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  



        // $ext  = "";
        // $size = 0;
        // if($request->hasFile('userfile')) {
        //     $ext  = $request->file('userfile')->extension();
        //     $size = $request->file('userfile')->getSize();

        //     if($ext == "pdf") {
        //         if($size <= 10000000) {
        //             $path = $request->file('userfile')->store('public/assets/uploads/regulation');
        //             $fileName = str_replace('public/assets/uploads/regulation/', '', $path); 
                    
        //             $uri = Curl::endpoint();
        //             $url = $uri .'/'.'archive/regulation/insert-data';
                    
        //             $param = array(
        //                 'size'          => $size,
        //                 'file'          => $fileName,
        //                 'satker_id'     => $request->satker,
        //                 'title'         => $request->title,
        //                 'description'   => $request->desc,
        //                 'last_user'     => Session::get('user_id')
        //             );
        //             $res = Curl::requestPost($url, $param);

        //             $alrt = (($res->status == false)?'error':'success');    
        //             $msgs = $res->message;
        //         }
        //         else {
        //             $alrt = 'error';    
        //             $msgs ='Ukuran berkas maks: 10 MB';
        //         }
        //     }
        //     else {
        //         $alrt = 'error';        
        //         $msgs = 'Jenis berkas unggahan: pdf';
        //     }
        // }
        // else {
        //     $alrt = 'error';        
        //     $msgs = 'Berkas unggahan harap di lengkapi';
        // }

        // Session::flash('alrt', $alrt);    
        // Session::flash('msgs', $msgs);

        return redirect()->route('regulation.search');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('regulation.index');
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
        $url = $uri .'/'.'archive/regulation/get-single';
        $param = array('regulation_id' => $id);
        $res = Curl::requestPost($url, $param);

        if($res->status == true) {
            $data['status']  = $res->status;
            $data['message'] = $res->message;
            $data['info']    = $res->data; 

            if(Session::get('user_type') == 2) {
                if(Session::get('satker_id') != $data['info']->satker_id) {
                    Session::flash('alrt', 'error');    
                    Session::flash('msgs', 'Data tidak ditemukan'); 
                    
                    return redirect()->route('regulation.search');
                }
            }
        }
        else {
            $data['list'] = array(); 
            Session::flash('alrt', 'error');    
            Session::flash('msgs', $res->message);   
        }

        return view('archive.regulation.edit', $data);
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
        $url = $uri .'/'.'archive/regulation/update-data';

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
                        'name'      => 'regulation_id',
                        'contents'  => $request->regulation_id,
                    ],
                    [
                        'name'      => 'satker_id',
                        'contents'  => $request->satker,
                    ],
                    [
                        'name'      => 'title',
                        'contents'  => $request->title,
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
                        'name'      => 'regulation_file',
                        'contents'  => $request->regulation_file,
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
                'regulation_id' => $request->regulation_id,
                'status'        => (($request->status == 1)? 1:0),
                'name'          => $request->name,
                'description'   => $request->desc,
                'last_user'     => Session::get('user_id')
            );
            
            $res = Curl::requestPost($url, $param);
        }


        // if($request->hasFile('userfile')) {
        //     $ext  = $request->file('userfile')->extension();
        //     $size = $request->file('userfile')->getSize();

        //     if($ext == "pdf") {
        //         if($size <= 10000000) {
        //             $path = $request->file('userfile')->store('public/assets/uploads/regulation');
        //             $fileName = str_replace('public/assets/uploads/regulation/', '', $path);

        //             if($request->regulation_file != "") {
        //                 unlink(storage_path('app/public/assets/uploads/regulation/'.$request->regulation_file)); 
        //             }
        //         }
        //         else {
        //             Session::flash('alrt', 'error');    
        //             Session::flash('msgs', 'Ukuran berkas maks: 10 MB');  

        //             return redirect()->route('regulation.search');
        //         }
        //     }
        //     else {
        //         Session::flash('alrt', 'error');    
        //         Session::flash('msgs', 'Jenis berkas unggahan: pdf');  

        //         return redirect()->route('regulation.search');
        //     }    
        // }
        // else {
        //     $fileName = $request->regulation_file;
        //     $size     = $request->regulation_size;
        // }

        // $uri = Curl::endpoint();
        // $url = $uri .'/'.'archive/regulation/update-data';
        
        // $param = array(
        //     'regulation_id' => $request->regulation_id,
        //     'size'          => $size,
        //     'file'          => $fileName,
        //     'title'         => $request->title,
        //     'description'   => $request->desc,
        //     'status'        => (($request->status == 1)? 1:0),
        //     'last_user'     => Session::get('user_id')
        // );
        
        // $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return redirect()->route('regulation.search');
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
        $url = $uri .'/'.'archive/regulation/delete-data';
        
        $param = array(
            'regulation_id' => $id,
            'last_user'     => Session::get('user_id')
        );
        
        $res = Curl::requestPost($url, $param);

        Session::flash('alrt', (($res->status == false)?'error':'success'));    
        Session::flash('msgs', $res->message);  

        return redirect()->route('regulation.search');
    }
}
