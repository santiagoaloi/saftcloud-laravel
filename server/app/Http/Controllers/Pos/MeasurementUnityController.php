<?php

namespace App\Http\Controllers\Pos;

use App\Models\Pos\MeasurementUnit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class MeasurementUnityController extends Controller {

    public function store(Request $request) {
        $this->authorize(ability: 'store', arguments: [MeasurementUnit::class, 'MeasurementUnit.store']);
        try{
            $query = MeasurementUnit::create($request->all());
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
        $this->authorize(ability: 'show', arguments: [MeasurementUnit::class, 'MeasurementUnit.show']);
        $result = MeasurementUnit::find($id);
        origin($result);

        return response([
            'record'=> $result
        ], 200);
    }

    public function showAll() {
        $this->authorize(ability: 'showAll', arguments: [MeasurementUnit::class, 'MeasurementUnit.showAll']);
        $result = MeasurementUnit::get();
        foreach ($result as $item){
            origin($item);
        }

        return response([
            'records'=> $result
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function showTrashed() {
        $this->authorize(ability: 'showTrashed', arguments: [MeasurementUnit::class, 'MeasurementUnit.showTrashed']);
        return response([
            'records'=> MeasurementUnit::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $this->authorize(ability: 'recoveryTrashed', arguments: [MeasurementUnit::class, 'MeasurementUnit.recoveryTrashed']);
        return response([
            'record'=> MeasurementUnit::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize(ability: 'update', arguments: [MeasurementUnit::class, 'MeasurementUnit.update']);
        $query = MeasurementUnit::find($id);
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
        $this->authorize(ability: 'updateAll', arguments: [MeasurementUnit::class, 'MeasurementUnit.updateAll']);
        foreach($request as $item){
            $this->update($item, $item->id);
        };
        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize(ability: 'destroy', arguments: [MeasurementUnit::class, 'MeasurementUnit.destroy']);
        $query = MeasurementUnit::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize(ability: 'forceDestroy', arguments: [MeasurementUnit::class, 'MeasurementUnit.forceDestroy']);
        $query = MeasurementUnit::withTrashed()->find($id);
        $query->forceDelete();
        return response([
            'status'=> true
        ], 200);
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attachPaymentMethod(MeasurementUnit $var, Request $request){
        $this->authorize(ability: 'attach', arguments: [MeasurementUnit::class, 'MeasurementUnit.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->attach($arr);
    }

    // ELIMINA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function detachPaymentMethod(MeasurementUnit $var, Request $request){
        $this->authorize(ability: 'attach', arguments: [MeasurementUnit::class, 'MeasurementUnit.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->detach($arr);
    }

    // SINCRONIZA TODOS LOS ITEMS ENVIADOS EN REQUEST
    public function syncPaymentMethod(MeasurementUnit $var, Request $request){
        $this->authorize(ability: 'attach', arguments: [MeasurementUnit::class, 'MeasurementUnit.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->sync($arr);
    }
}
