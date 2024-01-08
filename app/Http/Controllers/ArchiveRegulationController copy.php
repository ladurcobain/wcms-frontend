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
    private $path = 'archive/regulation/search';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {
        return redirect()->route('regulation.search');
	}

    public function search()
     {
        $page = request()->has('page') ? request('page') : 1;
        $perPage = request()->has('per_page') ? request('per_page') : 20;
        $offset = ($page * $perPage) - $perPage;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://jdih.kejaksaan.go.id/api/apiwcms.php?page='.$page,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'x-access-token: 38bf8bd945abb3df355a6d87c8a09102fa8076c076e5f917bac771407ff726b0',
                'Cookie: PHPSESSID=90835468c22ce97ccdb53e24b80ebc47; _csrf=46bbea38a53a69f494ea6191b3b17a7cf2c9df7134c51556b7c2149a4913336ca%3A2%3A%7Bi%3A0%3Bs%3A5%3A%22_csrf%22%3Bi%3A1%3Bs%3A32%3A%22hiHyS0fffFHezVu4-w0Dv8GDPMGCykoW%22%3B%7D'
            ),
        ));

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $rsp_data = array();
        $rsp_total = 0;
        if($httpcode == 200) {
            $resp = json_decode($response); 

            $rsp_data  = $resp->data;
            $rsp_total = $resp->total;
            $newCollection = collect($rsp_data);
        }
        else {
            $newCollection = collect($rsp_data);
        }
        
        $results =  new LengthAwarePaginator(
            $newCollection,
            $rsp_total,
            $perPage,
            $page,
            ['path' => url($this->path)]
        );
        
        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;
        
        return view('filemanager.pdf.index', $data, compact('results'));
    }
}
