<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use App\Models\Private\PointOfSale;
use Illuminate\Http\Request;

class PointOfSaleController extends Controller {

    public function store(Request $request) {
        $query = PointOfSale::create($request->all());
        return response([
            'row'=> $query
        ], 200);
    }

    public function show(Request $id) {
        $result = PointOfSale::find($id);

        return response([
            'row'=> $result
        ], 200);
    }

    public function showAll() {
        return response([
            'rows'=> PointOfSale::get()
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        return response([
            'rows'=> PointOfSale::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        return response([
            'row'=> PointOfSale::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        $query = PointOfSale::find($id);
        $query->fill($request->all())->save();

        return response([
            'row'=> $query
        ], 200);
    }

    public function updateAll(Request $request) {
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $query = PointOfSale::find($id);
        $query->delete();

        return $this->showAll();
    }
}
