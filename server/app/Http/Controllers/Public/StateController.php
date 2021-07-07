<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Public\State;
use Illuminate\Http\Request;

class StateController extends Controller {

    public function store(Request $request) {
        $query = State::create($request->all());
        return response([
            'row'=> $query
        ], 200);
    }

    public function show(Request $id) {
        return response([
            'row'=> State::find($id)
        ], 200);
    }

    public function showAll() {
        return response([
            'rows'=> State::get()
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        return response([
            'rows'=> State::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        return response([
            'row'=> State::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        $query = State::find($id);
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
        $query = State::find($id);
        $query->delete();

        return $this->showAll();
    }
}
