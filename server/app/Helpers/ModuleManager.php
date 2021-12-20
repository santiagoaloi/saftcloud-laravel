<?php
use Illuminate\Support\Facades\DB;

function parseComponent($component){
    $component_group_id = $component->component_group_id;
    $name = $component->name;
    $config = constructConfig($component->config);
    $configSettings = constructConfig($component->config_settings);
    $status = constructConfig($component->status);

    $capabilities = DB::SELECT("SELECT * FROM capabilities WHERE name LIKE '$name.%' AND deleted_at is NULL");
    $roles = DB::SELECT("SELECT * FROM roles WHERE entity_id = 1 or entity_id = 2");

    $origin = [
        'id'                => $module->id,
        'module_group_id'   => $module_group_id,
        'name'              => $name,
        'config'            => $config,
        'config_settings'   => $configSettings,
        'status'            => $status,
        'created_at'        => $component->created_at,
        'updated_at'        => $component->updated_at,
        'deleted_at'        => $component->deleted_at,
        'capabilities'      => $capabilities,
        'roles'             => $roles
    ];

    $result = [
<<<<<<< HEAD:server/app/Helpers/ModuleManager.php
        'id'                => $module->id,
        'module_group_id'   => $module_group_id,
=======
        'id'                => $component->id,
        'component_group_id'=> $component_group_id,
>>>>>>> e11b7b7581840df2bd2a497c08da68844416dee9:server/app/Helpers/ComponentManager.php
        'name'              => $name,
        'config'            => $config,
        'config_settings'   => $configSettings,
        'status'            => $status,
        'origin'            => $origin,
        'created_at'        => $component->created_at,
        'updated_at'        => $component->updated_at,
        'deleted_at'        => $component->deleted_at,
        'capabilities'      => $capabilities,
        'roles'             => $roles
    ];
    return $result;
}

function constructConfig($config){
    return json_decode($config, true);
}
