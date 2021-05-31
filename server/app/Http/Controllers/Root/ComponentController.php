<?php

namespace App\Http\Controllers\Root;

use App\Http\Controllers\Controller;
use App\Models\Root\Component;
use Illuminate\Http\Request;

use App\Http\Controllers\Root\MysqlController;

class ComponentController extends Controller {
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

        $json_data['table'] = $request['table'];

        $MysqlController = new MysqlController;
        $columns = $MysqlController->showColumns($request);

        foreach ($columns as $column) {
            $ArrayColumns[] = [
                'name'  =>   $column,
            ];

            $ArrayFields[] = [
                'field'         => $column,
                'displayField'  => true,
            ];
        };

        $componentConfig = [];

<<<<<<< HEAD
        $sql_select = "SELECT {$request['table']}.* FROM {$request['table']}";
        $sql_where  = " WHERE ".$request['table'].". id IS NOT NULL";
        $sql_group  = "";

        $config['sql_table'] = $sql_group;
        $config['columns']   = $ArrayColumns;
        $config['formFields'] = $ArrayFields;
        $config['componentConfig'] = $componentConfig;
        $config['sql_select'] = $sql_select;
        $config['sql_where'] = $sql_where;
        $config['sql_group'] = $sql_group;
=======
        $sql_select = "SELECT {$request['table']}.* FROM {$request['table']} ";
        $sql_where  = " WHERE ".$request['table'].".id IS NOT NULL";
        $sql_group  = "";


        $config['columns']          = $ArrayColumns;
        $config['formFields']       = $ArrayFields;
        $config['componentConfig']  = $componentConfig;
        $config['sql_select']       = $sql_select;
        $config['sql_where']        = $sql_where;
        $config['sql_group']        = $sql_group;
>>>>>>> 156dbd18ae57e7177311765ed86a0d2b15e49f37

        $data = [
        'component_group_id'    => $request['component_group_id'],
        'prev_group_id'         => $request['prev_group_id'],
        'name'                  => $request['name'],
        'title'                 => $request['title'],
        'note'                  => $request['note'],
        'config'                => json_encode($config),
        ];

        Component::create($data);

        $query = $this->showAll(true);

        return response([
            'rows' =>  $query,
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
        $query = Component::find($id);

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
            return Component::get();
        } else {
            $query = Component::get();

            return response([
                'rows' =>  $query,
                'status' => true
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
