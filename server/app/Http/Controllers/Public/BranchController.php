<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Public\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller {
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $query = Branch::get();

        header('Content-Type: application/json');
        echo json_encode(['status' => true, 'rows' => $query]);
        exit();
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAll() {
        $query = Branch::get();

        header('Content-Type: application/json');
        echo json_encode(['status' => true, 'rows' => $query]);
        exit();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Public\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Public\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch) {
        //
    }
}
