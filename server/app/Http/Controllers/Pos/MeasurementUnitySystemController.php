<?php

namespace App\Http\Controllers\Pos;

use App\Models\Pos\MeasurementUnitSystem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class MeasurementUnitySystemController extends Controller {

    public function store(Request $request) {
        $this->authorize(ability: 'store', arguments: [MeasurementUnitSystem::class, 'MeasurementUnitSystem.store']);
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

    public function show($id) {
        $this->authorize(ability: 'show', arguments: [MeasurementUnitSystem::class, 'MeasurementUnitSystem.show']);
        $result = MeasurementUnitSystem::find($id);
        origin($result);

        return response([
            'record'=> $result
        ], 200);
    }

    public function showAll() {
        $this->authorize(ability: 'showAll', arguments: [MeasurementUnitSystem::class, 'MeasurementUnitSystem.showAll']);
        $result = MeasurementUnitSystem::get();
        foreach ($result as $item){
            origin($item);
        }

        return response([
            'records'=> $result
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function showTrashed() {
        $this->authorize(ability: 'showTrashed', arguments: [MeasurementUnitSystem::class, 'MeasurementUnitSystem.showTrashed']);
        return response([
            'records'=> MeasurementUnitSystem::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $this->authorize(ability: 'recoveryTrashed', arguments: [MeasurementUnitSystem::class, 'MeasurementUnitSystem.recoveryTrashed']);
        return response([
            'record'=> MeasurementUnitSystem::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize(ability: 'update', arguments: [MeasurementUnitSystem::class, 'MeasurementUnitSystem.update']);
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
        $this->authorize(ability: 'updateAll', arguments: [MeasurementUnitSystem::class, 'MeasurementUnitSystem.updateAll']);
        foreach($request as $item){
            $this->update($item, $item->id);
        };
        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize(ability: 'destroy', arguments: [MeasurementUnitSystem::class, 'MeasurementUnitSystem.destroy']);
        $query = MeasurementUnitSystem::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize(ability: 'forceDestroy', arguments: [MeasurementUnitSystem::class, 'MeasurementUnitSystem.forceDestroy']);
        $query = MeasurementUnitSystem::withTrashed()->find($id);
        $query->forceDelete();
        return response([
            'status'=> true
        ], 200);
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attachAccountPayment(MeasurementUnitSystem $measurementUnitSystem, Request $request){
        $this->authorize(ability: 'attach', arguments: [MeasurementUnitSystem::class, 'MeasurementUnitSystem.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $measurementUnitSystem->$class()->attach($arr);
    }

    // ELIMINA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function detachAccountPayment(MeasurementUnitSystem $measurementUnitSystem, Request $request){
        $this->authorize(ability: 'attach', arguments: [MeasurementUnitSystem::class, 'MeasurementUnitSystem.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $measurementUnitSystem->$class()->detach($arr);
    }

    // SINCRONIZA TODOS LOS ITEMS ENVIADOS EN REQUEST
    public function syncAccountPayment(MeasurementUnitSystem $measurementUnitSystem, Request $request){
        $this->authorize(ability: 'attach', arguments: [MeasurementUnitSystem::class, 'MeasurementUnitSystem.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $measurementUnitSystem->$class()->sync($arr);
    }
}
