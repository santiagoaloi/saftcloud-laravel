<?php

namespace App\Http\Controllers\Roles;

use App\Models\Roles\Capability;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class CapabilityController extends Controller {

    public function store(Request $request) {
        $this->authorize('store', Capability::class);
        try{
            $query = Capability::create($request->all());
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

    public function show(Request $id) {
        $this->authorize('show', Capability::class);
        $result = Capability::find($id);

        return response([
            'record'=> $result
        ], 200);
    }

    public function showAll() {
        $this->authorize('showAll', Capability::class);
        return response([
            'records'=> Capability::get()
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        $this->authorize('store', Capability::class);
        return response([
            'records'=> Capability::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function restore($id) {
        $this->authorize('restore', Capability::class);
        return response([
            'record'=> Capability::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize('update', Capability::class);
        $query = Capability::find($id);
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
        $this->authorize('updateAll', Capability::class);
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize('destroy', Capability::class);
        $query = Capability::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize('forceDestroy', Capability::class);
        $query = Capability::withTrashed()->find($id);
        $query->forceDelete();
        return response([
            'status'=> true
        ], 200);
    }

    // AGREGA TODOS LOS ROLES QUE ENVIAMOS EN LA VARIABLE ROLE
    public function attachRoles($request, Capability $capability){
        $request->capability()->attach($capability);
    }

    // ELIMINA TODOS LOS ROLES QUE ENVIAMOS EN LA VARIABLE ROLE
    public function detachRoles($request, Capability $capability){
        $request->capability()->detach($capability);
    }

    // ELIMINA TODOS LOS ROLES Y AGREGA LOS NUEVOS
    public function syncRoles($request, Capability $capability){
        $request->capability()->sync($capability);
    }
}
