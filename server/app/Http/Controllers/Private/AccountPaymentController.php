<?php

namespace App\Http\Controllers\Private;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Private\AccountPayment;
use Illuminate\Database\QueryException;

class AccountPaymentController extends Controller {

    public function store(Request $request) {
        $this->authorize('store', AccountPayment::class);
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
        $this->authorize('show', AccountPayment::class);
        $result = AccountPayment::find($id);
        origin($result);

        return response([
            'record' => $result
        ], 200);
    }

    public function showAll() {
        $this->authorize('showAll', AccountPayment::class);
        $result = AccountPayment::get();
        foreach ($result as $item){
            origin($item);
        }

        return response([
            'records' => $result
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        $this->showTrashed('restore', AccountPayment::class);
        return response([
            'records' => AccountPayment::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function restore($id) {
        $this->authorize('restore', AccountPayment::class);
        return response([
            'record' => AccountPayment::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize('update', AccountPayment::class);
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
        $this->authorize('updateAll', AccountPayment::class);
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize('destroy', AccountPayment::class);
        $query = AccountPayment::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize('forceDestroy', AccountPayment::class);
        $query = AccountPayment::withTrashed()->find($id);
        $query->forceDelete();
        return response([
            'status'=> true
        ], 200);
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attachAccountPayment(AccountPayment $accountPayment, Request $request){
        $items = $request['items'];
        $class = $request['name'];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $accountPayment->$class()->attach($arr);
    }

    // ELIMINA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function detachAccountPayment(AccountPayment $accountPayment, Request $request){
        $items = $request['items'];
        $class = $request['name'];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $accountPayment->$class()->detach($arr);
    }

    // SINCRONIZA TODOS LOS ITEMS ENVIADOS EN REQUEST
    public function syncAccountPayment(AccountPayment $accountPayment, Request $request){
        $items = $request['items'];
        $class = $request['name'];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $accountPayment->$class()->sync($arr);
    }
}
