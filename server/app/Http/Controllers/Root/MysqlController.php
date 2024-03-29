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

    static function checkTableExistense($table, $table2, $id){
        DB::table($table)->whereExists(function ($query) use ($id, $table2) {
            $query->select(DB::raw(1))
                ->from($table2)
                ->whereRaw("$table2.user_id = $id");   // HAY QUE MODIFICAR user_id PARA QUE SEA DINAMICO
        })->get();

        
        $tables = DB::select("select module_groups.* from module_groups 
        where exists(
            select modules.* from modules where modules.module_group_id = module_groups. id AND modules.module_group_id = 1)");

    }


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
