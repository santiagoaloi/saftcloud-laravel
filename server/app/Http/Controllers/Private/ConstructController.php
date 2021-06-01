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
        $formfields = $this->constructTableFields($component);
        $headers = $this->constructTableHeaders($component);
        $model = $this->constructModel($component);



        return response([
            'formfields' => $formfields,
            'headers'    => $headers,
            'model'      => $model,
            'status' => true
        ], 200);
    }

    public function constructTable(){

    }

    public function constructTableFields($component){
        $config = json_decode($component->config, true);

        $fields = $config['formFields'];

        foreach ($fields as $field) {
            $formfields[$field['field']] = $field;
        };

        return $formfields;
    }

    public function constructTableHeaders($component){
        $config = json_decode($component->config, true);

        $fields = $config['formFields'];

        foreach ($fields as $field) {
            if($field['displayField']){
                $headers[][$field['field']] = $field;
            }
        };

        return $headers;
    }

    public function constructModel($component){
        $config = json_decode($component->config, true);

        $fields = $config['formFields'];

        foreach ($fields as $field) {
            if($field['displayField']){
                $headers[][$field['field']] = $field['field'];
            }
        };

        return $headers;
    }
}
