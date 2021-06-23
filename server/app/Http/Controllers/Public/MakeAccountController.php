<?php

namespace App\Http\Controllers\Public;
use App\Models\Private\Account;
use App\Models\Private\Entity;
use App\Models\Private\Branch;
use App\Models\Private\PointOfSale;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MakeAccountController extends Controller {

    public function accountCreation(Request $request) {
        $postdata = json_decode($request->getContent(), true);

        // CREACION DE CUENTA
        $account = Account::create([
            'license'           => rand(0,300),
            'account_plan_id'   => 1,
            'name'              => $postdata['companyName'],
            'email'             => $postdata['email'],
            'payment_status'    => 1,
        ]);

        $account_id = $account->id;

        // CREACION DE EMPRESA
        $entity = Entity::create([
            'account_id'    => $account_id,
            'entity_type_id'=> 1,
            'first_name'    => $postdata['companyName'],
            'last_name'     => $postdata['companyNameAlias'],
        ]);

        $entity_id = $entity->id;

        // CREACION DE PERSONA
        $person = Entity::create([
            'account_id'    => $account_id,
            'entity_type_id'=> 2,
            'first_name'    => $postdata['name'],
            'last_name'     => $postdata['lastname'],
        ]);

        $person_id = $person->id;

        // CREACION DE SUCURSAL
        $company_branch = Branch::create([
            'entity_id'   =>  $entity_id,
        ]);

        $branch_id = $company_branch->id;

        // CREACION DE PUNTO DE VENTA
        PointOfSale::create([
            'branch_id'             => $branch_id,
            'ptoVta'                => 1,
            'look_up_list_value_id' => 44,
            'name'                  => 'caja 1',
            'status'                => 1,
        ]);

        // CREACION DE USUARIO
        User::create([
            'entity_id'             =>  $person_id,
            'role_id'               =>  2,
            'email'                 =>  $postdata['email'],
            'password'              =>  bcrypt('password')
        ]);

        header('Content-Type: application/json');
        echo json_encode(['status' => 'Success', 'message' => 'testeo']);exit();
    }

}
