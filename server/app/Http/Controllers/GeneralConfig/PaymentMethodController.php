<?php

namespace App\Http\Controllers\GeneralConfig;

use App\Http\Controllers\Controller;
use App\Models\GeneralConfig\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller {

    public function store(Request $request) {
        $query = PaymentMethod::create($request->all());
        return response([
            'row'=> $query
        ], 200);
    }

    public function show(Request $id) {
        $result = PaymentMethod::find($id);

        return response([
            'row'=> $result
        ], 200);
    }

    public function showAll() {
        return response([
            'rows'=> PaymentMethod::get()
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        return response([
            'rows'=> PaymentMethod::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        return response([
            'row'=> PaymentMethod::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        $query = PaymentMethod::find($id);
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
        $query = PaymentMethod::find($id);
        $query->delete();

        return $this->showAll();
    }
}
