<?php

namespace App\Http\Controllers\Public;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Private\Branch;
use App\Models\Private\RootAccount;

class MakeAccountController extends Controller {

    public function accountCreation(Request $request) {
        $postdata = json_decode($request->getContent(), true);

        try{
            // CREACION DE CUENTA
            $account = RootAccount::create([
                'license'           => rand(0,300),
                'account_plan_id'   => 1,
                'payment_status'    => 1,
                'email'             => $postdata['email'],
                'document_type_id'  => 6,
                'name'              => $postdata['companyName'],
            ]);

            // // CREACION DE EMPRESA
            $entity = $account->entity()->create([
                'entity_type_id'    => 1,
                'first_name'        => $postdata['companyName'],
                'last_name'         => $postdata['companyNameAlias'],
                'iva_condition_id'  => 5,
                'document_type_id'  => 6
            ]);

            // CREACION DE PERSONA
            $person = $account->entity()->create([
                'entity_type_id'    => 2,
                'first_name'        => $postdata['name'],
                'last_name'         => $postdata['lastname'],
                'iva_condition_id'  => 5,
                'document_type_id'  => 6
            ]);

            // CREACION DE SUCURSAL
            $branch = $entity->branch()->create([
                'email'     => $postdata['email'],
                'name'      => 'example branch'
            ]);

            // CREACION DE PUNTO DE VENTA
            $branch->pointOfSale()->create([
                'ptoVta'                => 1,
                'look_up_list_value_id' => 44,
                'name'                  => 'caja 1',
                'status'                => 1,
            ]);

            // CREACION DE USUARIO
            $user = $person->user()->create([
                'role_id'               =>  2,
                'email'                 =>  $postdata['email'],
                'password'              =>  bcrypt('password')
            ]);

            // CREACION DE CONFIGURACION DE USUARIO
            $user->userSetting()->create([
                'default_branch'    =>  $branch->id
            ]);

            $this->attachBranch($user, $branch);
            $this->attachRole($user);

            $selectedViews = $postdata['selectedViews'];
            $this->attachModuleToAccount($account, $selectedViews);
            $this->attachModuleToBranch($branch, $selectedViews);
        }

        catch(QueryException $e){
            if($e->errorInfo[1]){
                return response([
                    'message'=> $e->errorInfo[2],
                    'code'=> $e->errorInfo[1]
                ], 404);
            }
        }

        return response([
            'status' => 'Success',
            'message' => 'testeo'
        ], 200);
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attachBranch(User $user, $branch){
        $user->branch()->attach($branch);
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attachRole(User $user){
        $user->role()->attach(2);
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attachModuleToAccount(RootAccount $account, $module){
        $account->module()->attach($module);
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attachModuleToBranch(Branch $branch, $module){
        $branch->module()->attach($module);
    }
}
