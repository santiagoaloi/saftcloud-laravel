<?php

namespace App\Http\Controllers\Private;

use App\Models\User;
use App\Models\Roles\Role;
use Illuminate\Http\Request;
use App\Models\Private\Entity;
use App\Http\Controllers\Controller;
use App\Helpers\RoleHelper;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class UserController extends Controller {

    private $model = 'user';

    // public function __construct() {
    //     $this->middleware(['permission:user.edit']);
    // }

    public function store(Request $request) {
        //** TEST PARA SUBIR ARCHIVOS AL CREAR UN USUARIO */
        // if($request->hasFile('picture')){
        //     $query['picture']=$request->file('picture')->store('avatars', 'public');
        // };

        $this->authorize('store', User::class);
        try{
            $admin = auth()->User();
            $account = $admin->Entity->RootAccount;
            $branch = $admin->Branch[0];

            // CREACION DE PERSONA
            $person = $account->entity()->create([
                'entity_type_id'    => 2,
                'first_name'        => $request['name'],
                'last_name'         => $request['lastname'],
                'iva_condition_id'  => 5,
                'document_type_id'  => 6
            ]);

            // CREACION DE USUARIO
            $person->user()->create([
                'role_id'          =>  2,
                'email'            =>  $request['email'],
                'password'         =>  bcrypt('password')
            ]);
            $user = $person->user;
            $this->attachUser($branch, $user);
            $role = Role::findOrFail(3);
            $this->attachUser($role, $user);

            $user->entity;
        }

        catch(QueryException $e){
            if($e->errorInfo[1]){
                return response([
                    'message'=> $e->errorInfo[2],
                    'code'=> $e->errorInfo[1]
                ], 404);
            }
        }

        return response([
            'record'=> $user
        ], 200);
    }

    public function show($id) {
        $this->authorize('show', User::class);
        $user = User::findOrFail($id);
        $user->entity;
        $user->privileges = getRoles($user->role);
        $user->origin = clone$user;

        return response([
            'record'=> $user
        ], 200);
    }

    public function showAll() {
        $this->authorize('showAll', User::class);
        $users = User::get();
        foreach($users as $user){
            $user->userSetting;
            $user->entity;
            $user->branch;
            $user->privileges = getRoles($user->role);
            $user->origin = clone$user;

            $newUsers[] = $user;
        }

        return response([
            'records'=> $newUsers
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        $this->authorize('getTrashed', User::class);
        return response([
            'records'=> User::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function restore($id) {
        $this->authorize('restore', User::class);
        return response([
            'record'=> User::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize('update', User::class);
        $query = User::find($id);
        try{
            $query->fill($request->all())->save();
        }
        catch(QueryException $e){
            if($e->errorInfo[1]){
                return response([
                    'message'=> $e->errorInfo[2],
                    'code'=> $e->errorInfo[1]
                ], 404);
            }
        }

        return response([
            'record'=> $query
        ], 200);
    }

    public function updateAll(Request $request) {
        $this->authorize('updateAll', User::class);
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize('destroy', User::class);
        $query = User::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize('forceDestroy', User::class);
        $query = User::withTrashed()->find($id);
        $query->forceDelete();
        return response([
            'status'=> true
        ], 200);
    }

    // AGREGA TODOS LOS USUARIOS QUE ENVIAMOS EN LA VARIABLE ROLE
    public function attachUser(User $user, Request $request){
        $items = $request['items'];
        $class = $request['name'];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $user->$class()->attach($arr);
    }

    // ELIMINA TODOS LOS USUARIOS QUE ENVIAMOS EN LA VARIABLE ROLE
    public function detachUser(User $user, Request $request){
        $items = $request['items'];
        $class = $request['name'];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $user->$class()->detach($arr);
    }

    // ELIMINA TODOS LOS USUARIOS Y AGREGA LOS NUEVOS
    public function syncUser(User $user, Request $request){
        $items = $request['items'];
        $class = $request['name'];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $user->$class()->sync($arr);
    }



    public function getRolCapabilities($user){
        $roles = [];
        $capabilities = [];

        foreach ($user->role as $value) {
            if($value){
                $roles[] = $value->name;
                foreach ($value->capability as $capability){
                    $capabilities[] = $capability->name;
                }
            }
        };
        return $this->getCapabilities($user, $capabilities);
    }

    public function getCapabilities($user, $capabilities){
        if ($capabilities){
            foreach ($user->capability as $value) {
                if($value){
                    $capabilities[] = $value->name;
                }
            }
            return $capabilities;
        }
        return [];
    }
}
