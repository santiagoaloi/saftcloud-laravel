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
            'client_type'       => 3,
            'account_name'      => $postdata['companyName'],
            'license'           => 1,
            'owner_first_name'  => $postdata['name'],
            'owner_last_name'   => 'poop',
            'email'             => 'pepe@la.com',
            'phone_code'        => $postdata['phone_code'],
            'phone_number'      => $postdata['phoneNumber'],
            'created_at'        => '',
        ]);

        $account_id = $account->id;

        $company = Entity::create([
            'account_id'    => $account_id,
            'first_name'  => $request['companyName'],
            'last_alias' => $request['companyNameAlias'],
            'state'         => $request['state'],
            'city'          => $request['city'],
            'address'       => $request['address'],
        ]);

        $company_id = $company->id;

        $company_branch = Branch::create([
            'company_id'  =>  $company_id,
            'country_id'  =>  $request['country'],
            'state'       =>  $request['state'],
            'city'        =>  $request['city'],
            'address'     =>  $request['address'],
        ]);

        $branch_id = $company_branch->id;

        PointOfSale::create([
            'branch_id' => $branch_id,
            'ptoVta'    => 1,
            'name'      => "caja 1",
            'address'   => $request['address'],
        ]);

        User::create([
            'first_name'               =>  $request['name'],
            'first_name'               =>  $request['name'],
            'last_name'                =>  $request['lastname'],
            'email'                    =>  $request['email'],
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
