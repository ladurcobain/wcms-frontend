<?php

namespace App\Http\Controllers;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Helpers\Curl;
use Session;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FilemanagerPdfController extends Controller
{
    private $module = 501;
    private $title = "Manajemen Berkas";
    private $subtitle = "Berkas PDF";
    
    public function index()
    {
        // unset session
		Session::forget('q');   
        return redirect()->route('filepdf.search');
    }

    public function search()
    {
        $arrModule = Session::get('access');
        if (!in_array($this->module, $arrModule)) {
             return redirect()->route('error.index');
        }

        $q = Session::get('q');   
        $data['q'] = $q;
        
        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;
       
        $page = request()->has('page') ? request('page') : 1;
        $perPage = request()->has('per_page') ? request('per_page') : 20;
        $offset = ($page * $perPage) - $perPage;

        $uri = Curl::endpoint();
        $url = $uri .'/'.'activity/get-file-manager';
        $param = array(
            'type'    => 3,
            'limit'   => $perPage,
            'offset'  => $offset,
            'user_id' => Session::get('user_id'),
            'keyword' => (($q == null)?"":$q),
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
        
        return view('filemanager.pdf.index', $data, compact('results'));
    }

    public function filter(Request $request)
    {
        if($request->has('_token')) {
            $q = $request->q;
            Session::put('q', $q); 
            
            return redirect()->route('filepdf.search');
        } else {
            return redirect()->route('filepdf.index');
        }
    }
}
