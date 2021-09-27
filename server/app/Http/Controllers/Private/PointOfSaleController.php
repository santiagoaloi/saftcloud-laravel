<?php

namespace App\Http\Controllers\Private;

use Illuminate\Http\Request;
use App\Models\Private\PointOfSale;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class PointOfSaleController extends Controller {

    public function store(Request $request) {
        $this->authorize('forceDestroy', PointOfSale::class);
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

    public function show(Request $id) {
        $this->authorize('forceDestroy', PointOfSale::class);
        $result = PointOfSale::find($id);

        return response([
            'record'=> $result
        ], 200);
    }

    public function showAll() {
        $this->authorize('forceDestroy', PointOfSale::class);
        return response([
            'records'=> PointOfSale::get()
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        $this->authorize('forceDestroy', PointOfSale::class);
        return response([
            'records'=> PointOfSale::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $this->authorize('forceDestroy', PointOfSale::class);
        return response([
            'record'=> PointOfSale::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize('forceDestroy', PointOfSale::class);
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
        $this->authorize('forceDestroy', PointOfSale::class);
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize('forceDestroy', PointOfSale::class);
        $query = PointOfSale::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize('forceDestroy', PointOfSale::class);
        $query = PointOfSale::withTrashed()->find($id);
        $query->forceDelete();
        return response([
            'status'=> true
        ], 200);
    }
}
