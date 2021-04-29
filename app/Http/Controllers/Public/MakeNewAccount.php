<?php

namespace App\Http\Controllers\Public;
use App\Models\Public\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MakeNewAccount extends Controller {
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request) {
        $account = new Account;
        $account->create($request->all());

        header('Content-Type: application/json');
        echo json_encode(['status' => 'Success', 'message' => 'testeo']);exit();
    }
}
