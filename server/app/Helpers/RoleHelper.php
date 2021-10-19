<?php

function getRoles($values){
    $newValues = [];
    $newValues['roles'] = [];
    $newValues['capabilities'] = [];
    if(COUNT($values) > 0){
        foreach($values as $value){
            $privileges[] = $value->name;
            $newValues['roles'] = $privileges;
            foreach($value->capability as $capability){
                $capabilities[] = $capability->name;
                $newValues['capabilities'] = $capabilities;
            }
        }
    }
    return $newValues;
}

function getCapabilitiesArray($roles){
    $roles = [];
    $capabilities = [];
    foreach ($roles as $value) {
        if($value){
            $roles[] = $value->name;
            foreach ($value->capability as $capability){
                $capabilities[] = $capability->name;
            }
        }
    };
    return $capabilities;
}
