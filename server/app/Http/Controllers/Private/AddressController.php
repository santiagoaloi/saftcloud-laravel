<?php

namespace App\Http\Controllers\Private;

use Illuminate\Http\Request;
use App\Models\Private\Address;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class AddressController extends Controller {

    public function store(Request $request) {
        $this->authorize('store', Address::class);
        try{
            $query = Address::create($request->all());
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
            'row' => $query
        ], 200);
    }

    public function show(Request $id) {
        $this->authorize('show', Address::class);
        $result = Address::find($id);

        return response([
            'row' => $result
        ], 200);
    }

    public function showAll() {
        $this->authorize('showAll', Address::class);
        return response([
            'rows' => Address::get()
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        $this->showTrashed('restore', Address::class);
        return response([
            'rows' => Address::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function restore($id) {
        $this->authorize('restore', Address::class);
        return response([
            'row' => Address::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize('update', Address::class);
        $query = Address::find($id);
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
        $this->authorize('updateAll', Address::class);
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize('destroy', Address::class);
        $query = Address::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize('forceDestroy', Capability::class);
        $query = Address::withTrashed()->find($id);
        $query->forceDelete();
        return response([
            'status'=> true
        ], 200);
    }
}
