<?php

namespace App\Http\Controllers\Root;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Root\ModuleDefault;

use Illuminate\Database\QueryException;
use App\Http\Controllers\Root\ModuleController;

class ModuleDefaultController extends Controller {

    public function store(Request $request) {
        $this->authorize(ability: 'store', arguments: [ModuleDefault::class, 'ModuleDefault.store']);
        try{
            $query = ModuleDefault::create(['config_structure'=>json_encode($request['config_structure'])]);
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

        $getModules = new ModuleController;
        $modules = $getModules->showAll();
        $result = '';
        if(count($modules->original['modules'])){
            foreach ($modules->original['modules'] as $module){
                $result = $this->compareModuleConfig($module);
                $module['config'] = $result;
                $newModules[]=$module;
            };
            return $getModules->updateAll($newModules);
        }
        return $modules;
    }

    public function show($id) {
        $this->authorize(ability: 'show', arguments: [ModuleDefault::class, 'ModuleDefault.show']);
        $result = ModuleDefault::find($id);
        origin($result);

        return response([
            'record'=> $result
        ], 200);
    }

    public function showAll() {
        $this->authorize(ability: 'showAll', arguments: [ModuleDefault::class, 'ModuleDefault.showAll']);
        $result = ModuleDefault::get();
        foreach ($result as $item){
            origin($item);
        }

        return response([
            'records'=> $result
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function showTrashed() {
        $this->authorize(ability: 'showTrashed', arguments: [ModuleDefault::class, 'ModuleDefault.showTrashed']);
        $result = ModuleDefault::onlyTrashed()->get();

        return response([
            'records'=> $result
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $this->authorize(ability: 'recoveryTrashed', arguments: [ModuleDefault::class, 'ModuleDefault.recoveryTrashed']);
        $result = ModuleDefault::onlyTrashed()->find($id)->recovery();

        return response([
            'record'=> $result
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize(ability: 'update', arguments: [ModuleDefault::class, 'ModuleDefault.update']);
        $query = ModuleDefault::find($id);
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
        $this->authorize(ability: 'updateAll', arguments: [ModuleDefault::class, 'ModuleDefault.updateAll']);
        foreach($request as $item){
            $query = ModuleDefault::find($item['id']);
            $query->fill($item)->save();
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize(ability: 'destroy', arguments: [ModuleDefault::class, 'ModuleDefault.destroy']);
        $query = ModuleDefault::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize(ability: 'forceDestroy', arguments: [ModuleDefault::class, 'ModuleDefault.forceDestroy']);
        $query = ModuleDefault::withTrashed()->find($id);
        $query->forceDelete();

        return response([
            'status'=> true
        ], 200);
    }

    // Obtiene el ultimo registro de config_structure
    function getLastJson(){
        return ModuleDefault::get('config_structure')->last();
    }

    // Obtiene el modelo de config_Structure
    function getLast(){
        $getJsonFile = app_path("Models/model.json");
        return file_get_contents($getJsonFile);
        // return ModuleDefault::pluck('config_structure')->last();
    }

    public function compareModuleTeta($request){
        $model = $this->getLast();

        $items = $request['config']['form_fields'];
        $it_2 = json_decode($model, true);

        $modelo = $it_2['form_fields'];

        foreach($items as $item){
            $result[] = compareItems($item, $modelo);
        };
        return $result;
    }

    public function compareModuleConfig($request){
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
    public function attachModuleDefault(ModuleDefault $var, Request $request){
        $this->authorize(ability: 'attach', arguments: [ModuleDefault::class, 'ModuleDefault.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->attach($arr);
    }

    // ELIMINA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function detachModuleDefault(ModuleDefault $var, Request $request){
        $this->authorize(ability: 'attach', arguments: [ModuleDefault::class, 'ModuleDefault.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->detach($arr);
    }

    // SINCRONIZA TODOS LOS ITEMS ENVIADOS EN REQUEST
    public function syncModuleDefault(ModuleDefault $var, Request $request){
        $this->authorize(ability: 'attach', arguments: [ModuleDefault::class, 'ModuleDefault.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->sync($arr);
    }
}
