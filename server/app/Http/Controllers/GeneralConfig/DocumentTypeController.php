<?php

namespace App\Http\Controllers\GeneralConfig;

use App\Models\GeneralConfig\DocumentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class DocumentTypeController extends Controller {

    public function store(Request $request) {
        $this->authorize('store', DocumentType::class);
        try{
            $query = DocumentType::create($request->all());
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
        $this->authorize('show', DocumentType::class);
        $result = DocumentType::find($id);
        origin($result);

        return response([
            'record'=> $result
        ], 200);
    }

    public function showAll() {
        $this->authorize('showAll', DocumentType::class);
        $result = DocumentType::get();
        foreach ($result as $item){
            origin($item);
        }

        return response([
            'records'=> $result
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        $this->authorize('getTrashed', DocumentType::class);
        return response([
            'records'=> DocumentType::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function restore($id) {
        $this->authorize('restore', DocumentType::class);
        return response([
            'record'=> DocumentType::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize('update', DocumentType::class);
        $query = DocumentType::find($id);
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
        $this->authorize('updateAll', DocumentType::class);
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize('destroy', DocumentType::class);
        $query = DocumentType::find($id);
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $this->authorize('forceDestroy', DocumentType::class);
        $query = DocumentType::withTrashed()->find($id);
        $query->forceDelete();
        return response([
            'status'=> true
        ], 200);
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attachDocumentType(DocumentType $documentType, Request $request){
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $documentType->$class()->attach($arr);
    }

    // ELIMINA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function detachDocumentType(DocumentType $documentType, Request $request){
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $documentType->$class()->detach($arr);
    }

    // SINCRONIZA TODOS LOS ITEMS ENVIADOS EN REQUEST
    public function syncDocumentType(DocumentType $documentType, Request $request){
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $documentType->$class()->sync($arr);
    }
}
