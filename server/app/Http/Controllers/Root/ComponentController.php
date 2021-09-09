<?php

namespace App\Http\Controllers\Root;

use App\Helpers\Helper;
use App\Helpers\FileManager;
use App\Helpers\ComponentManager;
use Illuminate\Http\Request;

Use Exception;
use App\Models\Root\Component;
use Jawira\CaseConverter\Convert; // borrar
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\Root\ComponentDefault;
use Illuminate\Database\QueryException;

class ComponentController extends Controller {

    public function componentConstructor($id) {
        $query = Component::find($id);

        $result = ComponentManager::parseComponent($query);

        $config = ComponentManager::constructConfig($query->config);

        $records = DB::SELECT($config['general_config']['sql_query']);
        $configFormFields = $config['form_fields'];

        foreach($configFormFields as $formField){
            if($formField['displayField'] == 'true'){
                foreach($formField as $value=>$v){
                    if($value == 'field'){
                        $recordItem[$v] = '';
                    }
                }
            }
        };

        foreach($configFormFields as $formField){
            if($formField['displayField'] == 'true'){
                $field = $formField['field'];
                $formFields[$field] = $formField;
            }
        };

        $result['columns'] = $config['columns'];
        $result['formFields'] = $formFields;
        $result['recordItem'] = $recordItem;
        $result['records'] = $records;

        return response([
            'component' => $result
        ], 200);

    }

    public function store(Request $request) {
        $json_data['table'] = $request['table'];

        $sql_query = "SELECT {$request['table']}.* FROM {$request['table']}";
        $sql_modified = str_replace('SELECT', 'SELECT count(*) as temp, ', $sql_query);
        $object =  array_keys((array)DB::SELECT($sql_modified)[0]);

        $formColumnsAndFields = $this->buildColumnsAndFields($object);  // TRAE LOS VALORES POR DEFECTO DE 
        $general_config       = $this->buildGeneralConfig();

        $config['general_config']               = $general_config;
        $config['general_config']->sql_table    = $request['table'];
        $config['general_config']->sql_query    = $sql_query;
        $config['general_config']->title        = $request['title'];
        $config['general_config']->note         = $request['note'];

        $config['columns']      = $formColumnsAndFields['ArrayColumns'];
        $config['form_fields']  = $formColumnsAndFields['ArrayFields'];

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
            'name'                  => ucfirst(strtolower($request['name'])),
            'config'                => json_encode($config),
            'config_settings'       => json_encode($configSettings),
            'status'                => json_encode($status),
        ];

        try{
            Component::create($data);
        }
        catch(\Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode){
                return response([
                    'message'=> $e->errorInfo[2],
                    'code'=> $e->errorInfo[1]
                ], 404);
            }
        }

        $this->makeNewComponentFile($request['name']);

        return $this->showAll();
    }

    public function show($id) {
        $query = Component::find($id);
        $result = ComponentManager::parseComponent($query);

        return response([
            'component' => $result
        ], 200);
    }

    public function showAll() {
        $components = Component::all();
        $arrayComponent = [];

        foreach($components as $component){
            $arrayComponent[] = ComponentManager::parseComponent($component);
        };

        return response([
            'components' => $arrayComponent
        ], 200);
    }

    public function getComponentNames(){
        $components = Component::all();
        $arrayComponent = [];

        foreach($components as $component){
            $general_config = json_decode($component->config, true);
            $title = $general_config['general_config']['title'];
            $arrayComponent[] = [
                'id'    => $component->id,
                'name'  => $component->name,
                'title' => $title,
            ];
        };

        return response([
            'components' => $arrayComponent
        ], 200);
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

    public function update(Request $request, $id) {
        $query = Component::find($id);

        $general_config = json_decode($query->config, true);
        $sql_original = $general_config['general_config']['sql_query'];

        $input = $request->all();

        if(isset($request->config['general_config']['sql_query'])){
            $sql_new = $request->config['general_config']['sql_query'];

            if($sql_original != $sql_new) {
                try{
                    DB::select($sql_new);
                }catch(Exception $e){
                    return response()->json(array('message' =>$e->getMessage())); 
                }

                $sql_query = str_replace('SELECT', 'SELECT count(*) as temp, ', $sql_new);
                try{
                    $object =  array_keys((array)DB::SELECT($sql_query)[0]);
                }catch(Exception $e){
                    return response()->json(array('message' =>$e->getMessage())); 
                }

                $formColumnsAndFields = $this->buildColumnsAndFields($object);
                $newFormFields = $formColumnsAndFields['ArrayFields'];

                $originalFormFields = json_decode($query->config, true)['form_fields'];

                $result = Helper::compareItems($originalFormFields, $newFormFields);

                $input['config']['columns'] = $formColumnsAndFields['ArrayColumns'];
                $input['config']['form_fields'] = $result;
            }
        }

        try{
            $query->fill($input)->save();
        }
        catch(QueryException $e){
            if($e->errorInfo[1]){
                return response([
                    'message'=> $e->errorInfo[2],
                    'code'=> $e->errorInfo[1]
                ], 404);
            }
        }

        return $this->show($query->id);
    }

    public function updateAll($request) {
        foreach($request as $item){
            $component = Component::find($item['id']);
            $component->fill($item)->save();
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $query = Component::find($id);
        $pathDeleted = resource_path('js/views/Deleted');
        if(!file_exists($pathDeleted)){
            FileManager::makeNewDirectory($pathDeleted);
        }

        // delete component folder
        $vue_folder = resource_path("js/views/Protected/{$query->name}");

        $deleted_folder = resource_path("js/views/Deleted/{$query->name}");

        if (is_dir($vue_folder)) {
            rename($vue_folder, $deleted_folder);
        }

        // delete row in db
        $query->delete();

        return $this->showAll();
    }

    public function forceDestroy($id){
        $query = Component::withTrashed()->find($id);
        $pathDeleted = resource_path("js/views/Deleted/{$query->name}");
        if(file_exists($pathDeleted)){
            FileManager::deleteDirectory($pathDeleted);
        }

        $pathProtected = resource_path("js/views/Protected/{$query->name}");
        if(file_exists($pathProtected)){
            FileManager::deleteDirectory($pathProtected);
        }

        // delete row in db
        $query->forceDelete();

        return response([
            'status'=> true
        ], 200);
    }

    function makeNewComponentFile($request){
        $name = ucfirst(strtolower($request));
        $data = ['name' => $name];

        $vue_folder = resource_path("js/views/Protected/{$name}");

        FileManager::makeNewDirectory($vue_folder);
        $tmp_vue = file_get_contents(resource_path("js/templates/componentBoilerplate.vue"));
        $build_vue = Helper::blend($tmp_vue, $data);
        file_put_contents( $vue_folder . "/{$data['name']}.vue" , $build_vue);
    }

    function buildGeneralConfig(){
        $query = json_decode(ComponentDefault::get('config_structure')->last());
        $config_structure = json_decode($query->config_structure);
        return $config_structure->general_config;
    }

    //** FORMA NUEVA **//
    function buildColumnsAndFields($columns){
        foreach ($columns as $column) {
            if($column != 'id' && $column != 'temp'){
                $ArrayColumns[] = ['column' => $column, 'label'=>$column];

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
