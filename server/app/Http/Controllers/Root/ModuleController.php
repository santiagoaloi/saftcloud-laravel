<?php

namespace App\Http\Controllers\Root;

use Illuminate\Http\Request;

Use Exception;
use App\Models\Root\Module;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\Root\ModuleDefault;
use Illuminate\Database\QueryException;

class ModuleController extends Controller {

    public function moduleConstructor($id) {
        $query = Module::find($id);

        $result = parseModule($query);
        $config = constructConfig($query->config);
        $records = DB::SELECT($config['general_config']['sql_query']);

        foreach($records as $record){
            foreach($record as $key=>$val){
                $origin[$key] = $val;
            }
            $record->origin = $origin;
            $newRecords[]   = $record;
        }

        $configFormFields   = $config['form_fields'];
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

        $module['columns']            = $config['columns'];
        $module['configSettings']     = $result['config_settings'];
        $module['formFields']         = $formFields;
        $module['recordItem']         = $recordItem;
        $module['records']            = $newRecords;

        return response([
            'module' => $module
        ], 200);
    }

    public function store(Request $request) {
        $this->authorize(ability: 'store', arguments: [Module::class, 'Module.store']);
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
            'module_group_id'       => $request['module_group_id'],
            'name'                  => ucfirst(strtolower($request['name'])),
            'config'                => json_encode($config),
            'config_settings'       => json_encode($configSettings),
            'status'                => json_encode($status),
        ];

        try{
            Module::create($data);
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
        $this->makeNewModuleFile($request['name']);

        return $this->showAll();
    }

    public function show($id) {
        $this->authorize(ability: 'show', arguments: [Module::class, 'Module.show']);
        $query = Module::find($id);
        $result = parseModule($query);

        return response([
            'module' => $result
        ], 200);
    }

    public function showAll() {
        $this->authorize(ability: 'showAll', arguments: [Module::class, 'Module.showAll']);
        $modules = Module::all();
        $arrayModule = [];

        foreach($modules as $module){
            $arrayModule[] = parseModule($module);
        };

        return response([
            'modules' => $arrayModule
        ], 200);
    }

    public function getModuleNames(){
        $modules = Module::all();
        $arrayModule = [];

        foreach($modules as $module){
            $general_config = json_decode($module->config, true);
            $config_settings = json_decode($module->config_settings, true);
            $title = $general_config['general_config']['title'];
            $arrayModule[] = [
                'id'    => $module->id,
                'name'  => $module->name,
                'title' => $title,
                'configSettings' => $config_settings
            ];
        };

        return response([
            'modules' => $arrayModule
        ], 200);
    }

    public function getModules(){
        $query = Module::select('id', 'config->general_config->title as title', 'deleted_at')
        ->where([['status->modular', true]])->get();

        return response([
            'modules' => $query
        ], 200);
    }

    public function getActiveModules(){
        $query = Module::select('id', 'config->general_config->title as title')
        ->where([['deleted_at', NULL], ['status->modular', true], ['status->active', true]])->get();

        return response([
            'modules' => $query
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function showTrashed() {
        $this->authorize(ability: 'showTrashed', arguments: [Module::class, 'Module.showTrashed']);
        return response([
            'modules' => Module::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $this->authorize(ability: 'recoveryTrashed', arguments: [Module::class, 'Module.recoveryTrashed']);
        return response([
            'module' => Module::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize(ability: 'update', arguments: [Module::class, 'Module.update']);
        $query = Module::find($id);

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

                $originalFormFields = json_decode($query->config, true);

                $result = compareItems($originalFormFields, $newFormFields);

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
        $this->authorize(ability: 'updateAll', arguments: [Module::class, 'Module.updateAll']);
        foreach($request as $item){
            $module = Module::find($item['id']);
            $module->fill($item)->save();
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize(ability: 'destroy', arguments: [Module::class, 'Module.destroy']);
        $query = Module::find($id);
        $pathDeleted = resource_path('js/views/Deleted');
        if(!file_exists($pathDeleted)){
            makeNewDirectory($pathDeleted);
        }

        // delete module folder
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
        $this->authorize(ability: 'forceDestroy', arguments: [Module::class, 'Module.forceDestroy']);
        $query = Module::withTrashed()->find($id);
        $pathDeleted = resource_path("js/views/Deleted/{$query->name}");
        if(file_exists($pathDeleted)){
            deleteDirectory($pathDeleted);
        }

        $pathProtected = resource_path("js/views/Protected/{$query->name}");
        if(file_exists($pathProtected)){
            deleteDirectory($pathProtected);
        }

        // delete row in db
        $query->forceDelete();

        return response([
            'status'=> true
        ], 200);
    }

    function makeNewModuleFile($request){
        $name = ucfirst(strtolower($request));
        $data = ['name' => $name];

        $vue_folder = resource_path("js/views/Protected/{$name}");

        makeNewDirectory($vue_folder);
        $tmp_vue = file_get_contents(resource_path("js/templates/moduleBoilerplate.vue"));
        $build_vue = blend($tmp_vue, $data);
        file_put_contents( $vue_folder . "/{$data['name']}.vue" , $build_vue);
    }

    function buildGeneralConfig(){
        $query = json_decode(ModuleDefault::get('config_structure')->last());
        $config_structure = json_decode($query->config_structure);
        return $config_structure->general_config;
    }

    //** FORMA NUEVA **//
    function buildColumnsAndFields($columns){
        foreach ($columns as $column) {
            if($column != 'id' && $column != 'temp'){
                $ArrayColumns[] = (object)$this->columnStructure($column);

                $ArrayFields[] = (object)$this->formFieldStructure($column);
            }
        };
        return [
            'ArrayColumns'=>$ArrayColumns, 'ArrayFields'=>$ArrayFields
        ];
    }

    public function formFieldStructure($field) {
        $model = json_decode(ModuleDefault::pluck('config_structure')->last());

        $model->form_fields->field = $field;
        $model->form_fields->label = $field;

        return $model->form_fields;
    }

    public function columnStructure($field) {
        $model = json_decode(ModuleDefault::pluck('config_structure')->last());

        $model->columns->value = $field;
        $model->columns->text = $field;

        return $model->columns;
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attachModule(Module $var, Request $request){
        $this->authorize(ability: 'attach', arguments: [Module::class, 'Module.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->attach($arr);
    }

    // ELIMINA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function detachModule(Module $var, Request $request){
        $this->authorize(ability: 'attach', arguments: [Module::class, 'Module.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->detach($arr);
    }

    // SINCRONIZA TODOS LOS ITEMS ENVIADOS EN REQUEST
    public function syncModule(Module $var, Request $request){
        $this->authorize(ability: 'attach', arguments: [Module::class, 'Module.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->sync($arr);
    }

}
