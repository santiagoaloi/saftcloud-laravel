<?php

namespace App\Http\Controllers\Private;

use Illuminate\Http\Request;
use App\Models\Private\AccountPlan;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class AccountPlanController extends Controller {
    
    public function store(Request $request) {
        $this->authorize('store', AccountPlan::class);
        try{
            $query = AccountPlan::create($request->all());
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
            'record' => $query
        ], 200);
    }

    public function show(Request $id) {
        $this->authorize('show', AccountPlan::class);
        $result = AccountPlan::find($id);

        return response([
            'record' => $result
        ], 200);
    }

    public function showAll() {
        $this->authorize('showAll', AccountPlan::class);
        return response([
            'records' => AccountPlan::get()
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        $this->showTrashed('restore', AccountPlan::class);
        return response([
            'records' => AccountPlan::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function restore($id) {
        $this->authorize('restore', AccountPlan::class);
        return response([
            'record' => AccountPlan::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize('update', AccountPlan::class);
        $query = AccountPlan::find($id);
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
        $this->authorize('updateAll', AccountPlan::class);
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize('destroy', AccountPlan::class);
        $query = AccountPlan::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize('forceDestroy', Capability::class);
        $query = AccountPlan::withTrashed()->find($id);
        $query->forceDelete();
        return response([
            'status'=> true
        ], 200);
    }
}
