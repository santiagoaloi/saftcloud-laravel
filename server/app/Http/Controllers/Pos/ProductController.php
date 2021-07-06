<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Pos\Product;
use Illuminate\Http\Request;

class ProductController extends Controller {

    public function store(Request $request) {
        $query = Product::create($request->all());
        return response([
            'row'=> $query,
            'status'=> true
        ], 200);
    }

    public function show(Request $id, $local = false) {
        return response([
            'row'=> Product::findOrFail($id),
            'status'=> true
        ], 200);
    }

    public function showAll() {
        return response([
            'rows'=> Product::get(),
            'status'=> true
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        return response([
            'rows'=> Product::onlyTrashed()->get(),
            'status'=> true
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        return response([
            'row'=> Product::onlyTrashed()->findOrFail($id)->recovery(),
            'status'=> true
        ], 200);
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        $query = Product::findOrFail($id);
        $query->fill($request->all())->save();

        return response([
            'row'=> $query,
            'status'=> true
        ], 200);
    }

    public function updateAll(Request $request) {
        foreach($request as $item){
            $this->update($item, $item->id);
        };
        return $this->showAll();
    }

    public function destroy($id) {
        $query = Product::findOrFail($id);
        $query->delete();

        return $this->showAll();
    }
}
