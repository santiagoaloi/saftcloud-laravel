<?php

namespace App\Http\Controllers\GeneralConfig;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Models\GeneralConfig\PaymentMethod;

class PaymentMethodController extends Controller {

    public function store(Request $request) {
        $this->authorize('store', PaymentMethod::class);
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
            'row'=> $query
        ], 200);
    }

    public function show(Request $id) {
        $this->authorize('show', PaymentMethod::class);
        $result = PaymentMethod::find($id);

        return response([
            'row'=> $result
        ], 200);
    }

    public function showAll() {
        $this->authorize('showAll', PaymentMethod::class);
        return response([
            'rows'=> PaymentMethod::get()
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        $this->authorize('getTrashed', PaymentMethod::class);
        return response([
            'rows'=> PaymentMethod::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function restore($id) {
        $this->authorize('restore', PaymentMethod::class);
        return response([
            'row'=> PaymentMethod::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize('update', PaymentMethod::class);
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
            'row'=> $query
        ], 200);
    }

    public function updateAll(Request $request) {
        $this->authorize('updateAll', PaymentMethod::class);
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize('destroy', PaymentMethod::class);
        $query = PaymentMethod::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize('forceDestroy', PaymentMethod::class);
        $query = PaymentMethod::withTrashed()->find($id);
        $query->forceDelete();
        return response([
            'status'=> true
        ], 200);
    }
}
