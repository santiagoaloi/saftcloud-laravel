<?php

namespace App\Http\Controllers\Public;

use App\Models\Public\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class StateController extends Controller {

    public function store(Request $request) {
        $this->authorize(ability: 'store', arguments: [State::class, 'State.store']);
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
        $result = State::find($id);
        origin($result);

        return response([
            'record'=> $result
        ], 200);
    }

    public function showAll($country_id) {
        $result = State::where('country_id', $country_id)->get();
        foreach ($result as $item){
            origin($item);
        }

        return response([
            'records'=> $result
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function showTrashed() {
        $this->authorize(ability: 'showTrashed', arguments: [State::class, 'State.showTrashed']);
        return response([
            'records'=> State::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $this->authorize(ability: 'recoveryTrashed', arguments: [State::class, 'State.recoveryTrashed']);
        return response([
            'record'=> State::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize(ability: 'update', arguments: [State::class, 'State.update']);
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
        $this->authorize(ability: 'updateAll', arguments: [State::class, 'State.updateAll']);
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return response([
            'message'=> "Todos los estados fueron actualizadas."
        ], 200);
    }

    public function destroy($id) {
        $this->authorize(ability: 'destroy', arguments: [State::class, 'State.destroy']);
        $query = State::find($id);
        $query->delete();

        return response([
            'message'=> "Estado eliminado."
        ], 200);
    }

    public function forceDestroy($id){
        $this->authorize(ability: 'forceDestroy', arguments: [State::class, 'State.forceDestroy']);
        $query = State::withTrashed()->find($id);
        $query->forceDelete();

        return response([
            'status'=> true
        ], 200);
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attachState(State $state, Request $request){
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $state->$class()->attach($arr);
    }

    // ELIMINA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function detachState(State $state, Request $request){
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $state->$class()->detach($arr);
    }

    // SINCRONIZA TODOS LOS ITEMS ENVIADOS EN REQUEST
    public function syncState(State $state, Request $request){
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $state->$class()->sync($arr);
    }
}
