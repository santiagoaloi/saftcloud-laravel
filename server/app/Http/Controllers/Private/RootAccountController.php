<?php

namespace App\Http\Controllers\Private;

use Illuminate\Http\Request;
use App\Models\Private\RootAccount;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class RootAccountController extends Controller {

    public function store(Request $request) {
        $this->authorize(ability: 'store', arguments: [RootAccount::class, 'RootAccount.store']);
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
            'record'=> $query
        ], 200);
    }

    public function show($id) {
        $this->authorize(ability: 'show', arguments: [RootAccount::class, 'RootAccount.show']);
        $result = RootAccount::find($id);
        origin($result);

        return response([
            'record'=> $result
        ], 200);
    }

    public function showAll() {
        $this->authorize(ability: 'showAll', arguments: [RootAccount::class, 'RootAccount.showAll']);
        $result = RootAccount::get();
        foreach ($result as $item){
            origin($item);
        }

        return response([
            'records'=> $result
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function showTrashed() {
        $this->authorize(ability: 'showTrashed', arguments: [RootAccount::class, 'RootAccount.showTrashed']);
        return response([
            'records'=> RootAccount::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $this->authorize(ability: 'recoveryTrashed', arguments: [RootAccount::class, 'RootAccount.recoveryTrashed']);
        return response([
            'record'=> RootAccount::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize(ability: 'update', arguments: [RootAccount::class, 'RootAccount.update']);
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
            'record'=> $query
        ], 200);
    }

    public function updateAll(Request $request) {
        $this->authorize(ability: 'updateAll', arguments: [RootAccount::class, 'RootAccount.updateAll']);
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize(ability: 'destroy', arguments: [RootAccount::class, 'RootAccount.destroy']);
        $query = RootAccount::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize(ability: 'forceDestroy', arguments: [RootAccount::class, 'RootAccount.forceDestroy']);
        $query = RootAccount::withTrashed()->find($id);
        $query->forceDelete();
        return response([
            'status'=> true
        ], 200);
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attachRootAccount(RootAccount $rootAccount, Request $request){
        $this->authorize(ability: 'attach', arguments: [RootAccount::class, 'RootAccount.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $rootAccount->$class()->attach($arr);
    }

    // ELIMINA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function detachRootAccount(RootAccount $rootAccount, Request $request){
        $this->authorize(ability: 'attach', arguments: [RootAccount::class, 'RootAccount.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $rootAccount->$class()->detach($arr);
    }

    // SINCRONIZA TODOS LOS ITEMS ENVIADOS EN REQUEST
    public function syncRootAccount(RootAccount $rootAccount, Request $request){
        $this->authorize(ability: 'attach', arguments: [RootAccount::class, 'RootAccount.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $rootAccount->$class()->sync($arr);
    }
}
