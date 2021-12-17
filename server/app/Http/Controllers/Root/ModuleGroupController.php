<?php

namespace App\Http\Controllers\Root;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Root\ModuleGroup;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class ModuleGroupController extends Controller {

    public function store(Request $request) {
        $this->authorize(ability: 'store', arguments: [ModuleGroup::class, 'ModuleGroup.store']);
        $postdata = json_decode($request->getContent(), true);
        try{
            ModuleGroup::create($postdata);
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
        $this->authorize(ability: 'show', arguments: [ModuleGroup::class, 'ModuleGroup.show']);
        $result = ModuleGroup::find($id);
        origin($result);

        return response([
            'group' => $result,
            'status' => true
        ], 200);
    }

    public function showAll() {
        $this->authorize(ability: 'showAll', arguments: [ModuleGroup::class, 'ModuleGroup.showAll']);
        $result = ModuleGroup::all();
        foreach ($result as $item){
            origin($item);
        }

        return response([
            'groups' => $result,
            'status' => true,
        ], 200);
    }

    public function getNavigationStructure() {
        $user = Auth::user();
        $roles = $user->role;
        $modules = modulesBuilder($roles);

        $parents = DB::table('module_groups')->select('id', 'name', 'icon', 'module_group_id')
        ->where('module_group_id', NULL)->where('deleted_at', '=', NULL)->get();

        $childs = DB::table('module_groups')->select('id', 'name', 'icon', 'module_group_id')
        ->where('module_group_id', '!=' , NULL)->where('deleted_at', '=', NULL)->get();

        $array = parentbuilder($parents, $childs, $modules);

        return response([
            'navigationStructure' => $array
        ], 200);
    }

    public function showAllGroupNames(){
        $modules = DB::table('module_groups')->select('name')->where('deleted_at', '=', NULL)->get();

        $array = [];
        foreach($modules as $module){
            $array[] = $module->name;
        }
        return $array;
    }

    //  Para mostrar los elementos eliminados
    public function showTrashed() {
        $this->authorize(ability: 'showTrashed', arguments: [ModuleGroup::class, 'ModuleGroup.showTrashed']);
        $result = ModuleGroup::onlyTrashed()->get();

        return response([
            'records' => $result,
            'status'=> true
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $this->authorize(ability: 'recoveryTrashed', arguments: [ModuleGroup::class, 'ModuleGroup.recoveryTrashed']);
        $result = ModuleGroup::onlyTrashed()->find($id)->recovery();

        return response([
            'record' => $result,
            'status'=> true
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize(ability: 'update', arguments: [ModuleGroup::class, 'ModuleGroup.update']);
        $query = ModuleGroup::find($id);
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
        $this->authorize(ability: 'updateAll', arguments: [ModuleGroup::class, 'ModuleGroup.updateAll']);
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize(ability: 'destroy', arguments: [ModuleGroup::class, 'ModuleGroup.destroy']);
        $exist = DB::table('module_groups')->whereExists(function ($query) use ($id) {
            $query->select(DB::raw(1))
                  ->from('modules')
                  ->whereRaw("modules.module_group_id = $id")
                  ->whereRaw("modules.module_group_id = module_groups.id");
        })->get();

        if(!count($exist) ){
            $query = ModuleGroup::find($id);
            $query->delete();
            return $this->showAll();
        } else {
            return $this->getExistModules($id);
        }
    }

    public function forceDestroy($id){
        $this->authorize(ability: 'forceDestroy', arguments: [ModuleGroup::class, 'ModuleGroup.forceDestroy']);
        $query = ModuleGroup::withTrashed()->find($id);
        $query->forceDelete();

        return response([
            'status'=> true
        ], 200);
    }

    public function getExistModules($id){
        $modules = DB::table('modules')->where('module_group_id', '=', $id)->get();

        foreach($modules as $module){
            $arrayModule[] = parseModule($module);
        };

        return response([
            'modules' => $arrayModule
        ], 200);

        return response([
            'message' => 'Hay un modulee vinculado a este grupo',
            'modules' => $arrayModule,
            'status'=> false
        ], 404);
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attachModuleGroup(ModuleGroup $var, Request $request){
        $this->authorize(ability: 'attach', arguments: [ModuleGroup::class, 'ModuleGroup.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->attach($arr);
    }

    // ELIMINA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function detachModuleGroup(ModuleGroup $var, Request $request){
        $this->authorize(ability: 'attach', arguments: [ModuleGroup::class, 'ModuleGroup.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->detach($arr);
    }

    // SINCRONIZA TODOS LOS ITEMS ENVIADOS EN REQUEST
    public function syncModuleGroup(ModuleGroup $var, Request $request){
        $this->authorize(ability: 'attach', arguments: [ModuleGroup::class, 'ModuleGroup.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->sync($arr);
    }
}
