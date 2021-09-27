<?php

namespace App\Http\Controllers\Roles;

use App\Models\Roles\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class RoleController extends Controller {

    public function store(Request $request) {
        $this->authorize('store', Role::class);
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
            'row'=> $query
        ], 200);
    }

    public function show(Request $id) {
        $this->authorize('show', Role::class);
        $result = Role::find($id);

        return response([
            'row'=> $result
        ], 200);
    }

    public function showAll() {
        $this->authorize('showAll', Role::class);
        return response([
            'rows'=> Role::get()
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        $this->authorize('getTrashed', Role::class);
        return response([
            'rows'=> Role::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function restore($id) {
        $this->authorize('restore', Role::class);
        return response([
            'row'=> Role::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize('update', Role::class);
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
            'row'=> $query
        ], 200);
    }

    public function updateAll(Request $request) {
        $this->authorize('updateAll', Role::class);
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize('destroy', Role::class);
        $query = Role::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize('forceDestroy', Role::class);
        $query = Role::withTrashed()->find($id);
        $query->forceDelete();
        return response([
            'status'=> true
        ], 200);
    }

    // AGREGA TODOS LOS ROLES QUE ENVIAMOS EN LA VARIABLE ROLE
    public function attachRoles($request, Role $role){
        $request->roles()->attach($role);
    }

    // ELIMINA TODOS LOS ROLES QUE ENVIAMOS EN LA VARIABLE ROLE
    public function detachRoles($request, Role $role){
        $request->roles()->detach($role);
    }

    // ELIMINA TODOS LOS ROLES Y AGREGA LOS NUEVOS
    public function syncRoles($request, Role $role){
        $request->roles()->sync($role);
    }
}
