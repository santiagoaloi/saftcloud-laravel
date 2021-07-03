<?php

namespace App\Http\Controllers\GeneralConfig;

use App\Http\Controllers\Controller;
use App\Models\GeneralConfig\LookUpList;
use App\Models\GeneralConfig\LookUpListValue;
use Illuminate\Http\Request;

class LookUpListController extends Controller {

    public function store(Request $request) {
        $query = LookUpList::create($request->all());
        return response([
            'row'=> $query,
            'status'=> true
        ], 200);
    }

    public function show(Request $id, $local = false) {
        $result = LookUpList::findOrFail($id);

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
            return LookUpList::get();
        } else {
            return response([
                'rows'=> LookUpList::get(),
                'status'=> true
            ], 200);
        }
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        $result = LookUpList::onlyTrashed()->get();

        return response([
            'rows'=> $result,
            'status'=> true
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $result = LookUpList::onlyTrashed()->findOrFail($id)->recovery();

        return response([
            'row'=> $result,
            'status'=> true
        ], 200);
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, LookUpListValue $obj) {
        // $query = LookUpList::findOrFail($id);

        // $input = $request->all();

        // $query->fill($input)->save();

        $obj->update($request->all());

        return response([
            'row'=> $obj,
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
        $query = LookUpList::findOrFail($id);
        $query->delete();

        return $this->showAll(true);
    }
}
