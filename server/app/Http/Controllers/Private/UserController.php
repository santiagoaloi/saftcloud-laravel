<?php

namespace App\Http\Controllers\Private;

use App\Models\User;
use App\Models\Roles\Role;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class UserController extends Controller {

    public function store(Request $request) {
        //** TEST PARA SUBIR ARCHIVOS AL CREAR UN USUARIO */
        // if($request->hasFile('picture')){
        //     $query['picture']=$request->file('picture')->store('avatars', 'public');
        // };

        $this->authorize(ability: 'store', arguments: [User::class, 'User.store']);
        try{
            $admin = auth()->User();
            $account = $admin->Entity->RootAccount;
            $branch = $admin->Branch[0];

            // CREACION DE PERSONA
            $person = $account->entity()->create([
                'entity_type_id'    => 2,
                'first_name'        => $request['name'],
                'last_name'         => $request['last_name'],
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
            $br = new Request(['items'=>$branch, 'name'=>'branch']);
            $this->attachUserS($user, $br);

            $role = Role::findOrFail(3);
            $rol = new Request(['items'=>$role, 'name'=>'role']);
            $this->attachUserS($user, $rol);

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
        $this->authorize(ability: 'show', arguments: [User::class, 'User.show']);
        $user = User::findOrFail($id);
        $user->entity;
        $user->privileges = getRoles($user->role);
        origin($user);

        return response([
            'record'=> $user
        ], 200);
    }

    public function showAll() {
        $this->authorize(ability: 'showAll', arguments: [User::class, 'User.showAll']);

        $branch = Auth::user()->branch[0];
        $users = $branch->user;

        foreach($users as $user){
            $user->userSetting;
            $user->entity;
            $user->branch;
            $user->privileges = getRoles($user->role);
            origin($user);

            $newUsers[] = $user;
        }

        return response([
            'records'=> $newUsers
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function showTrashed() {
        $this->authorize(ability: 'showTrashed', arguments: [User::class, 'User.showTrashed']);
        return response([
            'records'=> User::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $this->authorize(ability: 'recoveryTrashed', arguments: [User::class, 'User.recoveryTrashed']);
        return response([
            'record'=> User::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize(ability: 'update', arguments: [User::class, 'User.update']);
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
        $this->authorize(ability: 'updateAll', arguments: [User::class, 'User.updateAll']);
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize(ability: 'destroy', arguments: [User::class, 'User.destroy']);
        $query = User::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize(ability: 'forceDestroy', arguments: [User::class, 'User.forceDestroy']);
        $query = User::withTrashed()->find($id);
        $query->forceDelete();
        return response([
            'status'=> true
        ], 200);
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attach(User $user, Request $request){
        $this->authorize(ability: 'attach', arguments: [User::class, 'User.attach']);
        $items = $request['items'];
        $class = $request['name'];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $user->$class()->attach($arr);
    }

        // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
        public function attachUserS(User $user, Request $request){
            $items = $request['items'];
            $class = $request['name'];

            $user->$class()->attach($items);
        }

    // ELIMINA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function detach(User $user, Request $request){
        $this->authorize(ability: 'attach', arguments: [User::class, 'User.attach']);
        $items = $request['items'];
        $class = $request['name'];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $user->$class()->detach($arr);
    }

    // SINCRONIZA TODOS LOS ITEMS ENVIADOS EN REQUEST
    public function sync(User $user, Request $request){
        $this->authorize(ability: 'attach', arguments: [User::class, 'User.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

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

    public function test(User $user){
        return $user;
    }
}
