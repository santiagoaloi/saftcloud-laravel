<?php

namespace App\Http\Controllers\Private;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller {

    private $model = 'user';

    public function __construct() {
        $this->middleware(['permission:user.edit']);
    }

    public function store(Request $request) {
        //** TEST PARA SUBIR ARCHIVOS AL CREAR UN USUARIO */
        // if($request->hasFile('picture')){
        //     $query['picture']=$request->file('picture')->store('avatars', 'public');
        // };
        try{
            $query = User::create($request->all());
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
            'row'=> $query
        ], 200);
    }

    public function show($id) {
        $user = User::findOrFail($id);
        $user['entity'] = $user->entity;

        foreach ($user->roles as $role) {
            foreach ($role->capabilities as $capability){
                $role['capabilities'] = $capability;
                $capabilities[] = $capability;
            }
            $user['capabilities'] = $capabilities;
            $user['roles'] = $role;
        };

        return response([
            'row'=> $user
        ], 200);
    }

    public function showAll() {
        return response([
            'rows'=> User::get()
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        return response([
            'rows'=> User::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        return response([
            'row'=> User::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
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
            'row'=> $query
        ], 200);
    }

    public function updateAll(Request $request) {
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $query = User::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function testRoles(){
        // User::first()->assignRole('user');
        $user = User::first();
        $user->getAllPermissions();

        dd($user);

        // Role::find(3)->givePermissionTo(Permission::find(3));

        // Role::create(['name' => 'User']);
        // Permission::create(['name' => 'user.edit']);
    }

    // AGREGA TODOS LOS USUARIOS QUE ENVIAMOS EN LA VARIABLE ROLE
    public function attachUser(Request $request, $role){
        $request->$this->user()->attach($role);
    }

    // ELIMINA TODOS LOS USUARIOS QUE ENVIAMOS EN LA VARIABLE ROLE
    public function detachUser(Request $request, $user){
        $request->user()->detach($user);
    }

    // ELIMINA TODOS LOS USUARIOS Y AGREGA LOS NUEVOS
    public function syncUser(Request $request, $user){
        $request->user()->sync($user);
    }
}
