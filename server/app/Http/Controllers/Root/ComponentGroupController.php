<?php

namespace App\Http\Controllers\Root;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Root\ComponentGroup;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class ComponentGroupController extends Controller {

    public function store(Request $request) {
        $this->authorize(ability: 'store', arguments: [ComponentGroup::class, 'ComponentGroup.store']);
        $postdata = json_decode($request->getContent(), true);
        try{
            ComponentGroup::create($postdata);
        }
        catch(QueryException $e){
            if($e->errorInfo[1]){
                return response([
                    'message'=> $e->errorInfo[2],
                    'code'=> $e->errorInfo[1]
                ], 404);
            }
        }
        return $this->showAll();
    }

    public function show($id) {
        $this->authorize(ability: 'show', arguments: [ComponentGroup::class, 'ComponentGroup.show']);
        $result = ComponentGroup::find($id);
        origin($result);

        return response([
            'group' => $result,
            'status' => true
        ], 200);
    }

    public function showAll() {
        $this->authorize(ability: 'showAll', arguments: [ComponentGroup::class, 'ComponentGroup.showAll']);
        $result = ComponentGroup::all();
        foreach ($result as $item){
            origin($item);
        }

        return response([
            'groups' => $result,
            'status' => true,
        ], 200);
    }

    public function getNavigationStructure() {
        $parents = DB::table('component_groups')
            ->select('id', 'name', 'icon', 'component_group_id')
            ->where('component_group_id', NULL)->where('deleted_at', '=', NULL)
            ->get();
        $childs = DB::table('component_groups')
            ->select('id', 'name', 'icon', 'component_group_id')
            ->where('component_group_id', '!=' , NULL)->where('deleted_at', '=', NULL)
            ->get();
        $modules = DB::select("SELECT name, JSON_EXTRACT(config, '$.general_config.title') as title, JSON_EXTRACT(config_settings, '$.icon.name') as icon, JSON_EXTRACT(config, '$.general_config.isVisibleInSidebar') as isVisibleInSidebar, component_group_id 
            FROM components 
            where deleted_at is NULL HAVING isVisibleInSidebar = true"
        );

        $array = [];

            if(!empty($modules)){
                foreach($modules as $tes => $val){
                    $icon = str_replace('"', "", $val->icon);
                    $url = '/'.$val->name;
                    $title = str_replace('"', "", $val->title);
                    $components[$tes]['title'] = $title;
                    $components[$tes]['icon'] = $icon;
                    $components[$tes]['link'] = $url;
                    $components[$tes]['component_group_id'] = $val->component_group_id;
                }
            }

            foreach($parents as $parent){
                if(!empty($modules)){
                    foreach($components as $component){
                        if($parent->id == $component['component_group_id']){
                            $parent->items[] = $component;
                        }
                    }
                }
                if(isset($childs) && !empty($modules)){
                    foreach($childs as $child){
                        if($parent->id === $child->component_group_id){
                            if(isset($components)){
                                foreach($components as $component){
                                    if($child->id === $component['component_group_id']){
                                        $child->items[] = $component;
                                    }
                                }
                            }
                            if(isset($child->items)){
                                $parent->items[] = $child;        
                            }
                        }
                    }
                }
                // $array['menu'][]['items'][] = $parent;
                if(isset($parent->items)){
                    $array['menu'][]['items'][] = $parent;
                }
    
            }

            return response([
                'navigationStructure' => $array
            ], 200);
    }

    public function showAllGroupNames(){
        $components = DB::table('component_groups')->select('name')->where('deleted_at', '=', NULL)->get();

        $array = [];
        foreach($components as $component){
            $array[] = $component->name;
        }
        return $array;
    }

    //  Para mostrar los elementos eliminados
    public function showTrashed() {
        $this->authorize(ability: 'showTrashed', arguments: [ComponentGroup::class, 'ComponentGroup.showTrashed']);
        $result = ComponentGroup::onlyTrashed()->get();

        return response([
            'records' => $result,
            'status'=> true
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $this->authorize(ability: 'recoveryTrashed', arguments: [ComponentGroup::class, 'ComponentGroup.recoveryTrashed']);
        $result = ComponentGroup::onlyTrashed()->find($id)->recovery();

        return response([
            'record' => $result,
            'status'=> true
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize(ability: 'update', arguments: [ComponentGroup::class, 'ComponentGroup.update']);
        $query = ComponentGroup::find($id);
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

        return $this->showAll();
    }

    public function updateAll(Request $request) {
        $this->authorize(ability: 'updateAll', arguments: [ComponentGroup::class, 'ComponentGroup.updateAll']);
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize(ability: 'destroy', arguments: [ComponentGroup::class, 'ComponentGroup.destroy']);
        $exist = DB::table('component_groups')->whereExists(function ($query) use ($id) {
            $query->select(DB::raw(1))
                  ->from('components')
                  ->whereRaw("components.component_group_id = $id")
                  ->whereRaw("components.component_group_id = component_groups.id");
        })->get();

        if(!count($exist) ){
            $query = ComponentGroup::find($id);
            $query->delete();
            return $this->showAll();
        } else {
            return $this->getExistComponents($id);
        }
    }

    public function forceDestroy($id){
        $this->authorize(ability: 'forceDestroy', arguments: [ComponentGroup::class, 'ComponentGroup.forceDestroy']);
        $query = ComponentGroup::withTrashed()->find($id);
        $query->forceDelete();

        return response([
            'status'=> true
        ], 200);
    }

    public function getExistComponents($id){
        $components = DB::table('components')->where('component_group_id', '=', $id)->get();

        foreach($components as $component){
            $arrayComponent[] = parseComponent($component);
        };

        return response([
            'components' => $arrayComponent
        ], 200);

        return response([
            'message' => 'Hay un componente vinculado a este grupo',
            'components' => $arrayComponent,
            'status'=> false
        ], 404);
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attachComponentGroup(ComponentGroup $var, Request $request){
        $this->authorize(ability: 'attach', arguments: [ComponentGroup::class, 'ComponentGroup.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->attach($arr);
    }

    // ELIMINA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function detachComponentGroup(ComponentGroup $var, Request $request){
        $this->authorize(ability: 'attach', arguments: [ComponentGroup::class, 'ComponentGroup.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->detach($arr);
    }

    // SINCRONIZA TODOS LOS ITEMS ENVIADOS EN REQUEST
    public function syncComponentGroup(ComponentGroup $var, Request $request){
        $this->authorize(ability: 'attach', arguments: [ComponentGroup::class, 'ComponentGroup.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->sync($arr);
    }
}
