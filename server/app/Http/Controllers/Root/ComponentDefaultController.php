<?php

namespace App\Http\Controllers\Root;

use App\Http\Controllers\Controller;
use App\Models\Root\ComponentDefault;
use App\Models\Root\Component;
use Illuminate\Http\Request;

use App\Http\Controllers\Root\ComponentController;

class ComponentDefaultController extends Controller {

    public function store(Request $request) {
        $query = ComponentDefault::create(['config_structure'=>json_encode($request['config_structure'])]);
        
        $getComponents = new ComponentController;
        $components = $getComponents->showAll(true);
        foreach ($components as $component){
            $result = $this->compareComponentConfig($component);
            $component['config']['form_fields'] = $result;
            $newComponents[]=$component;
        };

        $saveComponents = $getComponents->updateAll($newComponents, true);

        return response([
            'row'=> $query,
            'status'=> true
        ], 200);
    }

    public function show(Request $id, $local = false) {
        $result = ComponentDefault::find($id);

        if ($local){
            return $result;
        } else {
            return response([
                'row'=> $result,
                'status'=> true
            ], 200);
        }
    }

    public function showAll($local = false) {
        if ($local){
            return ComponentDefault::get();
        } else {
            return response([
                'rows'=> ComponentDefault::get(),
                'status'=> true
            ], 200);
        }
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        $result = ComponentDefault::onlyTrashed()->get();

        return response([
            'rows'=> $result,
            'status'=> true
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $result = ComponentDefault::onlyTrashed()->findOrFail($id)->recovery();

        return response([
            'row'=> $result,
            'status'=> true
        ], 200);
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        $query = ComponentDefault::findOrFail($id);

        $input = $request->all();

        $query->fill($input)->save();

        return response([
            'row'=> $query,
            'status'=> true
        ], 200);
    }

    public function updateAll(Request $request) {
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        $result = $this->showAll(true);

        return response([
            'rows'=> $result,
            'status'=> true
        ], 200);
    }

    public function destroy($id) {
        $query = ComponentDefault::findOrFail($id);
        $query->delete();

        return $this->showAll(true);
    }

    function getLastJson(){
        return ComponentDefault::get('config_structure')->last();
    }


    function getLast(){
        return ComponentDefault::pluck('config_structure')->last();
    }

    public function compareComponentConfig($request){
        $model = $this->getLast();

        $items = $request['config']['form_fields'];
        $it_2 = json_decode($model, true);

        $modelo = $it_2['form_fields'];

        foreach($items as $item){
            $result[] = $this->testCompare($item, $modelo);
        };
        return $result;
    }

    function testCompare($item, $model){
        $newItem = [];
        foreach($model as $k => $v) {
            if(!isset($item[$k])) {
                $newItem[$k] = $v;
            } else if (isset($item[$k]) && !is_array($item[$k]) && is_array($v)) {
                $newItem[$k] = $v;
            } else if (isset($item[$k]) && is_array($item[$k]) && !is_array($v)) {
                $newItem[$k] = $v;
            } else if (isset($item[$k]) && is_array($item[$k]) && is_array($v)) {
                $newVal = [];
                foreach($v as $subKey => $val) {
                    if(is_array($val)){
                        $test = $this->testCompare($item[$k][$subKey], $val);
                        $newVal[$subKey] = $test;
                    } else if (!is_array($val) && !isset($item[$k][$subKey])){
                        $newVal[$subKey] = $model[$k][$subKey];
                    } else {
                        $newVal[$subKey] = $item[$k][$subKey];
                    }
                } $newItem[$k] = $newVal;
            } else {
                $newItem[$k] = $item[$k];
            }
        }
        return $newItem;
    }

    public function compareItems($item, $model){
        $result = array("more"=>array(),"less"=>array(),"diff"=>array());
        foreach($model as $k => $v) {
            if(is_array($v) && isset($item[$k]) && is_array($item[$k])) {
                $sub_result = $this->compareItems($v, $item[$k]);
                //merge results
                foreach(array_keys($sub_result) as $key) {
                    if(!empty($sub_result[$key])) {
                        $result[$key] = array_merge_recursive($result[$key],array($k => $sub_result[$key]));
                    }
                }
            } else {
                if(isset($item[$k])) {
                    if($v !== $item[$k]) {
                        $result["diff"][$k] = array("from"=>$v,"to"=>$item[$k]);
                    }
                } else {
                    $result["more"][$k] = $v;
                }
            }
        }
        foreach($item as $k => $v) {
            if(!isset($model[$k])) {
                $result["less"][$k] = $v;
            }
        }
        return $result;
    }

}
