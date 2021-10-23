<?php

namespace App\Http\Controllers\GeneralConfig;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Models\GeneralConfig\PaymentMethod;

class PaymentMethodController extends Controller {

    public function store(Request $request) {
        $this->authorize(ability: 'store', arguments: [PaymentMethod::class, 'PaymentMethod.store']);
        try{
            $query = PaymentMethod::create($request->all());
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
        $this->authorize(ability: 'show', arguments: [PaymentMethod::class, 'PaymentMethod.show']);
        $result = PaymentMethod::find($id);
        origin($result);

        return response([
            'record'=> $result
        ], 200);
    }

    public function showAll() {
        $this->authorize(ability: 'showAll', arguments: [PaymentMethod::class, 'PaymentMethod.showAll']);
        $result = PaymentMethod::get();
        foreach ($result as $item){
            origin($item);
        }

        return response([
            'records'=> $result
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function showTrashed() {
        $this->authorize(ability: 'showTrashed', arguments: [PaymentMethod::class, 'PaymentMethod.showTrashed']);
        return response([
            'records'=> PaymentMethod::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $this->authorize(ability: 'recoveryTrashed', arguments: [PaymentMethod::class, 'PaymentMethod.recoveryTrashed']);
        return response([
            'record'=> PaymentMethod::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize(ability: 'update', arguments: [PaymentMethod::class, 'PaymentMethod.update']);
        $query = PaymentMethod::find($id);
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
        $this->authorize(ability: 'updateAll', arguments: [PaymentMethod::class, 'PaymentMethod.updateAll']);
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize(ability: 'destroy', arguments: [PaymentMethod::class, 'PaymentMethod.destroy']);
        $query = PaymentMethod::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize(ability: 'forceDestroy', arguments: [PaymentMethod::class, 'PaymentMethod.forceDestroy']);
        $query = PaymentMethod::withTrashed()->find($id);
        $query->forceDelete();
        return response([
            'status'=> true
        ], 200);
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attachPaymentMethod(PaymentMethod $var, Request $request){
        $this->authorize(ability: 'attach', arguments: [PaymentMethod::class, 'PaymentMethod.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->attach($arr);
    }

    // ELIMINA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function detachPaymentMethod(PaymentMethod $var, Request $request){
        $this->authorize(ability: 'attach', arguments: [PaymentMethod::class, 'PaymentMethod.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->detach($arr);
    }

    // SINCRONIZA TODOS LOS ITEMS ENVIADOS EN REQUEST
    public function syncPaymentMethod(PaymentMethod $var, Request $request){
        $this->authorize(ability: 'attach', arguments: [PaymentMethod::class, 'PaymentMethod.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->sync($arr);
    }
}
