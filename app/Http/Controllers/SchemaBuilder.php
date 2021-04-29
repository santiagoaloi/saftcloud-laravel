<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class SchemaBuilder extends Controller {
    public function getTableColumns($table) {

        $result = array_fill_keys(DB::getSchemaBuilder()->getColumnListing($table), '');

        header('Content-Type: application/json');
        echo json_encode(['status' => 'Success', 'message' => 'testeo', 'rows' => $result]);exit();
    }
}
