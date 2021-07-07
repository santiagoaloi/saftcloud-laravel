<?php

namespace App\Http\Controllers\Root;

use App\Http\Controllers\Controller;
use App\Models\Root\Component;
use Illuminate\Http\Request;

Use Exception;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use App\Helpers\FileManager;

use App\Models\Root\ComponentDefault;
use Jawira\CaseConverter\Convert;

class ComponentController extends Controller {

    public function store(Request $request) {
        $json_data['table'] = $request['table'];

        $sql_query = "SELECT {$request['table']}.* FROM {$request['table']}";
        $sql_modified = str_replace('SELECT', 'SELECT count(*) as temp, ', $sql_query);
        $object =  array_keys((array)DB::SELECT($sql_modified)[0]);

        $formColumnsAndFields = $this->formColumnsAndFields($object);

        $config['sql_table']    = $request['table'];
        $config['sql_query']    = $sql_query;
        $config['columns']      = $formColumnsAndFields['ArrayColumns'];
        $config['form_fields']  = $formColumnsAndFields['ArrayFields'];
        $config['title']        = $request['title'];
        $config['note']         = $request['note'];

        $configSettings['icon'] = [
            'name'  => 'mdi-apps',
            'color' => '#6453DCED',
        ];

        $status = [
            'starred'   => false,
            'active'    => true,
            'modular'   => false,
        ];

        $data = [
            'component_group_id'    => $request['component_group_id'],
            'name'                  => $request['name'],
            'config'                => json_encode($config),
            'config_settings'       => json_encode($configSettings),
            'status'                => json_encode($status),
        ];

        Component::create($data);

        $this->makeNewComponentFile($request['name']);

        return $this->showAll(true);
    }

    public function show($id) {
        $query = Component::find($id);
        $result = $this->parseComponent($query);

        return response([
            'component' => $result
        ], 200);
    }

    public function showAll($local = false) {
        $components = Component::all();
        $arrayComponent = [];

        foreach($components as $component){
            $arrayComponent[] = $this->parseComponent($component);
        };

        if ($local){
            return $arrayComponent;
        } else {
            return response([
                'components' => $arrayComponent
            ], 200);
        }
    }

    //  Para mostrar los elementos eliminados
    public function getTrashed() {
        return response([
            'components' => Component::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        return response([
            'component' => Component::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function edit($id) {

    }

    public function update(Request $request, $id) {
        $query = Component::find($id);
        $sql_original = json_decode($query->config, true)['sql_query'];

        $input = $request->all();

        if(isset($request->config['sql_query'])){
            $sql_new = $request->config['sql_query'];

            if($sql_original != $sql_new) {
                try{
                    DB::select($sql_new);
                }catch(Exception $e){
                    return response()->json(array('message' =>$e->getMessage())); 
                }

                // No puedo accceder al string del mensaje de error.
                // }catch(QueryException $ex){ 
                //     dd($ex->getMessage()); 
                // }

                $sql_query = str_replace('SELECT', 'SELECT count(*) as temp, ', $sql_new);
                try{
                    $object =  array_keys((array)DB::SELECT($sql_query)[0]);
                }catch(Exception $e){
                    return response()->json(array('message' =>$e->getMessage())); 
                }

                $formColumnsAndFields = $this->formColumnsAndFields($object);
                $newFormFields = $formColumnsAndFields['ArrayFields'];

                $originalFormFields = json_decode($query->config, true)['form_fields'];
                $compare = new ComponentDefaultController;
                $result = $compare->testCompare($newFormFields, $originalFormFields);

                $input['config']['columns'] = $formColumnsAndFields['ArrayColumns'];
                $input['config']['form_fields'] = $result;
            }
        }

        $query->fill($input)->save();

        return $this->show($query->id);
    }

    public function updateAll($request) {
        foreach($request as $item){
            $component = Component::find($item['id']);
            $component->fill($item)->save();
        };

        return $this->showAll(true);
    }

    public function destroy($id) {
        $query = Component::find($id);

        // delete component folder
        $vue_folder = resource_path("js/views/Protected/{$query->name}");

        $deleted_folder = resource_path("js/views/Deleted/{$query->name}");

        if (is_dir($vue_folder)) {
            rename($vue_folder, $deleted_folder);
        }

        // delete row in db
        $query->delete();

        return $this->showAll(true);
    }

    public function parseComponent($component){
        $component_group_id = $component->component_group_id;
        $name = $component->name;
        $config = $this->constructConfig($component->config);
        $configSettings = $this->constructConfig($component->config_settings);
        $status = $this->constructConfig($component->status);

        $origin = [
            'id'                => $component->id,
            'component_group_id'=> $component_group_id,
            'name'              => $name,
            'config'            => $config,
            'config_settings'   => $configSettings,
            'status'            => $status,
            'created_at'        => $component->created_at,
            'updated_at'        => $component->updated_at,
        ];

        $result = [
            'id'                => $component->id,
            'component_group_id'=> $component_group_id,
            'name'              => $name,
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

    function makeNewComponentFile($request){
        $name = new Convert($request);

        $data = ['name' => $name->fromCamel()->toPascal()];

        $vue_folder = resource_path("js/views/Protected/{$name->fromCamel()->toKebab()}");

        FileManager::makeNewDirectory($vue_folder);
        $tmp_vue = file_get_contents(resource_path("js/templates/componentBoilerplate.vue"));
        $build_vue = Helper::blend($tmp_vue, $data);
        file_put_contents( $vue_folder . "/{$data['name']}.vue" , $build_vue);
    }

    //** FORMA NUEVA **//
    function formColumnsAndFields($columns){
        foreach ($columns as $column) {
            if($column != 'id' && $column != 'temp'){
                $ArrayColumns[] = ['name' => $column];

                $ArrayFields[] = (object)$this->formFieldStructure($column);
            }
        };
        return [
            'ArrayColumns'=>$ArrayColumns, 'ArrayFields'=>$ArrayFields
        ];
    }

    public function formFieldStructure($field) {
        $model = json_decode(ComponentDefault::pluck('config_structure')->last());

        $model->form_fields->field = $field;
        $model->form_fields->label = $field;

        return $model->form_fields;
    }

}
