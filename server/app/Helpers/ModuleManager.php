<?php
use Illuminate\Support\Facades\DB;

function parseModule($module){
    $module_group_id = $module->module_group_id;
    $name = $module->name;
    $config = constructConfig($module->config);
    $configSettings = constructConfig($module->config_settings);
    $status = constructConfig($module->status);

    $capabilities = DB::SELECT("SELECT * FROM capabilities WHERE name LIKE '$name.%' AND deleted_at is NULL");
    $roles = DB::SELECT("SELECT * FROM roles WHERE entity_id = 1 or entity_id = 2");

    $origin = [
        'id'                => $module->id,
        'module_group_id'   => $module_group_id,
        'name'              => $name,
        'config'            => $config,
        'config_settings'   => $configSettings,
        'status'            => $status,
        'created_at'        => $module->created_at,
        'updated_at'        => $module->updated_at,
        'deleted_at'        => $module->deleted_at,
        'capabilities'      => $capabilities,
        'roles'             => $roles
    ];

    $result = [
        'id'                => $module->id,
        'module_group_id'   => $module_group_id,
        'name'              => $name,
        'config'            => $config,
        'config_settings'   => $configSettings,
        'status'            => $status,
        'origin'            => $origin,
        'created_at'        => $module->created_at,
        'updated_at'        => $module->updated_at,
        'deleted_at'        => $module->deleted_at,
        'capabilities'      => $capabilities,
        'roles'             => $roles
    ];
    return $result;
}

function constructConfig($config){
    return json_decode($config, true);
}
