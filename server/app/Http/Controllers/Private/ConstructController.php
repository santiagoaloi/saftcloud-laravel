<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use App\Models\Root\Component;
use Illuminate\Http\Request;

use App\Http\Controllers\Root\MysqlController;

class ConstructController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function index(Request $request) {
        $query = Component::find($request->id);


        $config = json_decode($query['config']);
        $formFields = $config['formFields'];

        foreach ($formFields as $field) {
            $ArrayColumns[] = [
                'field'  => $field->field
            ];
        };


        $headers[] = $ArrayColumns;

        header('Content-Type: application/json');
        echo json_encode(['status' => true, 'rows' => $query]);
        exit();;
    }

    public function constructTable(){

    }

    public function constructTableFields(){

    }
}
