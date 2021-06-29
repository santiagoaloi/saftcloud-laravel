<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Root\ComponentDefaultController;

use App\Models\GeneralConfig\LookUpList;

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

    function test2(){
        $tables = DB::select("select table_name from information_schema.tables where table_schema = 'laravel_vue'");
        foreach($tables as $table){
            $table_name = $table->table_name;
            $columns = DB::select("select column_name from information_schema.columns where table_schema = 'laravel_vue' and table_name = '$table_name'");
            foreach($columns as $column){
                $column_name[] = $column->column_name;
            }
            $tableArray[$table_name] = $column_name;
            $column_name = [];
        }
        return $tableArray;
    }

    function probarFormFieldStructure(){
        $test = new ComponentDefaultController;
        $pepe =  json_decode($test->getLast(), true);
        return $pepe['form_fields'];
    }
}
