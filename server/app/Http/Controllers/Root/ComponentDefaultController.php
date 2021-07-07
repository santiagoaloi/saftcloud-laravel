<?php

namespace App\Http\Controllers\Root;

use App\Http\Controllers\Controller;
use App\Models\Root\ComponentDefault;
use Illuminate\Http\Request;
use App\Helpers\Helper;

use App\Http\Controllers\Root\ComponentController;

class ComponentDefaultController extends Controller {

    public function store(Request $request) {
        $query = ComponentDefault::create(['config_structure'=>json_encode($request['config_structure'])]);
        $this->updateJsonModel($query->config_structure);

        $getComponents = new ComponentController;
        $components = $getComponents->showAll(true);

        if (isset($components)){
            foreach ($components as $component){
                $result = $this->compareComponentConfig($component);
                $component['config']['form_fields'] = $result;
                $newComponents[]=$component;
            };
            return $getComponents->updateAll($newComponents);
        }
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

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        $query = ComponentDefault::find($id);
        $query->fill($request->all())->save();

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

    function getLastJson(){
        return ComponentDefault::get('config_structure')->last();
    }

    function getLast(){
        $getJsonFile2 = app_path("Models/model.json");
        return file_get_contents($getJsonFile2);

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
