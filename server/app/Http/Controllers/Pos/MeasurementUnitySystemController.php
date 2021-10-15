<?php

namespace App\Http\Controllers\Pos;

use App\Models\Pos\MeasurementUnitSystem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class MeasurementUnitySystemController extends Controller {

    public function store(Request $request) {
        $this->authorize('store', MeasurementUnitSystem::class);
        try{
            $query = MeasurementUnitSystem::create($request->all());
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

    public function show(Request $id, $local = false) {
        $this->authorize('show', MeasurementUnitSystem::class);
        $result = MeasurementUnitSystem::find($id);
        origin($result);

        return response([
            'record'=> $result
        ], 200);
    }

    public function showAll() {
        $this->authorize('showAll', MeasurementUnitSystem::class);
        $result = MeasurementUnitSystem::get();
        foreach ($result as $item){
            origin($item);
        }

        return response([
            'records'=> $result
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        $this->authorize('getTrashed', MeasurementUnitSystem::class);
        return response([
            'records'=> MeasurementUnitSystem::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function restore($id) {
        $this->authorize('restore', MeasurementUnitSystem::class);
        return response([
            'record'=> MeasurementUnitSystem::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize('update', MeasurementUnitSystem::class);
        $query = MeasurementUnitSystem::find($id);
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
        $this->authorize('updateAll', MeasurementUnitSystem::class);
        foreach($request as $item){
            $this->update($item, $item->id);
        };
        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize('destroy', MeasurementUnitSystem::class);
        $query = MeasurementUnitSystem::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize('forceDestroy', MeasurementUnitSystem::class);
        $query = MeasurementUnitSystem::withTrashed()->find($id);
        $query->forceDelete();
        return response([
            'status'=> true
        ], 200);
    }
}
