<?php

namespace App\Http\Controllers\GeneralConfig;

use App\Http\Controllers\Controller;
use App\Models\GeneralConfig\LookUpList;
use Illuminate\Http\Request;

class LookUpListController extends Controller {
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
     * @param  \App\Models\GeneralConfig\LookUpList  $lookUpList
     * @return \Illuminate\Http\Response
     */
    public function show(LookUpList $id) {
        return response([
            'row'=> LookUpList::findOrFail($id),
            'status'    => true
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GeneralConfig\LookUpList  $lookUpList
     * @return \Illuminate\Http\Response
     */
    public function edit(LookUpList $lookUpList) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GeneralConfig\LookUpList  $lookUpList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LookUpList $lookUpList) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GeneralConfig\LookUpList  $lookUpList
     * @return \Illuminate\Http\Response
     */
    public function destroy(LookUpList $lookUpList) {
        //
    }
}
