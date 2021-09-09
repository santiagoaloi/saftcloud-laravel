<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\Helper;
use App\Models\Roles\Role;

use App\Exceptions\Handler;
use Illuminate\Http\Request;

use App\Models\Private\Entity;
use App\Models\Public\Country;
use App\Models\Private\Account;
use App\Models\Roles\Capability;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
Use Exception;
use App\Models\GeneralConfig\LookUpList;
use App\Http\Controllers\Private\RoleController;
use App\Http\Controllers\Private\UserController;
use App\Http\Controllers\Public\StateController;
use App\Http\Controllers\Private\BranchController;
use App\Http\Controllers\Root\ComponentController;
use App\Http\Controllers\Root\ComponentGroupController;
use App\Http\Controllers\Root\ComponentDefaultController;
use App\Http\Controllers\GeneralConfig\LookUpListController;
use App\Http\Controllers\GeneralConfig\LookUpListValueController;

class TestFunctionController extends Controller {

    private $model = 'test';

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

    public function test2(){
        $tata = explode(',', env(
            'SANCTUM_STATEFUL_DOMAINS',
            'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1,'.parse_url(env('APP_URL'), PHP_URL_HOST)
        ));

        return $tata;
        $query = New ComponentController;
        return $query->getComponentNames();
    }

    public function test3(Request $request){

        // session(['juana'=>'estudi']);
        // $request->session()->put(['pepe'=>'admin']);

        // $request->session()->forget('juana');
        // $request->session()->flush(); // elimina toda la session

        $request->session()->keep(['email']); // evita que se borre este it em de la session

        // cuando conviene usar regenerate???
        $request->session()->regenerate(); // regenera el token de la sesion

        return $request->session()->all();

        // return $user;
        // return session()->all();
        // dd($user->id);exit;

        // $user = User::first();

        // // $user = UserController::attachUser($user, 1);
        // // return $user;

        // return $this->model;

        // $entity = Entity::first();
        // $entity->addresses()->create(['name'=>'test', 'state_id'=>1, 'city'=>'punta alta', 'neighborhood'=>'pepe']);
        // exit;

        // return session();
        // var_dump(csrf_token());
        // var_dump($request->header('X-CSRF-TOKEN'));
    }

    public function test4(Request $request, Country $country){
        return Auth::user()->id;

        // return $this->authorize('update', $country);

        return $request->session::get('email');
        // return $request->session()->all();

        // return Session::getId();

        // return session()->all();
        // var_dump(csrf_token());
        // var_dump($request->header('X-CSRF-TOKEN'));
    }

    function probarFormFieldStructure(){
        $test = new ComponentDefaultController;
        $pepe =  json_decode($test->getLast(), true);
        return $pepe['form_fields'];
    }

}
