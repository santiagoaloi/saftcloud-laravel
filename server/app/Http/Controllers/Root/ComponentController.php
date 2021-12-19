<?php

namespace App\Http\Controllers\Root;

use Illuminate\Http\Request;

Use Exception;
use App\Models\Root\Component;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\Root\ComponentDefault;
use Illuminate\Database\QueryException;

class ComponentController extends Controller {

    public function componentConstructor($id) {
        $query = Component::find($id);

        $result = parseComponent($query);
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

        $component['columns']            = $config['columns'];
        $component['configSettings']     = $result['config_settings'];
        $component['formFields']         = $formFields;
        $component['recordItem']         = $recordItem;
        $component['records']            = $newRecords;

        return response([
            'component' => $component
        ], 200);
    }

    public function store(Request $request) {
        $this->authorize(ability: 'store', arguments: [Component::class, 'Component.store']);
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
        $this->authorize(ability: 'show', arguments: [Component::class, 'Component.show']);
        $query = Component::find($id);
        $result = parseComponent($query);

        return response([
            'component' => $result
        ], 200);
    }

    public function showAll() {
        $this->authorize(ability: 'showAll', arguments: [Component::class, 'Component.showAll']);
        $components = Component::all();
        $arrayComponent = [];

        foreach($components as $component){
            $arrayComponent[] = parseComponent($component);
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
            $config_settings = json_decode($component->config_settings, true);
            $title = $general_config['general_config']['title'];
            $arrayComponent[] = [
                'id'    => $component->id,
                'name'  => $component->name,
                'title' => $title,
                'configSettings' => $config_settings
            ];
        };

        return response([
            'components' => $arrayComponent
        ], 200);
    }

    public function getModules(){
        $query = Component::select('id', 'config->general_config->title as title', 'deleted_at')
        ->where([['status->modular', true]])->get();

        return response([
            'modules' => $query
        ], 200);
    }

    public function getActiveModules(){
        $query = Component::select('id', 'config->general_config->title as title')
        ->where([['deleted_at', NULL], ['status->modular', true], ['status->active', true]])->get();

        return response([
            'modules' => $query
        ], 200);
    }

    //  Para mostrar los elementos eliminados
    public function showTrashed() {
        $this->authorize(ability: 'showTrashed', arguments: [Component::class, 'Component.showTrashed']);
        return response([
            'components' => Component::onlyTrashed()->get()
        ], 200);
    }

    //  Para mostrar un elemento eliminado
    public function recoveryTrashed($id) {
        $this->authorize(ability: 'recoveryTrashed', arguments: [Component::class, 'Component.recoveryTrashed']);
        return response([
            'component' => Component::onlyTrashed()->find($id)->recovery()
        ], 200);
    }

    public function update(Request $request, $id) {
        $this->authorize(ability: 'update', arguments: [Component::class, 'Component.update']);
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
        $this->authorize(ability: 'updateAll', arguments: [Component::class, 'Component.updateAll']);
        foreach($request as $item){
            $component = Component::find($item['id']);
            $component->fill($item)->save();
        };

        return $this->showAll();
    }

    public function destroy($id) {
        $this->authorize(ability: 'destroy', arguments: [Component::class, 'Component.destroy']);
        $query = Component::find($id);
        $pathDeleted = resource_path('js/views/Deleted');
        if(!file_exists($pathDeleted)){
            makeNewDirectory($pathDeleted);
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
        $this->authorize(ability: 'forceDestroy', arguments: [Component::class, 'Component.forceDestroy']);
        $query = Component::withTrashed()->find($id);
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

    function makeNewComponentFile($request){
        $name = ucfirst(strtolower($request));
        $data = ['name' => $name];

        $vue_folder = resource_path("js/views/Protected/{$name}");

        makeNewDirectory($vue_folder);
        $tmp_vue = file_get_contents(resource_path("js/templates/componentBoilerplate.vue"));
        $build_vue = blend($tmp_vue, $data);
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
                $ArrayColumns[] = (object)$this->columnStructure($column);

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

    public function columnStructure($field) {
        $model = json_decode(ComponentDefault::pluck('config_structure')->last());

        $model->columns->value = $field;
        $model->columns->text = $field;

        return $model->columns;
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attachComponent(Component $var, Request $request){
        $this->authorize(ability: 'attach', arguments: [Component::class, 'Component.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->attach($arr);
    }

    // ELIMINA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function detachComponent(Component $var, Request $request){
        $this->authorize(ability: 'attach', arguments: [Component::class, 'Component.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->detach($arr);
    }

    // SINCRONIZA TODOS LOS ITEMS ENVIADOS EN REQUEST
    public function syncComponent(Component $var, Request $request){
        $this->authorize(ability: 'attach', arguments: [Component::class, 'Component.attach']);
        $items = $request['items'];
        $class = $request['name'];
        $arr = [];

        foreach($items as $item){
            $arr[] = $item['id'];
        }
        $var->$class()->sync($arr);
    }

}
