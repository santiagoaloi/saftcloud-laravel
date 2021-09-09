<?php
namespace App\Helpers;

class ComponentManager {

    static function parseComponent($component){
        $component_group_id = $component->component_group_id;
        $name = $component->name;
        $config = ComponentManager::constructConfig($component->config);
        $configSettings = ComponentManager::constructConfig($component->config_settings);
        $status = ComponentManager::constructConfig($component->status);

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
        ];
        return $result;
    }

    static function constructConfig($config){
        return json_decode($config, true);
    }

}