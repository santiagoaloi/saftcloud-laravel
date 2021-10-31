<?php

namespace App\Http\Controllers\Private;

use Illuminate\Http\Request;
use App\Models\Private\PointOfSale;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class PointOfSaleController extends Controller {

    public function store(Request $request) {
        $this->authorize(ability: 'store', arguments: [PointOfSale::class, 'PointOfSale.store']);
        try{
            $query = PointOfSale::create($request->all());
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
        $this->authorize(ability: 'show', arguments: [PointOfSale::class, 'PointOfSale.show']);
        $result = PointOfSale::find($id);
        origin($result);

        return response([
            'record'=> $result
        ], 200);
    }

    public function showAll() {
        $this->authorize(ability: 'showAll', arguments: [PointOfSale::class, 'PointOfSale.showAll']);
        $result = PointOfSale::get();
        foreach ($result as $item){
            origin($item);
        }

        return response([
            'records'=> $result
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function showTrashed() {
        $this->authorize(ability: 'showTrashed', arguments: [PointOfSale::class, 'PointOfSale.showTrashed']);
        return response([
            'records'=> PointOfSale::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $this->authorize(ability: 'recoveryTrashed', arguments: [PointOfSale::class, 'PointOfSale.recoveryTrashed']);
        return response([
            'record'=> PointOfSale::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize(ability: 'update', arguments: [PointOfSale::class, 'PointOfSale.update']);
        $query = PointOfSale::find($id);
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
        $this->authorize(ability: 'updateAll', arguments: [PointOfSale::class, 'PointOfSale.updateAll']);
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize(ability: 'destroy', arguments: [PointOfSale::class, 'PointOfSale.destroy']);
        $query = PointOfSale::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize(ability: 'forceDestroy', arguments: [PointOfSale::class, 'PointOfSale.forceDestroy']);
        $query = PointOfSale::withTrashed()->find($id);
        $query->forceDelete();
        return response([
            'status'=> true
        ], 200);
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attachPointOfSale(PointOfSale $pointOfSale, Request $request){
        $this->authorize(ability: 'attach', arguments: [PointOfSale::class, 'PointOfSale.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $pointOfSale->$class()->attach($arr);
    }

    // ELIMINA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function detachPointOfSale(PointOfSale $pointOfSale, Request $request){
        $this->authorize(ability: 'attach', arguments: [PointOfSale::class, 'PointOfSale.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $pointOfSale->$class()->detach($arr);
    }

    // SINCRONIZA TODOS LOS ITEMS ENVIADOS EN REQUEST
    public function syncPointOfSale(PointOfSale $pointOfSale, Request $request){
        $this->authorize(ability: 'attach', arguments: [PointOfSale::class, 'PointOfSale.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $pointOfSale->$class()->sync($arr);
    }
}
