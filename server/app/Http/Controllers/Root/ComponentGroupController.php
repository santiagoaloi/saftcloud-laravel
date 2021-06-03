<?php

namespace App\Http\Controllers\Root;

use App\Http\Controllers\Controller;
use App\Models\Root\ComponentGroup;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ComponentGroupController extends Controller {
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
     * @return \Illuminate\Http\Response $response
     */
    public function store(Request $request) {
        $postdata = json_decode($request->getContent(), true);
        ComponentGroup::create($postdata);

        $getGroups = $this->showAll(true);

        return response([
            'rows' =>  $getGroups,
            'status' => true
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $query = ComponentGroup::findOrFail($id);

        return response([
            'rows' =>  $query,
            'status' => true
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAll($local = false) {
        if ($local){
            return ComponentGroup::get();
        } else {
            $getGroups = ComponentGroup::all();

            return response([
                'rows' =>  $getGroups,
                'status' => true,
            ], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $query = ComponentGroup::findOrFail($id);

        $input = $request->all();

        $query->fill($input)->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $query = ComponentGroup::find($id);
        $query->delete();

        return $this->showAll();
    }
}
