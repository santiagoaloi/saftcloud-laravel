<?php

namespace App\Http\Controllers\Root;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Root\ComponentDefault;

use Illuminate\Database\QueryException;
use App\Http\Controllers\Root\ComponentController;

class ComponentDefaultController extends Controller {

    public function store(Request $request) {
        $this->authorize(ability: 'store', arguments: [ComponentDefault::class, 'ComponentDefault.store']);
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

    public function show($id) {
        $this->authorize(ability: 'show', arguments: [ComponentDefault::class, 'ComponentDefault.show']);
        $result = ComponentDefault::find($id);
        origin($result);

        return response([
            'record'=> $result
        ], 200);
    }

    public function showAll() {
        $this->authorize(ability: 'showAll', arguments: [ComponentDefault::class, 'ComponentDefault.showAll']);
        $result = ComponentDefault::get();
        foreach ($result as $item){
            origin($item);
        }

        return response([
            'records'=> $result
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function showTrashed() {
        $this->authorize(ability: 'showTrashed', arguments: [ComponentDefault::class, 'ComponentDefault.showTrashed']);
        $result = ComponentDefault::onlyTrashed()->get();

        return response([
            'records'=> $result
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $this->authorize(ability: 'recoveryTrashed', arguments: [ComponentDefault::class, 'ComponentDefault.recoveryTrashed']);
        $result = ComponentDefault::onlyTrashed()->find($id)->recovery();

        return response([
            'record'=> $result
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize(ability: 'update', arguments: [ComponentDefault::class, 'ComponentDefault.update']);
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
        $this->authorize(ability: 'updateAll', arguments: [ComponentDefault::class, 'ComponentDefault.updateAll']);
        foreach($request as $item){
            $query = ComponentDefault::find($item['id']);
            $query->fill($item)->save();
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize(ability: 'destroy', arguments: [ComponentDefault::class, 'ComponentDefault.destroy']);
        $query = ComponentDefault::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize(ability: 'forceDestroy', arguments: [ComponentDefault::class, 'ComponentDefault.forceDestroy']);
        $query = ComponentDefault::withTrashed()->find($id);
        $query->forceDelete();

        return response([
            'status'=> true
        ], 200);
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
    public function attachComponentDefault(ComponentDefault $var, Request $request){
        $this->authorize(ability: 'attach', arguments: [ComponentDefault::class, 'ComponentDefault.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->attach($arr);
    }

    // ELIMINA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function detachComponentDefault(ComponentDefault $var, Request $request){
        $this->authorize(ability: 'attach', arguments: [ComponentDefault::class, 'ComponentDefault.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->detach($arr);
    }

    // SINCRONIZA TODOS LOS ITEMS ENVIADOS EN REQUEST
    public function syncComponentDefault(ComponentDefault $var, Request $request){
        $this->authorize(ability: 'attach', arguments: [ComponentDefault::class, 'ComponentDefault.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->sync($arr);
    }
}
