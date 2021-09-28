<?php
namespace App\Helpers;

class RoleHelper{

    static function getRoles($values){
        $newValues = [];
        foreach($values as $value){
            $privileges[] = $value->name;
            $newValues['roles'] = $privileges;
            foreach($value->capabilities as $capability){
                $capabilities[] = $capability->name;
                $newValues['capabilities'] = $capabilities;
            }
            
        }
        return $newValues;
    }

    static function getCapabilitiesArray($roles){
        $roles = [];
        $capabilities = [];

        foreach ($roles as $value) {
            if($value){
                $roles[] = $value->name;
                foreach ($value->capabilities as $capability){
                    $capabilities[] = $capability->name;
                }
            }
        };
        return $capabilities;
    }

}
