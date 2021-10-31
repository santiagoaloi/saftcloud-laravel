<?php

namespace App\Http\Controllers\Private;

use Illuminate\Http\Request;
use App\Models\Private\Entity;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class EntityController extends Controller {

    public function store(Request $request) {
        $this->authorize(ability: 'store', arguments: [Entity::class, 'Entity.store']);
        try{
            $query = Entity::create($request->all());
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
        $this->authorize(ability: 'show', arguments: [Entity::class, 'Entity.show']);
        $result = Entity::find($id);
        origin($result);

        return response([
            'record'=> $result
        ], 200);
    }

    public function showAll() {
        $this->authorize(ability: 'showAll', arguments: [Entity::class, 'Entity.showAll']);
        $result = Entity::get();
        foreach ($result as $item){
            origin($item);
        }

        return response([
            'records'=> $result
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function showTrashed() {
        $this->authorize(ability: 'showTrashed', arguments: [Entity::class, 'Entity.showTrashed']);
        return response([
            'records'=> Entity::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $this->authorize(ability: 'recoveryTrashed', arguments: [Entity::class, 'Entity.recoveryTrashed']);
        return response([
            'record'=> Entity::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize(ability: 'update', arguments: [Entity::class, 'Entity.update']);
        $query = Entity::find($id);
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
        $this->authorize(ability: 'updateAll', arguments: [Entity::class, 'Entity.updateAll']);
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize(ability: 'destroy', arguments: [Entity::class, 'Entity.destroy']);
        $query = Entity::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize(ability: 'forceDestroy', arguments: [Entity::class, 'Entity.forceDestroy']);
        $query = Entity::withTrashed()->find($id);
        $query->forceDelete();
        return response([
            'status'=> true
        ], 200);
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attachEntity(Entity $phone, Request $request){
        $this->authorize(ability: 'attach', arguments: [Entity::class, 'Entity.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $phone->$class()->attach($arr);
    }

    // ELIMINA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function detachEntity(Entity $phone, Request $request){
        $this->authorize(ability: 'attach', arguments: [Entity::class, 'Entity.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $phone->$class()->detach($arr);
    }

    // SINCRONIZA TODOS LOS ITEMS ENVIADOS EN REQUEST
    public function syncEntity(Entity $phone, Request $request){
        $this->authorize(ability: 'attach', arguments: [Entity::class, 'Entity.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $phone->$class()->sync($arr);
    }
}
