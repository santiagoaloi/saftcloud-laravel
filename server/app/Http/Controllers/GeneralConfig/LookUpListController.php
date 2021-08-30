<?php

namespace App\Http\Controllers\GeneralConfig;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Models\GeneralConfig\LookUpList;
use App\Models\GeneralConfig\LookUpListValue;

class LookUpListController extends Controller {

    public function store(Request $request) {
        try{
            $query = LookUpList::create($request->all());
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

    public function show(Request $id) {
        return response([
            'row'=> LookUpList::find($id)
        ], 200);
    }

    public function showAll() {
        return response([
            'rows'=> LookUpList::get()
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        return response([
            'rows'=> LookUpList::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        return response([
            'row'=> LookUpList::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $query = LookUpList::find($id);
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

    public function updateAll(Request $request) {
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $exist = DB::table('look_up_lists')->whereExists(function ($query) use ($id) {
            $query->select(DB::raw(1))
                ->from('components')
                ->whereRaw("look_up_list_values.look_up_list_id = $id")
                ->whereRaw("look_up_list_values.look_up_list_id = look_up_lists.id");
        })->get();

        if(count($exist) < 1){
            $query = LookUpList::find($id);
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
