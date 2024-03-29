<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\Roles\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Private\UserController;

class AuthController extends Controller {

    public function pepe(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $remember = $request->filled('remember');

        if(Auth::attempt($credentials, $remember)){
            $user = User::where('email', $credentials['email'])->first();
            $token = $user->createToken($credentials['email'], ['module.show'])->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token
            ];

            return response([
                'data' => $response
            ], 200);
        }

        throw ValidationException::withMessages([
            'email'=> __('auth.failed')
        ]);
        // throw new AuthenticationException();
    }

    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password'])
        ]);

        $response = [
            'user' => $user
        ];

        return response($response, 201);
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = User::where('email', $credentials['email'])->first();
            $token = $user->createToken($user['email'], ['module.show'])->plainTextToken;

            $user->userSetting;
            $user->entity;
            $user->branch[0]->entity;
            // $UserController = New UserController;
            $user->privileges = getRolCapabilities($user);
            $user->origin = clone$user;

            // $user['test'] = collect($user->role)->pluck("module");

            // foreach($user->role as $role){
            //     $user['modules'] = $role->module;
            // }

            $roles = $user->role;
            foreach($roles as $role){
                $modules = $role->module;
                $arr = [];
                foreach($modules as $module){
                    $arr[] = $module->name;
                };
                $user['modules'] = $arr;
            };

            return response([
                'user' => $user,
                'token' => $token,
                'status' => true
            ], 200);
        }

        return response([
            'message' => 'Invalid Credentials',
            'status' => false
        ], 401);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        // Auth::logout();        
        // Auth::guard('web')->logout();

        return [
            'message' => 'Logged out',
            'status' => true
        ];
    }

}
