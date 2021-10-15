<?php
use Illuminate\Support\Facades\DB;

function origin($request){
    return $request->origin = clone$request;
}

function blend($filePath, $data){
    foreach($data as $k=>$v){
        $key[] = "{".$k."}";
        $value[] = $v;
    }
    $fileContent = str_ireplace($key, $value, $filePath);
    return $fileContent;
}

function compareItems($item, $model){
    $result = [];
    foreach($model as $k => $v) {
        if(!isset($item[$k])) {
            $result[$k] = $v;
        } else if (isset($item[$k]) && !is_array($item[$k]) && is_array($v)) {
            $result[$k] = $v;
        } else if (isset($item[$k]) && is_array($item[$k]) && !is_array($v)) {
            $result[$k] = $v;
        } else if (isset($item[$k]) && is_array($item[$k]) && is_array($v)) {
            $newVal = [];
            foreach($v as $subKey => $val) {
                if(is_array($val)){
                    $test = compareItems($item[$k][$subKey], $val);
                    $newVal[$subKey] = $test;
                } else if (!is_array($val) && !isset($item[$k][$subKey])){
                    $newVal[$subKey] = $model[$k][$subKey];
                } else {
                    $newVal[$subKey] = $item[$k][$subKey];
                }
            } $result[$k] = $newVal;
        } else {
            $result[$k] = $item[$k];
        }
    }
    return $result;
}

function oldCompareItems($item, $model){
    $result = array("more"=>array(),"less"=>array(),"diff"=>array());
    foreach($model as $k => $v) {
        if(is_array($v) && isset($item[$k]) && is_array($item[$k])) {
            $sub_result = oldCompareItems($v, $item[$k]);
            //merge results
            foreach(array_keys($sub_result) as $key) {
                if(!empty($sub_result[$key])) {
                    $result[$key] = array_merge_recursive($result[$key],array($k => $sub_result[$key]));
                }
            }
        } else {
            if(isset($item[$k])) {
                if($v !== $item[$k]) {
                    $result["diff"][$k] = array("from"=>$v,"to"=>$item[$k]);
                }
            } else {
                $result["more"][$k] = $v;
            }
        }
    }
    foreach($item as $k => $v) {
        if(!isset($model[$k])) {
            $result["less"][$k] = $v;
        }
    }
    return $result;
}

function getEachTable($string){
    if (str_contains($string, ',')){
        $string = explode(',', $string);
    }
    if(is_object($string)){
        foreach ($string as $item){
            $columns = getColumnsFromString($item);
        }
    } else {
        $columns = getColumnsFromString($string);
    }
    return $columns;
}

function getColumnsFromString($item){
    return $item;
    $item = trim($item);
    $column = after('.', $item);
    if($column == '*'){
        $table = before('.', $item);
        $arrayColumns = getAllColumnsFromTable($table);
        foreach($arrayColumns as $item){
            $columns[] = $item;
        }
    } else {
        $columns[] = $column;
    }
    return $columns;
}

function getAllColumnsFromTable($table){
    $query = DB::select("SELECT COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_SCHEMA = 'laravel_vue' AND TABLE_NAME = '$table'");
    foreach($query as $key => $value){
        $columns[] = $value->COLUMN_NAME;
    }
    return $columns;
}

function getStringBetween($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return trim(substr($string, $ini, $len));
}

//** CUT A STRING RETURING THE STRING AFTER SPECIFIED CHARACTER **//
function after ($string, $inthat){
    if (!is_bool(strpos($inthat, $string)))
    return substr($inthat, strpos($inthat,$string)+strlen($string));
}

function before($string, $inthat){
    return substr($inthat, 0, strpos($inthat, $string));
}
