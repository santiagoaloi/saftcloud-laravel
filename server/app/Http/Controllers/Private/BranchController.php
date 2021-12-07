<?php

namespace App\Http\Controllers\Private;

use Illuminate\Http\Request;
use App\Models\Private\Branch;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class BranchController extends Controller {

    public function store(Request $request) {
        $this->authorize(ability: 'store', arguments: [Branch::class, 'Branch.store']);
        try{
            $query = Branch::create($request->all());
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

    public function show($id) {
        $this->authorize(ability: 'show', arguments: [Branch::class, 'Branch.show']);
        $result = Branch::find($id);
        origin($result);

        return response([
            'record'=> $result
        ], 200);
    }

    public function showAll() {
        $this->authorize(ability: 'showAll', arguments: [Branch::class, 'Branch.showAll']);
        $result = Branch::get();
        foreach ($result as $item){
            origin($item);
        }

        return response([
            'records'=> $result
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function showTrashed() {
        $this->authorize(ability: 'showTrashed', arguments: [Branch::class, 'Branch.showTrashed']);
        return response([
            'records'=> Branch::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $this->authorize(ability: 'recoveryTrashed', arguments: [Branch::class, 'Branch.recoveryTrashed']);
        return response([
            'record'=> Branch::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize(ability: 'update', arguments: [Branch::class, 'Branch.update']);
        $query = Branch::find($id);
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

    public function updateAll(Request $request) {
        $this->authorize(ability: 'updateAll', arguments: [Branch::class, 'Branch.updateAll']);
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize(ability: 'destroy', arguments: [Branch::class, 'Branch.destroy']);
        $query = Branch::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize(ability: 'forceDestroy', arguments: [Branch::class, 'Branch.forceDestroy']);
        $query = Branch::withTrashed()->find($id);
        $query->forceDelete();
        return response([
            'status'=> true
        ], 200);
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attachBranch(Branch $branch, Request $request){
        $this->authorize(ability: 'attach', arguments: [Branch::class, 'Branch.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $branch->$class()->attach($arr);
    }

    // ELIMINA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function detachBranch(Branch $branch, Request $request){
        $this->authorize(ability: 'attach', arguments: [Branch::class, 'Branch.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $branch->$class()->detach($arr);
    }

    // SINCRONIZA TODOS LOS ITEMS ENVIADOS EN REQUEST
    public function syncBranch(Branch $branch, Request $request){
        $this->authorize(ability: 'attach', arguments: [Branch::class, 'Branch.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $branch->$class()->sync($arr);
    }

    public function getBranchModules(Branch $branch){
        $result = [];
        $modules = $branch->component;
        foreach($modules as $module){
            $result[] = ['id'=>$module->id, 'name'=>$module->name];
        };

        $user['modules'] = $result;
    }

}
