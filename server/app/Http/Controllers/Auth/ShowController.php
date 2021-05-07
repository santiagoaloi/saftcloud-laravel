<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowController extends Controller {
    public function showuser(Request $request){
        return  $request->user();
    }
}
