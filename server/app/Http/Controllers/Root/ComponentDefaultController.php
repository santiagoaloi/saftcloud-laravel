<?php

namespace App\Http\Controllers\Root;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Root\ComponentDefault;

use Illuminate\Database\QueryException;
use App\Http\Controllers\Root\ComponentController;

class ComponentDefaultController extends Controller {

    public function store(Request $request) {
        try{
            $query = ComponentDefault::create(['config_structure'=>json_encode($request['config_structure'])]);
        }
        catch(QueryException $e){
            if($e->errorInfo[1]){
                return response([
                    'message'=> $e->errorInfo[2],
                    'code'=> $e->errorInfo[1]
                ], 404);
            }
        }

        $this->updateJsonModel($query->config_structure);

        $getComponents = new ComponentController;
        $components = $getComponents->showAll();
        $result = '';
        if(count($components->original['components'])){
            foreach ($components->original['components'] as $component){
                $result = $this->compareComponentConfig($component);
                $component['config'] = $result;
                $newComponents[]=$component;
            };
            return $getComponents->updateAll($newComponents);
        }
        return $components;
    }

    public function show(Request $id) {
        $result = ComponentDefault::find($id);
        origin($result);

        return response([
            'record'=> $result
        ], 200);
    }

    public function showAll() {
        $result = ComponentDefault::get();
        foreach ($result as $item){
            origin($item);
        }

        return response([
            'records'=> $result
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        $result = ComponentDefault::onlyTrashed()->get();

        return response([
            'records'=> $result
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $result = ComponentDefault::onlyTrashed()->find($id)->recovery();

        return response([
            'record'=> $result
        ], 200);
    }

    public function update(Request $request, $id) {
        $query = ComponentDefault::find($id);
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

    public function updateAll($request) {
        foreach($request as $item){
            $query = ComponentDefault::find($item['id']);
            $query->fill($item)->save();
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $query = ComponentDefault::find($id);
        $query->delete();

        return $this->showAll();
    }

    // Obtiene el ultimo registro de config_structure
    function getLastJson(){
        return ComponentDefault::get('config_structure')->last();
    }

    // Obtiene el modelo de config_Structure
    function getLast(){
        $getJsonFile = app_path("Models/model.json");
        return file_get_contents($getJsonFile);

        // return ComponentDefault::pluck('config_structure')->last();
    }

    
    public function compareComponentTeta($request){
        $model = $this->getLast();

        $items = $request['config']['form_fields'];
        $it_2 = json_decode($model, true);

        $modelo = $it_2['form_fields'];

        foreach($items as $item){
            $result[] = compareItems($item, $modelo);
        };
        return $result;
    }

    public function compareComponentConfig($request){
        $model = $this->getLast();

        $itemsformFields    = $request['config']['form_fields'];
        $itemsColumns       = $request['config']['columns'];
        $itemsGeneralConfig = $request['config']['general_config'];

        $mod = json_decode($model, true);
        $modelFormFields    = $mod['form_fields'];
        $modelColumns       = $mod['columns'];
        $modelGeneralConfig = $mod['general_config'];

        foreach($itemsformFields as $item){
            $result['form_fields'][] = compareItems($item, $modelFormFields);
        };

        foreach($itemsColumns as $item){
            $result['columns'][] = compareItems($item, $modelColumns);
        }

        $result['general_config'] = compareItems($itemsGeneralConfig, $modelGeneralConfig);
        
        return $result;
    }

    public function updateJsonModel($jsonModel){
        $getJsonFile2 = app_path("Models/model.json");
        file_put_contents($getJsonFile2, $jsonModel);
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attachComponentDefault(ComponentDefault $componentDefault, Request $request){
        $items = $request['items'];
        $class = $request['name'];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $componentDefault->$class()->attach($arr);
    }

    // ELIMINA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function detachComponentDefault(ComponentDefault $componentDefault, Request $request){
        $items = $request['items'];
        $class = $request['name'];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $componentDefault->$class()->detach($arr);
    }

    // SINCRONIZA TODOS LOS ITEMS ENVIADOS EN REQUEST
    public function syncComponentDefault(ComponentDefault $componentDefault, Request $request){
        $items = $request['items'];
        $class = $request['name'];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $componentDefault->$class()->sync($arr);
    }
}
