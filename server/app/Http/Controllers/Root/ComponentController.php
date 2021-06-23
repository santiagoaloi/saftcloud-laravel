<?php

namespace App\Http\Controllers\Root;

use App\Http\Controllers\Controller;
use App\Models\Root\Component;
use Illuminate\Http\Request;

use App\Http\Controllers\Root\MysqlController;
use Illuminate\Support\Facades\File;

use App\Models\Root\ComponentDefault;
use Jawira\CaseConverter\Convert;

class ComponentController extends Controller {

    public function create() {
        //
    }

    public function store(Request $request) {
        $json_data['table'] = $request['table'];

        $MysqlController = new MysqlController;
        $columns = $MysqlController->showColumns($request);

        foreach ($columns as $column) {
            $ArrayColumns[] = ['name' => $column];

            $ArrayFields[] = (object)$this->formFieldStructure($column);
        };

        $sql_select = "SELECT {$request['table']}.* FROM {$request['table']}";
        $sql_where  = " WHERE ".$request['table'].". id IS NOT NULL";
        $sql_group  = "";

        $config[] = $request;

        $config['sql_table']    = $request['table'];
        $config['sql_select']   = $sql_select;
        $config['sql_where']    = $sql_where;
        $config['sql_group']    = $sql_group;
        $config['columns']      = $ArrayColumns;
        $config['form_fields']  = $ArrayFields;
        $config['name']         = $request['name'];
        $config['title']        = $request['title'];
        $config['note']         = $request['note'];

        $configSettings['icon'] = [
            'name'  => 'mdi-folder',
            'color' => 'blue',
        ];

        $status = [
            'starred'   => false,
            'active'    => true,
            'modular'   => false,
        ];

        $data = [
            'component_group_id'    => $request['component_group_id'],
            'config'                => json_encode($config),
            'config_settings'       => json_encode($configSettings),
            'status'                => json_encode($status),
        ];

        Component::create($data);

        $this->makeNewComponent($request['name']);

        $query = $this->showAll(true);

        return response([
            'components' => $query,
            'status' => true
        ], 200);
    }

    public function show($id, $local = false) {
        $query = Component::findOrFail($id);
        $result = $this->parseComponent($query);

        if ($local){
            return $result;
        } else {
            return response([
                'component' => $result,
                'status' => true
            ], 200);
        }
    }

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

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        $result = Component::onlyTrashed()->get();

        return response([
            'components' => $result,
            'status'    => true
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $result = Component::onlyTrashed()->findOrFail($id)->recovery();

        return response([
            'component' => $result,
            'status'    => true
        ], 200);
    }

    public function edit($id) {
        $result = $this->showAll(true);

        return response([
            'components'=> $result,
            'status'    => true
        ], 200);
    }

    public function update(Request $request, $id) {
        $query = Component::findOrFail($id);

        $input = $request->all();

        $query->fill($input)->save();

        $result = $this->show($id, true);

        return response([
            'component'=> $result,
            'status'    => true
        ], 200);
    }

    public function updateAll(Request $request) {
        foreach($request as $item){
            $this->update($item, $item->id);
        };

        $result = $this->showAll(true);

        return response([
            'components'=> $result,
            'status'    => true
        ], 200);
    }

    public function destroy($id) {
        $query = Component::findOrFail($id);
        $config = json_decode($query->config, true);

        // delete component folder
        $vue_folder = resource_path("js/views/Protected/{$config['name']}");

        $deleted_folder = resource_path("js/views/Deleted/{$config['name']}");

        if (is_dir($vue_folder)) {
            rename($vue_folder, $deleted_folder);
        }

        // if(file_exists("$vue_folder/$component_config->name.vue"))
        // unlink("$vue_folder/$component_config->name.vue");

        // delete row in db
        $query->delete();

        return $this->showAll();
    }

    public function parseComponent($component){
        $component_group_id = $component->component_group_id;
        $config = $this->constructConfig($component->config);
        $configSettings = $this->constructConfig($component->config_settings);
        $status = $this->constructConfig($component->status);

        $origin = [
            'id'                => $component->id,
            'component_group_id'=> $component_group_id,
            'config'            => $config,
            'config_settings'   => $configSettings,
            'status'            => $status,
            'created_at'        => $component->created_at,
            'updated_at'        => $component->updated_at,
        ];

        $result = [
            'id'                => $component->id,
            'component_group_id'=> $component_group_id,
            'config'            => $config,
            'config_settings'   => $configSettings,
            'status'            => $status,
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

    public function formFieldStructure($field) {
        $model = json_decode(ComponentDefault::pluck('config_structure')->last());

        $model->form_fields->field = $field;
        $model->form_fields->label = $field;

        return $model->form_fields;
    }

}
