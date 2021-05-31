<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use App\Models\Root\Component;
use Illuminate\Http\Request;

use App\Http\Controllers\Root\MysqlController;

class ConstructController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function index(Request $request) {
        $query = Component::find($request);
        $component = $query[0];

        $config = $component->config;

        $formFields = $config['formFields'];

        return $formFields;

        foreach ($formFields as $field) {
            $ArrayColumns[$field->field] = [
                $field = $field->field,
            ];
        };

        return $ArrayColumns;

        $headers[] = $ArrayColumns;

        return response([
            'rows' =>  $headers,
            'status' => true
        ], 200);
    }

    public function constructTable(){

    }

    public function constructTableFields(){

    }
}
