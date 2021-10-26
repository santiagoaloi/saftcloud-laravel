<?php

namespace App\Http\Middleware;
use App\Helpers\AccountVerification;

use Closure;
use Illuminate\Http\Request;

class AccountVerificationMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {
        if(AccountVerification::checkRootRole())
        return $next($request);
    }
}
