<?php

namespace App\Http\Controllers\Root;

use App\Http\Controllers\Controller;
use App\Models\Root\Component;
use Illuminate\Http\Request;

use App\Http\Controllers\Root\MysqlController;
use Illuminate\Support\Facades\File;

use Jawira\CaseConverter\Convert;

class ComponentController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request) {
        $json_data['table'] = $request['table'];

        $MysqlController = new MysqlController;
        $columns = $MysqlController->showColumns($request);

        foreach ($columns as $column) {
            $ArrayColumns[] = [
                'name'  =>   $column,
            ];

            $ArrayFields[] = [
                'field'         => $column,
                'display_field'  => true,
            ];
        };

        $sql_select = "SELECT {$request['table']}.* FROM {$request['table']}";
        $sql_where  = " WHERE ".$request['table'].". id IS NOT NULL";
        $sql_group  = "";

        $config['sql_table']    = $request['table'];
        $config['sql_select']   = $sql_select;
        $config['sql_where']    = $sql_where;
        $config['sql_group']    = $sql_group;
        $config['columns']      = $ArrayColumns;
        $config['form_fields']  = $ArrayFields;
        $config['name']         = $request['name'];
        $config['title']        = $request['title'];
        $config['note']         = $request['note'];

        $configSettings['icon']    = [
            'name'  => 'mdi-folder',
            'color' => 'blue',
        ];

        $configSettings['status'] = [
            'starred'   => false,
            'active'    => true,
            'inactive'  => false,
            'modular'   => false,
        ];

        $data = [
            'component_group_id'    => $request['component_group_id'],
            'config'                => json_encode($config),
            'config_settings'       => json_encode($configSettings),
        ];

        Component::create($data);

        $this->makeNewComponent($request['name']);

        $query = $this->showAll(true);

        return response([
            'components' => $query,
            'status' => true
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function show($id) {
        $query = Component::findOrFail($id);
        $component = $this->parseComponent($query);

        return response([
            'components' =>  $component,
            'status' => true
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function showAll($local = false) {
        $components = Component::all();
        $arrayComponent = [];

        // Local is used when we call it by an other function
        if ($local){
            foreach($components as $component){
                $arrayComponent[] = $this->parseComponent($component);
            };

            return $arrayComponent;
        } else {
            foreach($components as $component){
                $arrayComponent[] = $this->parseComponent($component);
            };

            return response([
                'components' => $arrayComponent,
                'status'    => true
            ], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function edit($id) {

        $components = $this->showAll(true);

        return response([
            'components'=> $components,
            'status'    => true
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id) {
        $query = Component::findOrFail($id);

        $input = $request->all();

        $query->fill($input)->save();

        $components = $this->showAll(true);

        return response([
            'components'=> $components,
            'status'    => true
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function destroy($id) {
        $query = Component::findOrFail($id);
        $query->delete();

        return $this->showAll();
    }

    public function parseComponent($component){
        $component_group_id = $component->component_group_id;
        $config = $this->constructConfig($component->config);
        $configSettings = $this->constructConfig($component->config_settings);
        $origin = [
            'id'                => $component->id,
            'component_group_id'=> $component_group_id,
            'config'            => $config,
            'config_settings'   => $configSettings,
            'created_at'        => $component->created_at,
            'updated_at'        => $component->updated_at,
        ];

        $result = [
            'id'                => $component->id,
            'component_group_id'=> $component_group_id,
            'config'            => $config,
            'config_settings'   => $configSettings,
            'origin'            => $origin,
            'created_at'        => $component->created_at,
            'updated_at'        => $component->updated_at,
        ];

        return $result;
    }

    public function constructConfig($config){
        return json_decode($config, true);
    }

    public function constructConfigSettings($configSettings){
        return json_decode($configSettings, true);
    }


    function makeNewComponent($request){
        $name = new Convert($request);

        $data = [
            'name' => $name->fromCamel()->toPascal(),
        ];

        $vue_folder = resource_path("js/views/Protected/{$name->fromCamel()->toKebab()}");

        $this->makeNewDirectory($vue_folder);

        $tmp_vue = file_get_contents(resource_path("js/templates/componentBoilerplate.vue"));

        $build_vue = $this::blend($tmp_vue, $data);

        file_put_contents( $vue_folder . "/{$data['name']}.vue" , $build_vue);
    }

    function makeNewDirectory($request){
        if (! File::exists($request)) {
            File::makeDirectory($request);
        }
    }

    public static function blend($filePath, $data){
        foreach($data as $k=>$v){
            $key[] = "{".$k."}";
            $value[] = $v;
        }

        $fileContent = str_ireplace($key, $value, $filePath);

        return $fileContent;
    }
}
