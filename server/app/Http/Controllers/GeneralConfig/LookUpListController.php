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
        $query = LookUpList::create($request);
        return response([
            'components' => $query,
            'status' => true
        ], 200);
    }

    public function show(LookUpList $id) {
        return response([
            'row'=> LookUpList::findOrFail($id),
            'status'    => true
        ], 200);
    }

    public function edit(LookUpList $lookUpList) {
        //
    }

    public function update(Request $request, LookUpList $lookUpList) {
        //
    }

    public function destroy(LookUpList $lookUpList) {
        $query = Component::findOrFail($id);
        $query->delete();

        return $this->showAll();
    }
}
