<?php

namespace App\Http\Controllers;

use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\GeneralConfig\LookUpList;
use App\Http\Controllers\Private\RoleController;

use App\Http\Controllers\Private\UserController;
use App\Http\Controllers\Public\StateController;
use App\Http\Controllers\Root\ComponentGroupController;
use App\Http\Controllers\Root\ComponentDefaultController;
use App\Http\Controllers\GeneralConfig\LookUpListController;
use App\Http\Controllers\GeneralConfig\LookUpListValueController;
use App\Http\Controllers\Root\ComponentController;
Use Exception;


class TestFunctionController extends Controller {

    function getIP(Request $request){
        return $request->ip();
    }

    function methodType(Request $request){
        if ($request->isMethod('post')) {
            return $request->method();
        } else {
            return "No es un post";
        }
    }

    function getCookies(Request $request){
        return $request->cookie();
    }

    function whereIn(){
        return LookUpList::whereIn('id', [1, 2, 3, 4])->get();
        return LookUpList::whereNotNull('id')->get();
    }

    function whereNotIn(){
        return LookUpList::whereNotIn('id', [1, 2, 3, 4])->get();
        return LookUpList::whereNull('id')->get();
    }

    function joinTest(){
        $users = DB::table('u_look_up_list')
            ->leftJoin('u_look_up_list_value', 'u_look_up_list.id', '=', 'u_look_up_list_value.lookUpList_id')
            ->where('u_look_up_list_value.id', '=', 2)
            ->get();

        header('Content-Type: application/json');
        echo json_encode(['status' => 'Success', 'rows' => $users]);exit();
    }

    public function test2(Request $request){
<<<<<<< HEAD
        // $parents = DB::table('component_groups')->select('id', 'name', 'icon', 'component_group_id')->where('component_group_id', NULL)->get();
        // $childs = DB::table('component_groups')->select('id', 'name', 'icon', 'component_group_id')->where('component_group_id', '!=' , NULL)->get();
        // $components = DB::table('components')->select('config', 'component_group_id')->get();


        $test = DB::select('SELECT JSON_EXTRACT(config , "$.name") as test FROM components');




         return $test;

        // $test = DB::table('components')
        // ->whereJsonLength ('config->name', 1)
        // ->get();

        // $names = [];
        // foreach ($test as $result) {
        //      $config = json_decode($result->config, true);
        //      $names[] = $config['name'];
        // }
        // return $names;

        // $test = DB::table("SELECT JSON_EXTRACT('components.config') as test FROM components")->get();

        // foreach($parents as $parent){
        //     foreach($components as $component){
        //         if($parent->id == $component->component_group_id){
        //             $parent->items[] = $component;
        //         }
        //     }
        //     foreach($childs as $child){
        //         if($parent->id == $child->component_group_id){
        //             $parent->items[] = $child;
        //         }
        //         foreach($components as $component){
        //             if($child->id == $component->component_group_id){
        //                 $child->items[] = $component;
        //             }
        //         }
        //     }
        //     $array['menu'][]['items'][] = $parent;
        // }
=======
        $parents = DB::table('component_groups')->select('id', 'name', 'icon', 'component_group_id')->where('component_group_id', NULL)->get();
        $childs = DB::table('component_groups')->select('id', 'name', 'icon', 'component_group_id')->where('component_group_id', '!=' , NULL)->get();
        // $components = DB::table('components')->select('config', 'component_group_id')->get();

        $test = DB::select("SELECT JSON_EXTRACT(config, '$.name') as name, component_group_id FROM components");

        foreach($test as $tes => $val){
            $pe = str_replace('"', "", $val->name);
            $pe2 = '/'.$pe;
            $components[$tes]['name'] = $pe;
            $components[$tes]['link'] = $pe2;
            $components[$tes]['component_group_id'] = $val->component_group_id;
        }

        foreach($parents as $parent){
            foreach($components as $component){
                if($parent->id == $component['component_group_id']){
                    $parent->items[] = $component;
                }
            }
            foreach($childs as $child){
                if($parent->id == $child->component_group_id){
                    $parent->items[] = $child;
                }
                foreach($components as $component){
                    if($child->id == $component['component_group_id']){
                        $child->items[] = $component;
                    }
                }
            }
            $array['menu'][]['items'][] = $parent;
        }
>>>>>>> c3e2f7dd3b05d760c7de856226deafad6e5dc448

        // return $array;
    }

    function probarFormFieldStructure(){
        $test = new ComponentDefaultController;
        $pepe =  json_decode($test->getLast(), true);
        return $pepe['form_fields'];
    }
}
