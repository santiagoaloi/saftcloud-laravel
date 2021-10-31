<?php

namespace App\Http\Controllers\Private;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Private\AccountPayment;
use Illuminate\Database\QueryException;

class AccountPaymentController extends Controller {

    public function store(Request $request) {
        $this->authorize(ability: 'store', arguments: [AccountPayment::class, 'AccountPayment.store']);
        try{
            $query = AccountPayment::create($request->all());
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
            'record' => $query
        ], 200);
    }

    public function show($id) {
        $this->authorize(ability: 'show', arguments: [AccountPayment::class, 'AccountPayment.show']);
        $result = AccountPayment::find($id);
        origin($result);

        return response([
            'record' => $result
        ], 200);
    }

    public function showAll() {
        $this->authorize(ability: 'showAll', arguments: [AccountPayment::class, 'AccountPayment.showAll']);
        $result = AccountPayment::get();
        foreach ($result as $item){
            origin($item);
        }

        return response([
            'records' => $result
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function showTrashed() {
        $this->authorize(ability: 'showTrashed', arguments: [AccountPayment::class, 'AccountPayment.showTrashed']);
        return response([
            'records' => AccountPayment::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $this->authorize(ability: 'recoveryTrashed', arguments: [AccountPayment::class, 'AccountPayment.recoveryTrashed']);
        return response([
            'record' => AccountPayment::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize(ability: 'update', arguments: [AccountPayment::class, 'AccountPayment.update']);
        $query = AccountPayment::find($id);
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
        $this->authorize(ability: 'updateAll', arguments: [AccountPayment::class, 'AccountPayment.updateAll']);
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize(ability: 'destroy', arguments: [AccountPayment::class, 'AccountPayment.destroy']);
        $query = AccountPayment::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize(ability: 'forceDestroy', arguments: [AccountPayment::class, 'AccountPayment.forceDestroy']);
        $query = AccountPayment::withTrashed()->find($id);
        $query->forceDelete();
        return response([
            'status'=> true
        ], 200);
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attachAccountPayment(AccountPayment $accountPayment, Request $request){
        $this->authorize(ability: 'attach', arguments: [AccountPayment::class, 'AccountPayment.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $accountPayment->$class()->attach($arr);
    }

    // ELIMINA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function detachAccountPayment(AccountPayment $accountPayment, Request $request){
        $this->authorize(ability: 'attach', arguments: [AccountPayment::class, 'AccountPayment.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $accountPayment->$class()->detach($arr);
    }

    // SINCRONIZA TODOS LOS ITEMS ENVIADOS EN REQUEST
    public function syncAccountPayment(AccountPayment $accountPayment, Request $request){
        $this->authorize(ability: 'attach', arguments: [AccountPayment::class, 'AccountPayment.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $accountPayment->$class()->sync($arr);
    }
}
