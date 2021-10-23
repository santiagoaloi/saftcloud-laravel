<?php

namespace App\Http\Controllers\Pos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pos\ProductPromotion;
use Illuminate\Database\QueryException;

class ProductPromotionController extends Controller {

    public function store(Request $request) {
        $this->authorize(ability: 'store', arguments: [ProductPromotion::class, 'ProductPromotion.store']);
        try{
            $query = ProductPromotion::create($request->all());
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
        $this->authorize(ability: 'show', arguments: [ProductPromotion::class, 'ProductPromotion.show']);
        $result = ProductPromotion::find($id);
        origin($result);

        return response([
            'record'=> $result
        ], 200);
    }

    public function showAll() {
        $this->authorize(ability: 'showAll', arguments: [ProductPromotion::class, 'ProductPromotion.showAll']);
        $result = ProductPromotion::get();
        foreach ($result as $item){
            origin($item);
        }

        return response([
            'records'=> $result
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function showTrashed() {
        $this->authorize(ability: 'showTrashed', arguments: [ProductPromotion::class, 'ProductPromotion.showTrashed']);
        return response([
            'records'=> ProductPromotion::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $this->authorize(ability: 'recoveryTrashed', arguments: [ProductPromotion::class, 'ProductPromotion.recoveryTrashed']);
        return response([
            'record'=> ProductPromotion::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize(ability: 'update', arguments: [ProductPromotion::class, 'ProductPromotion.update']);
        $query = ProductPromotion::find($id);
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
        $this->authorize(ability: 'updateAll', arguments: [ProductPromotion::class, 'ProductPromotion.updateAll']);
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize(ability: 'destroy', arguments: [ProductPromotion::class, 'ProductPromotion.destroy']);
        $query = ProductPromotion::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize(ability: 'forceDestroy', arguments: [ProductPromotion::class, 'ProductPromotion.forceDestroy']);
        $query = ProductPromotion::withTrashed()->find($id);
        $query->forceDelete();
        return response([
            'status'=> true
        ], 200);
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attachAccountPayment(ProductPromotion $var, Request $request){
        $this->authorize(ability: 'attach', arguments: [ProductPromotion::class, 'ProductPromotion.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->attach($arr);
    }

    // ELIMINA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function detachAccountPayment(ProductPromotion $var, Request $request){
        $this->authorize(ability: 'attach', arguments: [ProductPromotion::class, 'ProductPromotion.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->detach($arr);
    }

    // SINCRONIZA TODOS LOS ITEMS ENVIADOS EN REQUEST
    public function syncAccountPayment(ProductPromotion $var, Request $request){
        $this->authorize(ability: 'attach', arguments: [ProductPromotion::class, 'ProductPromotion.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->sync($arr);
    }
}
