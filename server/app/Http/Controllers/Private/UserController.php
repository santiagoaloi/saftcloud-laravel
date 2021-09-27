<?php

namespace App\Http\Controllers\Private;

use App\Models\User;
use App\Models\Roles\Role;
use Illuminate\Http\Request;
use App\Models\Private\Entity;
use App\Http\Controllers\Controller;

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

            $admin = auth()->user();
            $admin->privileges = $this->getRolCapabilities($admin);
            foreach($admin->roles as $role){
                $rolesArr[] = $role['name'];
                if(in_array('Root', $rolesArr)){
                    return 'opo';
                }
            }
            return $admin;

        $this->authorize('store', User::class);
        try{
            $admin = auth()->User();
            $account = $admin->Entity->RootAccount;
            $branch = $admin->Branches[0];

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
            $this->attachUserS($branch, $user);

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

        $roles = $user->roles[0];
        return $roles->capabilities;

        $user['capabilitiesList'] = $this->getRolCapabilities($user);

        // $user['branches'] = $user->branches[0]->entity->rootAccount;

        return response([
            'record'=> $user
        ], 200);
    }

    public function showAll() {
        $this->authorize('showAll', User::class);
        return response([
            'records'=> User::get()
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

    // AGREGA TODOS LOS USUARIOS QUE ENVIAMOS EN LA VARIABLE ROLE
    public function attachUserS($request, User $user){
        $request->user()->attach($user);
    }

    // ELIMINA TODOS LOS USUARIOS QUE ENVIAMOS EN LA VARIABLE ROLE
    public function detachUser($request, User $user){
        $request->users()->detach($user);
    }

    // ELIMINA TODOS LOS USUARIOS Y AGREGA LOS NUEVOS
    public function syncUser($request, User $user){
        $request->users()->sync($user);
    }

    public function getRolCapabilities($user){
        $roles = [];
        $capabilities = [];

        foreach ($user->roles as $value) {
            if($value){
                $roles[] = $value->name;
                foreach ($value->capabilities as $capability){
                    $capabilities[] = $capability->name;
                }
            }
        };
        return $this->getCapabilities($user, $capabilities);
    }

    public function getCapabilities($user, $capabilities){
        if ($capabilities){
            foreach ($user->capabilities as $value) {
                if($value){
                    $capabilities[] = $value->name;
                }
            }
            return $capabilities;
        }
        return [];
    }
}
