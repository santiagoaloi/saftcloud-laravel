<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use App\Models\Private\Role;
use Illuminate\Http\Request;

class RoleController extends Controller {

    public function store(Request $request) {
        $query = Role::create($request);
        return response([
            'row' => $query,
            'status' => true
        ], 200);
    }

    public function show(Request $id, $local = false) {
        $result = Role::findOrFail($id);

        if ($local){
            return $result;
        } else {
            return response([
                'row' => $result,
                'status' => true
            ], 200);
        }
    }

    public function showAll($local = false) {
        if ($local){
            return Role::get();
        } else {
            return response([
                'rows' => Role::all(),
                'status'=> true
            ], 200);
        }
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        $result = Role::onlyTrashed()->get();

        return response([
            'rows' => $result,
            'status'=> true
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $result = Role::onlyTrashed()->findOrFail($id)->recovery();

        return response([
            'row' => $result,
            'status'=> true
        ], 200);
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        $query = Role::findOrFail($id);

        $input = $request->all();

        $query->fill($input)->save();

        $result = $this->show($id, true);

        return response([
            'row'=> $result,
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
        $query = Role::findOrFail($id);
        $query->delete();

        return $this->showAll(true);
    }
}
