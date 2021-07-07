<?php

namespace App\Http\Controllers\GeneralConfig;

use App\Http\Controllers\Controller;
use App\Models\GeneralConfig\LookUpListValue;
use Illuminate\Http\Request;

class LookUpListValueController extends Controller {

    public function store(Request $request) {
        $query = LookUpListValue::create($request->all());
        return response([
            'row'=> $query
        ], 200);
    }

    public function show(Request $id, $local = false) {
        $result = LookUpListValue::find($id);

        if ($local){
            return $result;
        } else {
            return response([
                'row'=> $result
            ], 200);
        }
    }

    public function showAll($local = false, $parentId = ['']) {
        if ($local){
            return LookUpListValue::whereIn('look_up_list_id', $parentId)->get();
        } else {
            return response([
                'rows'=> LookUpListValue::get()
            ], 200);
        }
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        $result = LookUpListValue::onlyTrashed()->get();

        return response([
            'rows'=> $result
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $result = LookUpListValue::onlyTrashed()->find($id)->recovery();

        return response([
            'row'=> $result
        ], 200);
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        $query = LookUpListValue::find($id);

        $input = $request->all();

        $query->fill($input)->save();

        return response([
            'row'=> $query
        ], 200);
    }

    public function updateAll(Request $request) {
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        $result = $this->showAll(true);

        return response([
            'rows'=> $result
        ], 200);
    }

    public function destroy($id) {
        $query = LookUpListValue::find($id);
        $query->delete();

        return $this->showAll(true);
    }
}
