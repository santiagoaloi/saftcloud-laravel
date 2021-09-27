<?php

namespace App\Http\Controllers\Public;

use App\Models\Public\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class StateController extends Controller {

    public function store(Request $request) {
        try{
            $query = State::create($request->all());
        }
        catch(QueryException $e){
            if($e->errorInfo[1]){
                return response([
                    'message'=> $e->errorInfo[2],
                    'code'=> $e->errorInfo[1]
                ], 404);
            }
        }

        return response([
            'record'=> $query
        ], 200);
    }

    public function show(Request $id) {
        return response([
            'record'=> State::find($id)
        ], 200);
    }

    public function showAll($country_id) {
        return response([
            'records'=> State::where('country_id', $country_id)->get()
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        return response([
            'records'=> State::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        return response([
            'record'=> State::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $query = State::find($id);

        try{
            $query->fill($request->all())->save();
        }
        catch(QueryException $e){
            if($e->errorInfo[1]){
                return response([
                    'message'=> $e->errorInfo[2],
                    'code'=> $e->errorInfo[1]
                ], 404);
            }
        }

        return response([
            'record'=> $query
        ], 200);
    }

    public function updateAll(Request $request) {
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return response([
            'message'=> "Todos los estados fueron actualizadas."
        ], 200);
    }

    public function destroy($id) {
        $query = State::find($id);
        $query->delete();

        return response([
            'message'=> "Estado eliminado."
        ], 200);
    }
}
