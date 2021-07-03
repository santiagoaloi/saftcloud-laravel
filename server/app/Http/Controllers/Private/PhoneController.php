<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use App\Models\Private\Phone;
use Illuminate\Http\Request;

class PhoneController extends Controller {

    public function store(Request $request) {
        $query = Phone::create($request->all());
        return response([
            'row'=> $query,
            'status'=> true
        ], 200);
    }

    public function show(Request $id, $local = false) {
        $result = Phone::find($id);

        if ($local){
            return $result;
        } else {
            return response([
                'row'=> $result,
                'status'=> true
            ], 200);
        }
    }

    public function showAll($local = false) {
        if ($local){
            return Phone::get();
        } else {
            return response([
                'rows'=> Phone::get(),
                'status'=> true
            ], 200);
        }
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        $result = Phone::onlyTrashed()->get();

        return response([
            'rows'=> $result,
            'status'=> true
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $result = Phone::onlyTrashed()->findOrFail($id)->recovery();

        return response([
            'row'=> $result,
            'status'=> true
        ], 200);
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        $query = Phone::findOrFail($id);

        $input = $request->all();

        $query->fill($input)->save();

        return response([
            'row'=> $query,
            'status'=> true
        ], 200);
    }

    public function updateAll(Request $request) {
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        $result = $this->showAll(true);

        return response([
            'rows'=> $result,
            'status'=> true
        ], 200);
    }

    public function destroy($id) {
        $query = Phone::findOrFail($id);
        $query->delete();

        return $this->showAll(true);
    }
}
