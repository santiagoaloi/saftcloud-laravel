<?php

namespace App\Http\Controllers\Private;

use Illuminate\Http\Request;
use App\Models\Private\RootAccount;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class RootAccountController extends Controller {

    public function store(Request $request) {
        $this->authorize('store', RootAccount::class);
        try{
            $query = RootAccount::create($request->all());
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
        $this->authorize('show', RootAccount::class);
        $result = RootAccount::find($id);

        return response([
            'row'=> $result
        ], 200);
    }

    public function showAll() {
        $this->authorize('showAll', RootAccount::class);
        return response([
            'rows'=> RootAccount::get()
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        $this->authorize('getTrashed', RootAccount::class);
        return response([
            'rows'=> RootAccount::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function restore($id) {
        $this->authorize('restore', RootAccount::class);
        return response([
            'row'=> RootAccount::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize('update', RootAccount::class);
        $query = RootAccount::find($id);
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
        $this->authorize('updateAll', RootAccount::class);
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize('destroy', RootAccount::class);
        $query = RootAccount::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize('forceDestroy', RootAccount::class);
        $query = RootAccount::withTrashed()->find($id);
        $query->forceDelete();
        return response([
            'status'=> true
        ], 200);
    }
}
