<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Public\Country;

class CountryController extends Controller {
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
     * @param  \App\Models\Public\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Public\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function showAll(Country $country) {
        $query = Country::get();

        header('Content-Type: application/json');
        echo json_encode(['status' => true, 'rows' => $query]);
        exit();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Public\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Public\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Public\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }
}
