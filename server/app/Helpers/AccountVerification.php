<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class AccountVerification {

    static function checkRootRole(){
        if(in_array('Root', RoleHelper::getRoles(Auth::user()->roles)['roles'])){
            return true;
        }
        return false;
    }

}
