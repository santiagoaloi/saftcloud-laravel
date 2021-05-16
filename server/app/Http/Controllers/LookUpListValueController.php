<?php

namespace App\Http\Controllers;

use App\Models\GeneralConfig\LookUpListValue;
use Illuminate\Http\Request;

class LookUpListValueController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GeneralConfig\LookUpListValue  $lookUpListValue
     * @return \Illuminate\Http\Response
     */
    public function show($lookUpListValue) {
        $query = LookUpListValue::get();

        header('Content-Type: application/json');
        echo json_encode(['status' => true, 'rows' => $query]);
        exit();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GeneralConfig\LookUpListValue  $lookUpListValue
     * @return \Illuminate\Http\Response
     */
    public function showAll() {
        $query = LookUpListValue::get();

        header('Content-Type: application/json');
        echo json_encode(['status' => true, 'rows' => $query]);
        exit();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GeneralConfig\LookUpListValue  $lookUpListValue
     * @return \Illuminate\Http\Response
     */
    public function edit(LookUpListValue $lookUpListValue) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GeneralConfig\LookUpListValue  $lookUpListValue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LookUpListValue $lookUpListValue) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GeneralConfig\LookUpListValue  $lookUpListValue
     * @return \Illuminate\Http\Response
     */
    public function destroy(LookUpListValue $lookUpListValue) {
        //
    }
}
