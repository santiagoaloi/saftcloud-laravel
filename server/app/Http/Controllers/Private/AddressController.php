<?php

namespace App\Http\Controllers\Private;

use Illuminate\Http\Request;
use App\Models\Private\Address;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class AddressController extends Controller {

    public function store(Request $request) {
        $this->authorize(ability: 'store', arguments: [Address::class, 'Address.store']);
        try{
            $query = Address::create($request->all());
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
        $this->authorize(ability: 'show', arguments: [Address::class, 'Address.show']);
        $result = Address::find($id);
        origin($result);

        return response([
            'record' => $result
        ], 200);
    }

    public function showAll() {
        $this->authorize(ability: 'showAll', arguments: [Address::class, 'Address.showAll']);
        $result = Address::get();
        foreach ($result as $item){
            origin($item);
        }

        return response([
            'records' => $result
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function showTrashed() {
        $this->authorize(ability: 'showTrashed', arguments: [Address::class, 'Address.showTrashed']);
        return response([
            'records' => Address::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $this->authorize(ability: 'recoveryTrashed', arguments: [Address::class, 'Address.recoveryTrashed']);
        return response([
            'record' => Address::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize(ability: 'update', arguments: [Address::class, 'Address.update']);
        $query = Address::find($id);
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
        $this->authorize(ability: 'updateAll', arguments: [Address::class, 'Address.updateAll']);
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize(ability: 'destroy', arguments: [Address::class, 'Address.destroy']);
        $query = Address::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize(ability: 'forceDestroy', arguments: [Address::class, 'Address.forceDestroy']);
        $query = Address::withTrashed()->find($id);
        $query->forceDelete();
        return response([
            'status'=> true
        ], 200);
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attachAddress(Address $address, Request $request){
        $items = $request['items'];
        $class = $request['name'];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $address->$class()->attach($arr);
    }

    // ELIMINA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function detachAddress(Address $address, Request $request){
        $items = $request['items'];
        $class = $request['name'];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $address->$class()->detach($arr);
    }

    // SINCRONIZA TODOS LOS ITEMS ENVIADOS EN REQUEST
    public function syncAddress(Address $address, Request $request){
        $items = $request['items'];
        $class = $request['name'];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $address->$class()->sync($arr);
    }
}
