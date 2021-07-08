<?php

namespace App\Http\Controllers\Private;

use Illuminate\Http\Request;
use App\Models\Private\AccountPlan;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class AccountPlanController extends Controller {
    
    public function store(Request $request) {
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
            'row' => $query
        ], 200);
    }

    public function show(Request $id) {
        $result = AccountPlan::find($id);

        return response([
            'row' => $result
        ], 200);
    }

    public function showAll() {
        return response([
            'rows' => AccountPlan::get()
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        return response([
            'rows' => AccountPlan::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        return response([
            'row' => AccountPlan::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
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
        $query = AccountPlan::find($id);
        $query->delete();

        return $this->showAll();
    }
}
