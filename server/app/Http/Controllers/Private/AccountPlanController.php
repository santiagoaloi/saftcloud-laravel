<?php

namespace App\Http\Controllers\Private;

use Illuminate\Http\Request;
use App\Models\Private\AccountPlan;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class AccountPlanController extends Controller {
    
    public function store(Request $request) {
        $this->authorize(ability: 'store', arguments: [AccountPlan::class, 'AccountPlan.store']);
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

    public function show($id) {
        $this->authorize(ability: 'show', arguments: [AccountPlan::class, 'AccountPlan.show']);
        $result = AccountPlan::find($id);
        origin($result);

        return response([
            'record' => $result
        ], 200);
    }

    public function showAll() {
        $this->authorize(ability: 'showAll', arguments: [AccountPlan::class, 'AccountPlan.showAll']);
        $result = AccountPlan::get();
        foreach ($result as $item){
            origin($item);
        }

        return response([
            'records' => $result
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function showTrashed() {
        $this->authorize(ability: 'showTrashed', arguments: [AccountPlan::class, 'AccountPlan.showTrashed']);
        return response([
            'records' => AccountPlan::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $this->authorize(ability: 'recoveryTrashed', arguments: [AccountPlan::class, 'AccountPlan.recoveryTrashed']);
        return response([
            'record' => AccountPlan::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize(ability: 'update', arguments: [AccountPlan::class, 'AccountPlan.update']);
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
        $this->authorize(ability: 'updateAll', arguments: [AccountPlan::class, 'AccountPlan.updateAll']);
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize(ability: 'destroy', arguments: [AccountPlan::class, 'AccountPlan.destroy']);
        $query = AccountPlan::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize(ability: 'forceDestroy', arguments: [AccountPlan::class, 'AccountPlan.forceDestroy']);
        $query = AccountPlan::withTrashed()->find($id);
        $query->forceDelete();
        return response([
            'status'=> true
        ], 200);
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attachAccountPlan(AccountPlan $accountPlan, Request $request){
        $items = $request['items'];
        $class = $request['name'];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $accountPlan->$class()->attach($arr);
    }

    // ELIMINA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function detachAccountPlan(AccountPlan $accountPlan, Request $request){
        $items = $request['items'];
        $class = $request['name'];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $accountPlan->$class()->detach($arr);
    }

    // SINCRONIZA TODOS LOS ITEMS ENVIADOS EN REQUEST
    public function syncAccountPlan(AccountPlan $accountPlan, Request $request){
        $items = $request['items'];
        $class = $request['name'];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $accountPlan->$class()->sync($arr);
    }
}
