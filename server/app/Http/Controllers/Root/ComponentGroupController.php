<?php

namespace App\Http\Controllers\Root;

use App\Http\Controllers\Controller;
use App\Models\Root\ComponentGroup;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
