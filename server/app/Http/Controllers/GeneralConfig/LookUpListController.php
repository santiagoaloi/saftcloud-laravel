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

    public function show(Request $id) {
        return response([
            'row'=> LookUpList::findOrFail($id),
            'status'=> true
        ], 200);
    }

    public function showAll() {
        return response([
            'rows'=> LookUpList::get(),
            'status'=> true
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        return response([
            'rows'=> LookUpList::onlyTrashed()->get(),
            'status'=> true
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        return response([
            'row'=> LookUpList::onlyTrashed()->findOrFail($id)->recovery(),
            'status'=> true
        ], 200);
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        $query = LookUpList::findOrFail($id);
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
        $query = LookUpList::findOrFail($id);
        $query->delete();

        return $this->showAll();
    }
}
