<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use App\Models\Private\Role;
use Illuminate\Http\Request;

class RoleController extends Controller {

    public function store(Request $request) {
        $query = Role::create($request->all());
        return response([
            'row'=> $query,
            'status'=> true
        ], 200);
    }

    public function show(Request $id) {
        $result = Role::findOrFail($id);

        return response([
            'row'=> $result,
            'status'=> true
        ], 200);
    }

    public function showAll() {
        return response([
            'rows'=> Role::get(),
            'status'=> true
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        return response([
            'rows'=> Role::onlyTrashed()->get(),
            'status'=> true
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        return response([
            'row'=> Role::onlyTrashed()->findOrFail($id)->recovery(),
            'status'=> true
        ], 200);
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        $query = Role::findOrFail($id);
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
        $query = Role::findOrFail($id);
        $query->delete();

        return $this->showAll();
    }
}
