<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use App\Models\Root\Module;
use Illuminate\Http\Request;

use App\Http\Controllers\Root\MysqlController;
use App\Http\Controllers\Root\ModuleController;

class ConstructController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function index(Request $request) {
        $query = Module::find($request);
        $module = $query[0];
        $moduleController = new ModuleController;
        $config = $moduleController->constructConfig($module->config);
        $configSettings = $moduleController->constructConfig($module->config_settings);

        $formFields = $this->constructTableFields($config);
        $headers = $this->constructTableHeaders($config);
        $model = $this->constructModel($config);
        $pageHeader = $module->title;
        $table = $config['sql_table'];

        return response([
            'table'         => $table,
            'form_fields'   => $formFields,
            'headers'       => $headers,
            'models'        => $model,
            'page_header'   => $pageHeader,
            'config_settings'=> $configSettings,
            'status' => true
        ], 200);
    }

    public function constructTable(){

    }

    public function constructTableFields($config){
        $fields = $config['form_fields'];

        foreach ($fields as $field) {
            $formFields[$field['field']] = $field;
        };

        return $formFields;
    }

    public function constructTableHeaders($config){
        $fields = $config['form_fields'];

        foreach ($fields as $field) {
            if($field['display_field']){
                $headers[] = [
                    'value' => $field['field'],
                    'text' => $field['field'],
                ];
            }
        };

        return $headers;
    }

    public function constructModel($config){
        $fields = $config['form_fields'];

        foreach ($fields as $field) {
            if($field['display_field']){
                $models[$field['field']] = '';
            }
        };

        return $models;
    }

}
