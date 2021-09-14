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

        // str_replace('SELECT', 'SELECT count(*) as temp, ', $sql_query);
        $query = "SELECT * FROM capabilities WHERE name LIKE '$name.%'";
        $capabilities = DB::SELECT($query);

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
            'capabilities'      => $capabilities
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
            'capabilities'      => $capabilities
        ];
        return $result;
    }

    static function constructConfig($config){
        return json_decode($config, true);
    }

}