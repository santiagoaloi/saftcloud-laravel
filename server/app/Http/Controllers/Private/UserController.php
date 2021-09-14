<?php

namespace App\Http\Controllers\Private;

use App\Models\User;
use App\Models\Roles\Role;
use Illuminate\Http\Request;
use App\Models\Private\Entity;
use App\Http\Controllers\Controller;

// use Spatie\Permission\Models\Role;
use Illuminate\Database\QueryException;
use Spatie\Permission\Models\Permission;

class UserController extends Controller {

    // private $model = 'user';

    // public function __construct() {
    //     $this->middleware(['permission:user.edit']);
    // }

    public function store(Request $request) {
        //** TEST PARA SUBIR ARCHIVOS AL CREAR UN USUARIO */
        // if($request->hasFile('picture')){
        //     $query['picture']=$request->file('picture')->store('avatars', 'public');
        // };

        $admin = auth()->User();
        $account = $admin->Entity->RootAccount;

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
        $roleS = New Role;
        $role = $roleS->findOrFail(3);
        $this->attachUser($role, $user);

        $user->entity;

        return response([
            'row'=> $user
        ], 200);

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

        $roles = $user->roles[0];
        return $roles->capabilities;

        $user['capabilitiesList'] = $this->getRolCapabilities($user);

        // $user['branches'] = $user->branches[0]->entity->rootAccount;

        return $user;
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
    public function attachUser($request, $user){
        $request->users()->attach($user);
    }

    // ELIMINA TODOS LOS USUARIOS QUE ENVIAMOS EN LA VARIABLE ROLE
    public function detachUser($request, $user){
        $request->users()->detach($user);
    }

    // ELIMINA TODOS LOS USUARIOS Y AGREGA LOS NUEVOS
    public function syncUser($request, $user){
        $request->users()->sync($user);
    }

    public function getRolCapabilities($user){
        foreach ($user->roles as $value) {
            if($value){
                foreach ($value->capabilities as $capability){
                    $capabilities[] = $capability->name;
                }
            }
        };
        return $this->getCapabilities($user, $capabilities);
    }

    public function getCapabilities($user, $capabilities){
        foreach ($user->capabilities as $value) {
            if($value){
                $capabilities[] = $value->name;
            }
        }
        return $capabilities;
    }
}
