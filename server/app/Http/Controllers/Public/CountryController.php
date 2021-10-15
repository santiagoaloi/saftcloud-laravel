<?php

namespace App\Http\Controllers\Public;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Public\Country;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Private\UserController;
use App\Models\Roles\Capability;

class CountryController extends Controller {

    public function store(Request $request) {
        $this->authorize('store', Country::class);
        try{
            $query = Country::create($request->all());
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
        // $this->authorize('show', Country::class);
        $result = Country::find($id);
        origin($result);

        return response([
            'record'=> $result
        ], 200);
    }

    public function showAll() {
        // $this->authorize('showAll', Country::class);
        $result = Country::get();
        foreach ($result as $item){
            origin($item);
        }

        return response([
            'records'=> $result
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function showTrashed() {
        $this->showTrashed('restore', Country::class);
        return response([
            'records'=> Country::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function restore($id) {
        $this->authorize('restore', Country::class);
        return response([
            'record'=> Country::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize('update', Country::class);
        $query = Country::find($id);
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
        $this->authorize('updateAll', Country::class);
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize('destroy', Country::class);
        $query = Country::find($id);
        $query->delete();

        return $this->showAll();
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attachCountry(Country $country, Request $request){
        $items = $request['items'];
        $class = $request['name'];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $country->$class()->attach($arr);
    }

    // ELIMINA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function detachCountry(Country $country, Request $request){
        $items = $request['items'];
        $class = $request['name'];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $country->$class()->detach($arr);
    }

    // SINCRONIZA TODOS LOS ITEMS ENVIADOS EN REQUEST
    public function syncCountry(Country $country, Request $request){
        $items = $request['items'];
        $class = $request['name'];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $country->$class()->sync($arr);
    }
}
