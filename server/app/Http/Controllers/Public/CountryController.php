<?php

namespace App\Http\Controllers\Public;

use Illuminate\Http\Request;
use App\Models\Public\Country;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class CountryController extends Controller {

    public function store(Request $request) {
        try{
            $query = Country::create($request->all());
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
            'row'=> $query
        ], 200);
    }

    public function show(Request $id) {
        $result = Country::find($id);

        return response([
            'row'=> $result
        ], 200);
    }

    public function showAll() {
        return response([
            'rows'=> Country::get()
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        return response([
            'rows'=> Country::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        return response([
            'row'=> Country::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $query = Country::find($id);
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
        $query = Country::find($id);
        $query->delete();

        return $this->showAll();
    }
}
