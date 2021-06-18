<?php

namespace App\Http\Controllers\Root;

use App\Http\Controllers\Controller;
use App\Models\Root\ComponentDefault;
use App\Models\Root\Component;
use Illuminate\Http\Request;

use Illuminate\Support\Arr;

class ComponentDefaultController extends Controller {

    public function store(Request $request) {
        //
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        //
    }

    public function destroy($id) {
        //
    }


    public function compareComponentConfig(Request $request){
        $model = ComponentDefault::pluck('config_structure')->last();
        // $model = ComponentDefault::where('id', 1)->pluck('component_defaults', 'surname')->all();

        $getConfig = Component::find($request['id'], ['config']);

        $it_1 = json_decode($getConfig->config, true);
        $it_2 = json_decode($model, true);

        $items = $it_1['form_fields'];

        $modelo = $it_2['form_fields'];

        foreach($items as $item){
            $pepe = $this->compareCompare($item, $modelo);
        };
        return $pepe;
    }

    public function compareCompare($item, $model){

        $result = array("more"=>array(),"less"=>array(),"diff"=>array());
        foreach($model as $k => $v) {
            if(is_array($v) && isset($item[$k]) && is_array($item[$k])) {
                $sub_result = $this->compareCompare($v, $item[$k]);
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
