<?php

namespace App\Helpers;

use App\Models\MasterModule;
use App\Models\MasterMenu;
use App\Helpers\Curl;
use Session;

class Module
{
    public static function getModule()
    {
        $module = [
            'menu' => MasterModule::where('module_status', 1)->orderBy('module_position', 'ASC')->get(),
        ];

        return $module;
    }


    public static function getActiveRole()
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'active/get-role';
        $res = Curl::requestGet($url);

        if($res->status == true) {
            $arr = $res->data; 
        }
        else {
            $arr = array(); 
        }

        return $arr;
    }

    public static function getActiveSatker()
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'active/get-satker';
        $res = Curl::requestGet($url);

        if($res->status == true) {
            $arr = $res->data; 
        }
        else {
            $arr = array(); 
        }

        return $arr;
    }

    public static function getActiveUser($type)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'active/get-user';
        
        $param = array(
            'type' => $type
        );

        $res = Curl::requestPost($url, $param);
        if($res->status == true) {
            $arr = $res->data; 
        }
        else {
            $arr = array(); 
        }

        return $arr;
    }

    public static function getSessionSatker($satker)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'active/session-satker';
        
        $param = array(
            'satker_id' => $satker
        );

        $res = Curl::requestPost($url, $param);
        if($res->status == true) {
            $arr = $res->data; 
        }
        else {
            $arr = array(); 
        }

        return $arr;
    }

    public static function getLevelingSatker($satker)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'active/leveling-satker';
        
        $param = array(
            'satker_id' => $satker
        );

        $res = Curl::requestPost($url, $param);
        if($res->status == true) {
            $arr = $res->data; 
        }
        else {
            $arr = array(); 
        }

        return $arr;
    }

    public static function getActiveMenu()
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'active/get-menu';
        $res = Curl::requestGet($url);

        if($res->status == true) {
            $arr = $res->data; 
        }
        else {
            $arr = array(); 
        }

        return $arr;
    }

    public static function getActivePattern()
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'active/get-pattern';
        $res = Curl::requestGet($url);

        if($res->status == true) {
            $arr = $res->data; 
        }
        else {
            $arr = array(); 
        }

        return $arr;
    }

    public static function getActiveCover()
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'active/get-cover';
        $res = Curl::requestGet($url);

        if($res->status == true) {
            $arr = $res->data; 
        }
        else {
            $arr = array(); 
        }

        return $arr;
    }
}
