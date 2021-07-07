<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Pos\ProductPromotion;
use Illuminate\Http\Request;

class ProductPromotionController extends Controller {

    public function store(Request $request) {
        $query = ProductPromotion::create($request->all());
        return response([
            'row'=> $query
        ], 200);
    }

    public function show(Request $id) {
        $result = ProductPromotion::find($id);

        return response([
            'row'=> $result
        ], 200);
    }

    public function showAll() {
        return response([
            'rows'=> ProductPromotion::get()
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        return response([
            'rows'=> ProductPromotion::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        return response([
            'row'=> ProductPromotion::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        $query = ProductPromotion::find($id);
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
        $query = ProductPromotion::find($id);
        $query->delete();

        return $this->showAll();
    }
}
