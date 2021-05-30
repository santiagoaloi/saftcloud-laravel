<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use App\Models\Root\Component;
use Illuminate\Http\Request;

class ConstructController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function index(Request $request) {
        $query = Component::find($request->id);

        header('Content-Type: application/json');
        echo json_encode(['status' => true, 'rows' => $query]);
        exit();;
    }
}
