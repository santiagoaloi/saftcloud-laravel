<?php

namespace App\Http\Controllers\Private;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Private\userSetting;
use Illuminate\Database\QueryException;

class UserSettingController extends Controller {

    public function store(Request $request) {
        $this->authorize(ability: 'store', arguments: [userSetting::class, 'userSetting.store']);
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

    public function show($id) {
        $this->authorize('show', userSetting::class);
        $result = userSetting::find($id);
        origin($result);

        return response([
            'record'=> $result
        ], 200);
    }

    public function showAll() {
        $this->authorize(ability: 'showAll', arguments: [userSetting::class, 'userSetting.showAll']);
        $result = userSetting::get();
        foreach ($result as $item){
            origin($item);
        }

        return response([
            'records'=> $result
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function showTrashed() {
        $this->authorize(ability: 'showTrashed', arguments: [userSetting::class, 'userSetting.showTrashed']);
        return response([
            'records'=> userSetting::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $this->authorize(ability: 'recoveryTrashed', arguments: [userSetting::class, 'userSetting.recoveryTrashed']);
        return response([
            'record'=> userSetting::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize(ability: 'update', arguments: [userSetting::class, 'userSetting.update']);
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
        $this->authorize(ability: 'updateAll', arguments: [userSetting::class, 'userSetting.updateAll']);
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize(ability: 'destroy', arguments: [userSetting::class, 'userSetting.destroy']);
        $query = userSetting::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize(ability: 'forceDestroy', arguments: [userSetting::class, 'userSetting.forceDestroy']);
        $query = userSetting::withTrashed()->find($id);
        $query->forceDelete();
        return response([
            'status'=> true
        ], 200);
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attach(UserSetting $userSetting, Request $request){
        $this->authorize(ability: 'attach', arguments: [userSetting::class, 'userSetting.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $userSetting->$class()->attach($arr);
    }

    // ELIMINA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function detach(UserSetting $userSetting, Request $request){
        $this->authorize(ability: 'attach', arguments: [userSetting::class, 'userSetting.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $userSetting->$class()->detach($arr);
    }

    // SINCRONIZA TODOS LOS ITEMS ENVIADOS EN REQUEST
    public function sync(UserSetting $userSetting, Request $request){
        $this->authorize(ability: 'attach', arguments: [userSetting::class, 'userSetting.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $userSetting->$class()->sync($arr);
    }
}
