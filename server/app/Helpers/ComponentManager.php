<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class ComponentManager {

    static function parseComponent($component){
        $component_group_id = $component->component_group_id;
        $name = $component->name;
        $config = ComponentManager::constructConfig($component->config);
        $configSettings = ComponentManager::constructConfig($component->config_settings);
        $status = ComponentManager::constructConfig($component->status);

        $capabilities = DB::SELECT("SELECT * FROM capabilities WHERE name LIKE '$name.%' AND deleted_at is NULL");
        $roles = DB::SELECT("SELECT * FROM roles WHERE entity_id = 1 or entity_id = 2");

        $origin = [
            'id'                => $component->id,
            'component_group_id'=> $component_group_id,
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
            'id'                => $component->id,
            'component_group_id'=> $component_group_id,
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

    static function constructConfig($config){
        return json_decode($config, true);
    }

}