<?php

namespace App\Http\Controllers\Private;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Private\userSetting;
use Illuminate\Database\QueryException;

class UserSettingController extends Controller {

    public function store(Request $request) {
        $this->authorize('store', userSetting::class);
        try{
            $query = userSetting::create($request->all());
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
        $this->authorize('show', userSetting::class);
        $result = userSetting::find($id);
        return response([
            'record'=> $result
        ], 200);
    }

    public function showAll() {
        $this->authorize('showAll', userSetting::class);
        return response([
            'records'=> userSetting::get()
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        $this->authorize('getTrashed', userSetting::class);
        return response([
            'records'=> userSetting::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function restore($id) {
        $this->authorize('restore', userSetting::class);
        return response([
            'record'=> userSetting::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize('update', userSetting::class);
        $query = userSetting::find($id);
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
        $this->authorize('updateAll', userSetting::class);
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize('destroy', userSetting::class);
        $query = userSetting::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize('forceDestroy', userSetting::class);
        $query = userSetting::withTrashed()->find($id);
        $query->forceDelete();
        return response([
            'status'=> true
        ], 200);
    }
}
