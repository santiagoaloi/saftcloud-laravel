<?php

namespace App\Http\Controllers\Private;
use App\Models\Private\Account;
use App\Models\Private\Entity;
use App\Models\Private\Branch;
use App\Models\Private\PointOfSale;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MakeAccountController extends Controller {
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function accountCreation(Request $request) {

        $postdata = json_decode($request->getContent(), true);

        $account = Account::create([
            'license'           => 1,
            'plane'             => 3,
            'name'              => $postdata['companyName'],
            'email'             => 'pepe@la.com',
            'payment_status'    => 1,
            'owner_first_name'  => $postdata['name'],
            'owner_last_name'   => 'poop',
            'phone_code'        => $postdata['phone_code'],
            'phone_number'      => $postdata['phoneNumber'],
        ]);

        $account_id = $account->id;

        $entity = Entity::create([
            'account_id'    => $account_id,
            'entity_type_id'=> 1,
            'first_name'    => $request['companyName'],
            'last_name'     => $request['companyNameAlias'],
            'state'         => $request['state'],
            'city'          => $request['city'],
            'address'       => $request['address'],
        ]);

        $entity_id = $entity->id;

        $company_branch = Branch::create([
            'entity_id'   =>  $entity_id,
        ]);

        $branch_id = $company_branch->id;

        PointOfSale::create([
            'branch_id'             => $branch_id,
            'ptoVta'                => 1,
            'look_up_list_value_id' => 39,
            'name'                  => 'caja 1',
        ]);

        User::create([
            'entity_id'             =>  $entity_id,
            'role_id'               =>  2,
            'email'                 =>  $request['email'],
            'password'              =>  $request['password'],
        ]);

        header('Content-Type: application/json');
        echo json_encode(['status' => 'Success', 'message' => 'testeo']);exit();
    }

    public function test(){
        $users = DB::table('u_look_up_list')
            ->leftJoin('u_look_up_list_value', 'u_look_up_list.id', '=', 'u_look_up_list_value.lookUpList_id')
            ->where('u_look_up_list_value.id', '=', 2)
            ->get();

            header('Content-Type: application/json');
            echo json_encode(['status' => 'Success', 'rows' => $users]);exit();
    }

    public function test2(){
        return $this;
    }
}
