<?php

namespace App\Http\Controllers\Pos;

use App\Models\Pos\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class BrandController extends Controller {

    public function store(Request $request) {
        $this->authorize(ability: 'store', arguments: [Brand::class, 'Brand.store']);
        try{
            $query = Brand::create($request->all());
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
        $this->authorize(ability: 'show', arguments: [Brand::class, 'Brand.show']);
        $result = Brand::find($id);
        origin($result);

        return response([
            'record'=> $result
        ], 200);
    }

    public function showAll() {
        $this->authorize(ability: 'showAll', arguments: [Brand::class, 'Brand.showAll']);
        $result = Brand::get();
        foreach ($result as $item){
            origin($item);
        }

        return response([
            'records'=> $result
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function showTrashed() {
        $this->authorize(ability: 'showTrashed', arguments: [Brand::class, 'Brand.showTrashed']);
        return response([
            'records'=> Brand::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $this->authorize(ability: 'recoveryTrashed', arguments: [Brand::class, 'Brand.recoveryTrashed']);
        return response([
            'record'=> Brand::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize(ability: 'update', arguments: [Brand::class, 'Brand.update']);
        $query = Brand::find($id);
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
        $this->authorize(ability: 'updateAll', arguments: [Brand::class, 'Brand.updateAll']);
        foreach($request as $item){
            $this->update($item, $item->id);
        };
        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize(ability: 'destroy', arguments: [Brand::class, 'Brand.destroy']);
        $query = Brand::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize(ability: 'forceDestroy', arguments: [Brand::class, 'Brand.forceDestroy']);
        $query = Brand::withTrashed()->find($id);
        $query->forceDelete();
        return response([
            'status'=> true
        ], 200);
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attachPaymentMethod(Brand $brand, Request $request){
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $brand->$class()->attach($arr);
    }

    // ELIMINA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function detachPaymentMethod(Brand $brand, Request $request){
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $brand->$class()->detach($arr);
    }

    // SINCRONIZA TODOS LOS ITEMS ENVIADOS EN REQUEST
    public function syncPaymentMethod(Brand $brand, Request $request){
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $brand->$class()->sync($arr);
    }
}
