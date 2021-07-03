<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use App\Models\Private\UserSettings;
use Illuminate\Http\Request;

class UserSettingsController extends Controller {

    public function store(Request $request) {
        $query = UserSettings::create($request->all());
        return response([
            'row'=> $query,
            'status'=> true
        ], 200);
    }

    public function show(Request $id, $local = false) {
        $result = UserSettings::find($id);

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
            return UserSettings::get();
        } else {
            return response([
                'rows'=> UserSettings::get(),
                'status'=> true
            ], 200);
        }
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        $result = UserSettings::onlyTrashed()->get();

        return response([
            'rows'=> $result,
            'status'=> true
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $result = UserSettings::onlyTrashed()->findOrFail($id)->recovery();

        return response([
            'row'=> $result,
            'status'=> true
        ], 200);
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        $query = UserSettings::findOrFail($id);

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
        $query = UserSettings::findOrFail($id);
        $query->delete();

        return $this->showAll(true);
    }
}
