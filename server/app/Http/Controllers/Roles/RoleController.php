<?php

namespace App\Http\Controllers\Roles;

use App\Models\Roles\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class RoleController extends Controller {

    public function store(Request $request) {
        $this->authorize(ability: 'store', arguments: [Role::class, 'Role.store']);
        try{
            $query = Role::create($request->all());
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

    public function show($id) {
        $this->authorize(ability: 'show', arguments: [Role::class, 'Role.show']);
        $result = Role::find($id);
        $result['privileges'] = $this->getCapabilities($result->capability);
        origin($result);

        return response([
            'record'=> $result
        ], 200);
    }

    public function showAll() {
        $this->authorize(ability: 'showAll', arguments: [Role::class, 'Role.showAll']);
        $result = Role::get();
        foreach($result as $role){
            $role['privileges'] = $this->getCapabilities($role->capability);
            origin($role);
            $newRoles[] = $role;
        };

        return response([
            'records'=> $newRoles
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function showTrashed() {
        $this->authorize(ability: 'showTrashed', arguments: [Role::class, 'Role.showTrashed']);
        return response([
            'records'=> Role::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $this->authorize(ability: 'recoveryTrashed', arguments: [Role::class, 'Role.recoveryTrashed']);
        return response([
            'record'=> Role::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize(ability: 'update', arguments: [Role::class, 'Role.update']);

        $query = Role::find($id);
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
        $this->authorize(ability: 'updateAll', arguments: [Role::class, 'Role.updateAll']);
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize(ability: 'destroy', arguments: [Role::class, 'Role.destroy']);
        $query = Role::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize(ability: 'forceDestroy', arguments: [Role::class, 'Role.forceDestroy']);
        $query = Role::withTrashed()->find($id);
        $query->forceDelete();

        return response([
            'status'=> true
        ], 200);
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attach(Role $role, Request $request){
        $this->authorize(ability: 'attach', arguments: [Role::class, 'Role.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $role->$class()->attach($arr);
    }

    // ELIMINA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function detach(Role $role, Request $request){
        $this->authorize(ability: 'attach', arguments: [Role::class, 'Role.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $role->$class()->detach($arr);
    }

    // SINCRONIZA TODOS LOS ITEMS ENVIADOS EN REQUEST
    public function sync(Role $role, Request $request){
        $this->authorize(ability: 'attach', arguments: [Role::class, 'Role.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $role->$class()->sync($arr);
    }

    public function getCapabilities($capabilities){
        $privilege = [];
        foreach ($capabilities as $capability){
            $privilege[] = $capability->name;
        };
        return $privilege;
    }

}
