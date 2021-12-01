<?php

namespace App\Http\Controllers\Public;
use App\Models\User;
use App\Models\Roles\Role;

use Illuminate\Http\Request;

use App\Models\Private\Branch;
use App\Models\Private\RootAccount;
use App\Http\Controllers\Controller;

class MakeAccountController extends Controller {

    public function accountCreation(Request $request) {
        $postdata = json_decode($request->getContent(), true);

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

        $this->attachBranch($user, $branch);
        $this->attachRole($user);

        $selectedViews = $postdata['selectedViews'];
        $this->attachComponentToAccount($account, $selectedViews);
        $this->attachComponentToBranch($branch, $selectedViews);

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
    public function attachComponentToAccount(RootAccount $account, $component){
        $account->component()->attach($component);
    }

    // AGREGA TODOS LOS ITEMS QUE ENVIAMOS EN LA VARIABLE request
    public function attachComponentToBranch(Branch $branch, $component){
        $branch->component()->attach($component);
    }
}
