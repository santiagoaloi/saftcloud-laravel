<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Root\ComponentDefaultController;

use App\Models\GeneralConfig\LookUpList;

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

    function test2(Request $request){


        if ($request->has(['name', 'email'])) {
            return $request->name.' - '.$request->email;
        } else if ($request->has('id')) {
            return $request->id;
        } else if ($request->has('email')) {
            return $request->email;
        } else {
            return "no tiene nombre ni email";
        }

    }

    function probarFormFieldStructure(){
        $test = new ComponentDefaultController;
        $pepe =  json_decode($test->getLast(), true);
        return $pepe['form_fields'];
    }
}