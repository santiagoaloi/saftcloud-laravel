<?php

namespace App\Http\Controllers\Root;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Root\ComponentGroup;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ComponentGroupController extends Controller {

    public function store(Request $request) {
        $postdata = json_decode($request->getContent(), true);
        ComponentGroup::create($postdata);

        $getGroups = $this->showAll(true);

        return response([
            'groups' =>  $getGroups,
            'status' => true
        ], 200);
    }

    public function show(Request $id, $local = false) {
        $result = ComponentGroup::findOrFail($id);

        if ($local){
            return $result;
        } else {
            return response([
                'group' => $result,
                'status' => true
            ], 200);
        }
    }

    public function showAll($local = false) {
        if ($local){
            return ComponentGroup::get();
        } else {
            return response([
                'groups' =>  ComponentGroup::all(),
                'status' => true,
            ], 200);
        }
    }

    public function showAllWithChild() {
        $parents = DB::table('component_groups')->select('id', 'name', 'icon', 'component_group_id')->where('component_group_id', NULL)->get();
        $childs = DB::table('component_groups')->select('id', 'name', 'icon', 'component_group_id')->where('component_group_id', '!=' , NULL)->get();

        $query = DB::select("SELECT JSON_EXTRACT(config, '$.name') as name, JSON_EXTRACT(config_settings, '$.icon.name') as icon, component_group_id FROM components");

        if(isset($parents)){
            if(isset($query)){
                foreach($query as $tes => $val){
                    $name = str_replace('"', "", $val->name);
                    $icon = str_replace('"', "", $val->icon);
                    $url = '/'.$name;
                    $components[$tes]['name'] = $name;
                    $components[$tes]['icon'] = $icon;
                    $components[$tes]['link'] = $url;
                    $components[$tes]['component_group_id'] = $val->component_group_id;
                }
            }

            foreach($parents as $parent){
                if(isset($components)){
                    foreach($components as $component){
                        if($parent->id == $component['component_group_id']){
                            $parent->items[] = $component;
                        }
                    }
                }
                if(isset($childs)){
                    foreach($childs as $child){
                        if($parent->id == $child->component_group_id){
                            $parent->items[] = $child;
                            if(isset($components)){
                                foreach($components as $component){
                                    if($child->id === $component['component_group_id']){
                                        $child->items[] = $component;
                                    }
                                }
                            }
                        }
                    }
                }
                $array['menu'][]['items'][] = $parent;
            }

            return $array;
        } else {
            return "No groups created";
        }

    }

    public function showAllGroupNames(){
        $components = DB::table('component_groups')->select('name')->get();
        foreach($components as $component){
            $array[] = $component->name;
        }
        return $array;
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        $result = ComponentGroup::onlyTrashed()->get();

        return response([
            'rows' => $result,
            'status'=> true
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $result = ComponentGroup::onlyTrashed()->findOrFail($id)->recovery();

        return response([
            'row' => $result,
            'status'=> true
        ], 200);
    }

    public function edit($id) {
        
    }

    public function update(Request $request, $id) {
        $query = ComponentGroup::findOrFail($id);

        $input = $request->all();

        $query->fill($input)->save();

        $result = $this->showAll(true);

        return response([
            'groups'    => $result,
            'status'    => true
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
        $query = ComponentGroup::find($id);
        $query->delete();

        return $this->showAll(true);
    }

}
