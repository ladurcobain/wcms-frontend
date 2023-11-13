<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterModule;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Session;

class ConfigPositionController extends Controller
{
    private $module = 201;
    private $title = "Pengaturan";
    private $subtitle = "Posisi Menu";

    public function index()
    {
        $arrModule = Session::get('access');
        if (!in_array($this->module, $arrModule)) {
             return redirect()->route('error.index');
        }

        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;

        $getParent = MasterModule::where('module_status', 1)->where('module_parent', 0)->orderBy('module_position', 'ASC')->get();
        $data['menu'] = $getParent;

        return view('config.position.index', $data);
    }

    public function sorting(Request $request)
    {
        $json = $request->nested_menu_array;
        $decoded_json = json_decode($json, TRUE);

        $simplified_list = [];
        $this->recur1($decoded_json, $simplified_list);

        DB::beginTransaction();
        try {
            $info = [
                "success" => FALSE,
            ];

            foreach ($simplified_list as $k => $v) {
                $menu = MasterModule::find($v['module_id']);
                $menu->fill([
                    "module_parent"     => $v['module_parent'],
                    "module_position"   => $v['module_position'],
                ]);

                $menu->save();
            }

            DB::commit();
            $info['success'] = TRUE;
        } catch (\Exception $e) {
            DB::rollback();
            $info['success'] = FALSE;
        }

        Session::flash('alrt', 'success');    
        Session::flash('msgs', 'Berhasil Ubah Data'); 

        return redirect()->route('position.index');
    }

    public function recur1($nested_array = [], &$simplified_list = [])
    {
        static $counter = 0;

        foreach ($nested_array as $k => $v) {
            $module_position = $k + 1;
            $simplified_list[] = [
                "module_id" => $v['id'],
                "module_parent" => 0,
                "module_position" => $module_position
            ];

            if (!empty($v["children"])) {
                $counter += 1;
                $this->recur2($v['children'], $simplified_list, $v['id']);
            }
        }
    }

    public function recur2($sub_nested_array = [], &$simplified_list = [], $module_parent = NULL)
    {
        static $counter = 0;

        foreach ($sub_nested_array as $k => $v) {
            $module_position = $k + 1;
            $simplified_list[] = [
                "module_id" => $v['id'],
                "module_parent" => $module_parent,
                "module_position" => $module_position
            ];

            if (!empty($v["children"])) {
                $counter += 1;
                return $this->recur2($v['children'], $simplified_list, $v['id']);
            }
        }
    }
}
