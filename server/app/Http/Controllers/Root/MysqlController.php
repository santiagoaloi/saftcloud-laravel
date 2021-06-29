<?php

namespace App\Http\Controllers\Root;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class MysqlController extends Controller {
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    public function showAll(){
        $tables = DB::select('SHOW TABLES');
        $tables = array_map('current',$tables);

        return $tables;
    }

    public function showColumns($table) {
        return DB::getSchemaBuilder()->getColumnListing($table);
    }

    function showAllTablesAndColumns(){
        $tables = DB::select("select table_name from information_schema.tables where table_schema = 'laravel_vue'");
        foreach($tables as $table){
            $table_name = $table->table_name;
            $columns = DB::select("select column_name from information_schema.columns where table_schema = 'laravel_vue' and table_name = '$table_name'");
            foreach($columns as $column){
                $column_name[] = $column->column_name;
            }
            $tableArray[$table_name] = $column_name;
            $column_name = [];
        }

        return response([
            'tableAndColumns'=> $tableArray,
            'status'    => true
        ], 200);
    }

    function showColumnsFromQuery($request) {
        foreach($request as $key => $value){
            $result[] = $value->column_name;
        };
        return  $result;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }
}
