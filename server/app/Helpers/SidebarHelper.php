<?php

function modulesBuilder($roles){
    foreach($roles as $role){
        $modules = $role->module;
        $result = [];
        foreach($modules as $module){
            if(json_decode($module['config'])->general_config->isVisibleInSidebar && $module['deleted_at'] == NULL){
                $result[] = [
                    'id'                =>$module['id'],
                    'name'              =>$module['name'],
                    'module_group_id'   =>$module['module_group_id'],
                    'title'             =>json_decode($module['config'])->general_config->title,
                    'icon'              =>json_decode($module['config_settings'])->icon->name,
                    'link'              =>'/'.$module['name'],
                ];
            }
        }
    }
    // return array_unique(array_column($result, 'id'));
    return super_unique($result, 'id');

            /// FORMA VIEJA ->>> BORRAR
            //     $modules2 = DB::select("SELECT name, JSON_EXTRACT(config, '$.general_config.title') as title, 
            //     JSON_EXTRACT(config, '$.general_config.isVisibleInSidebar') as isVisibleInSidebar, 
            //     JSON_EXTRACT(config_settings, '$.icon.name') as icon, 
            //     module_group_id 
            //     FROM modules 
            //     where deleted_at is NULL HAVING isVisibleInSidebar = true"
            // );

            // if(!empty($modules)){
            //     foreach($modules as $tes => $val){
            //         $icon = str_replace('"', "", $val->icon);
            //         $url = '/'.$val->name;
            //         $title = str_replace('"', "", $val->title);
            //         $modules[$tes]['title'] = $title;
            //         $modules[$tes]['icon'] = $icon;
            //         $modules[$tes]['link'] = $url;
            //         $modules[$tes]['module_group_id'] = $val->module_group_id;
            //     }
            // }
}

function parentbuilder($parents, $childs, $modules){
    $array = [];
    foreach($parents as $parent){
        if(!empty($modules)){
            foreach($modules as $module){
                if($parent->id == $module['module_group_id']){
                    $parent->items[] = $module;
                }
            }
            if(isset($childs)){
                foreach($childs as $child){
                    if($parent->id === $child->module_group_id){
                        if(isset($modules)){
                            foreach($modules as $module){
                                if($child->id === $module['module_group_id']){
                                    $child->items[] = $module;
                                }
                            }
                        }
                        if(isset($child->items)){
                            $parent->items[] = $child;
                        }
                    }
                }
            }
        }

        if(isset($parent->items)){
            $array['menu'][]['items'][] = $parent;
        }
    }
    return $array;
}

function super_unique($array,$key) {
    $temp_array = [];
    foreach ($array as &$v) {
        if (!isset($temp_array[$v[$key]]))
        $temp_array[$v[$key]] =& $v;
    }
    $array = array_values($temp_array);
    return $array;
}
