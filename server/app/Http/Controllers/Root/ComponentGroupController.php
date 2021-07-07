<?php

namespace App\Http\Controllers\Root;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Root\ComponentGroup;

use App\Http\Controllers\Controller;

class ComponentGroupController extends Controller {

    public function store(Request $request) {
        $postdata = json_decode($request->getContent(), true);
        ComponentGroup::create($postdata);

        return $this->showAll();
    }

    public function show(Request $id) {
        return response([
            'group' => ComponentGroup::find($id),
            'status' => true
        ], 200);
    }

    public function showAll() {
        $query = ComponentGroup::all();
        return response([
            'groups' => $query,
            'status' => true,
        ], 200);
    }

    public function showAllWithChild() {
        $parents = DB::table('component_groups')->select('id', 'name', 'icon', 'component_group_id')->where('component_group_id', NULL)->where('deleted_at', '=', NULL)->get();
        $childs = DB::table('component_groups')->select('id', 'name', 'icon', 'component_group_id')->where('component_group_id', '!=' , NULL)->where('deleted_at', '=', NULL)->get();
        $query = DB::select("SELECT JSON_EXTRACT(config, '$.name') as name, JSON_EXTRACT(config_settings, '$.icon.name') as icon, component_group_id FROM components");
        $array = [];

            if(!empty($query)){
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
                if(!empty($query)){
                    foreach($components as $component){
                        if($parent->id == $component['component_group_id']){
                            $parent->items[] = $component;
                        }
                    }
                }
                if(isset($childs)){
                    foreach($childs as $child){
                        if($parent->id === $child->component_group_id){
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
            return response([
                'navigationStructure' => $array
            ], 200);
    }

    public function showAllGroupNames(){
        $components = DB::table('component_groups')->select('name')->where('deleted_at', '!=', 'NULL')->get();
        $array = [];
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
        $result = ComponentGroup::onlyTrashed()->find($id)->recovery();

        return response([
            'row' => $result,
            'status'=> true
        ], 200);
    }

    public function edit($id) {
        
    }

    public function update(Request $request, $id) {
        $query = ComponentGroup::find($id);
        $query->fill($request->all())->save();

        return $this->showAll();
    }

    public function updateAll(Request $request) {
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $exist = DB::table('component_groups')->whereExists(function ($query) use ($id) {
            $query->select(DB::raw(1))
                  ->from('components')
                  ->whereRaw("components.component_group_id = $id")
                  ->whereRaw("components.component_group_id = component_groups.id");
        })->get();

        if(count($exist) < 1){
            $query = ComponentGroup::find($id);
            $query->delete();

            return $this->showAll();
        } else {
            return response([
                'message' => 'Hay un componente vinculado a este grupo',
                'status'=> false
            ], 404);
        }
    }

}
