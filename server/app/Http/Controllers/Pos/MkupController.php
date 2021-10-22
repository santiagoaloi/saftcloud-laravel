<?php

namespace App\Http\Controllers\Pos;

use App\Models\Pos\Mkup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class MkupController extends Controller {

    public function store(Request $request) {
        $this->authorize(ability: 'store', arguments: [Mkup::class, 'Mkup.store']);
        try{
            $query = Mkup::create($request->all());
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
        $this->authorize(ability: 'show', arguments: [Mkup::class, 'Mkup.show']);
        $result = Mkup::find($id);
        origin($result);

        return response([
            'record'=> $result
        ], 200);
    }

    public function showAll() {
        $this->authorize(ability: 'showAll', arguments: [Mkup::class, 'Mkup.showAll']);
        $result = Mkup::get();
        foreach ($result as $item){
            origin($item);
        }

        return response([
            'records'=> $result
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function showTrashed() {
        $this->authorize(ability: 'showTrashed', arguments: [Mkup::class, 'Mkup.showTrashed']);
        return response([
            'records'=> Mkup::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $this->authorize(ability: 'recoveryTrashed', arguments: [Mkup::class, 'Mkup.recoveryTrashed']);
        return response([
            'record'=> Mkup::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize(ability: 'update', arguments: [Mkup::class, 'Mkup.update']);
        $query = Mkup::find($id);
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
        $this->authorize(ability: 'updateAll', arguments: [Mkup::class, 'Mkup.updateAll']);
        foreach($request as $item){
            $this->update($item, $item->id);
        };
        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize(ability: 'destroy', arguments: [Mkup::class, 'Mkup.destroy']);
        $query = Mkup::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize(ability: 'forceDestroy', arguments: [Mkup::class, 'Mkup.forceDestroy']);
        $query = Mkup::withTrashed()->find($id);
        $query->forceDelete();
        return response([
            'status'=> true
        ], 200);
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attachAccountPayment(Mkup $var, Request $request){
        $items = $request['items'];
        $class = $request['name'];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->attach($arr);
    }

    // ELIMINA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function detachAccountPayment(Mkup $var, Request $request){
        $items = $request['items'];
        $class = $request['name'];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->detach($arr);
    }

    // SINCRONIZA TODOS LOS ITEMS ENVIADOS EN REQUEST
    public function syncAccountPayment(Mkup $var, Request $request){
        $items = $request['items'];
        $class = $request['name'];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->sync($arr);
    }
}
