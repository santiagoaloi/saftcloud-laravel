<?php

namespace App\Http\Controllers\Root;

use App\Helpers\Helper;
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

        if(count($components->original['components'])){
            foreach ($components->original['components'] as $component){
                $result = $this->compareComponentConfig($component);
                $component['config']['form_fields'] = $result;
                $newComponents[]=$component;
            };
            return $getComponents->updateAll($newComponents);
        }
        return $components;
    }

    public function show(Request $id, $local = false) {
        $result = ComponentDefault::find($id);

        if ($local){
            return $result;
        } else {
            return response([
                'row'=> $result
            ], 200);
        }
    }

    public function showAll($local = false) {
        $query = ComponentDefault::get();
        if ($local){
            return $query;
        } else {
            return response([
                'rows'=> $query
            ], 200);
        }
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        $result = ComponentDefault::onlyTrashed()->get();

        return response([
            'rows'=> $result
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $result = ComponentDefault::onlyTrashed()->find($id)->recovery();

        return response([
            'row'=> $result
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
            'row'=> $query
        ], 200);
    }

    public function updateAll($request) {
        foreach($request as $item){
            $query = ComponentDefault::find($item['id']);
            $query->fill($item)->save();
        };

        $result = $this->showAll(true);

        return response([
            'rows'=> $result
        ], 200);
    }

    public function destroy($id) {
        $query = ComponentDefault::find($id);
        $query->delete();

        return $this->showAll(true);
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

    public function compareComponentConfig($request){
        $model = $this->getLast();

        $items = $request['config']['form_fields'];
        $it_2 = json_decode($model, true);

        $modelo = $it_2['form_fields'];

        foreach($items as $item){
            $result[] = Helper::compareItems($item, $modelo);
        };
        return $result;
    }

    public function updateJsonModel($jsonModel){
        $getJsonFile2 = app_path("Models/model.json");
        file_put_contents($getJsonFile2, $jsonModel);
    }

}
