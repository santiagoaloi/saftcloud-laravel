<?php

namespace App\Http\Controllers\GeneralConfig;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Models\GeneralConfig\LookUpListValue;

class LookUpListValueController extends Controller {

    public function store(Request $request) {
        try{
            $query = LookUpListValue::create($request->all());
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

    public function show(Request $id, $local = false) {
        $result = LookUpListValue::find($id);

        if ($local){
            return $result;
        } else {
            return response([
                'record'=> $result
            ], 200);
        }
    }

    public function showAll($local = false, $parentId = ['']) {
        if ($local){
            return LookUpListValue::whereIn('look_up_list_id', $parentId)->get();
        } else {
            return response([
                'records'=> LookUpListValue::get()
            ], 200);
        }
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        $result = LookUpListValue::onlyTrashed()->get();

        return response([
            'records'=> $result
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $result = LookUpListValue::onlyTrashed()->find($id)->recovery();

        return response([
            'record'=> $result
        ], 200);
    }

    public function update(Request $request, $id) {
        $query = LookUpListValue::find($id);
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

        $result = $this->showAll(true);

        return response([
            'records'=> $result
        ], 200);
    }

    public function destroy($id) {
        $query = LookUpListValue::find($id);
        $query->delete();

        return $this->showAll(true);
    }
}
