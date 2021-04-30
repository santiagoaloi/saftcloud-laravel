<?php

namespace App\Http\Controllers\Public;
use App\Models\Public\Account;
use App\Models\Public\Company;
use App\Models\Public\Branch;
use App\Models\Public\PtoVta;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MakeNewAccount extends Controller {
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function accountCreation(Request $request) {
        // $account = new Account;
        // $account->create($request->all());

        $account = Account::create([
            'client_type'       => 3,
            'account_name'      => $request->input('companyName'),
            'owner_name'        => $request->input('name'),
            'owner_lastname'    => $request->input('lastname'),
            'owner_email'       => $request->input('email'),
            'phone_code'        => $request->input('phoneCode'),
            'telephone'         => $request->input('phoneNumber'),
        ]);

        $account_id = $account->id;

        $company = Company::create([
            'account_id'    => $account_id,
            'name'          => $request->input('companyName'),
            'alias'         => $request->input('companyNameAlias'),
            'country_id'    => $request->input('country'),
            'state'         => $request->input('state'),
            'city'          => $request->input('city'),
            'address'       => $request->input('address'),
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

        PtoVta::create([
            'branch_id' => $branch_id,
            'ptoVta'    => 1,
            'name'      => "caja 1",
            'address'   => $request['address'],
        ]);

        User::create([
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
}
