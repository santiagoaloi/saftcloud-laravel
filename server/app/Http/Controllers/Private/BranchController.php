<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use App\Models\Private\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller {

    public function store(Request $request) {
        $query = Branch::create($request->all());
        return response([
            'row'=> $query,
            'status' => true
        ], 200);
    }

    public function show(Request $id) {
        $result = Branch::find($id);

        return response([
            'row'=> $result,
            'status' => true
        ], 200);
    }

    public function showAll() {
        return response([
            'rows'=> Branch::get(),
            'status'=> true
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        return response([
            'rows'=> Branch::onlyTrashed()->get(),
            'status'=> true
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        return response([
            'row'=> Branch::onlyTrashed()->findOrFail($id)->recovery(),
            'status'=> true
        ], 200);
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        $query = Branch::findOrFail($id);
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
        $query = Branch::findOrFail($id);
        $query->delete();

        return $this->showAll();
    }
}
