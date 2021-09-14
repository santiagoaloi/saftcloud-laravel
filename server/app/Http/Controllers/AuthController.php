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
            $token = $user->createToken($credentials['email'], ['component.show'])->plainTextToken;

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
            $token = $user->createToken($user['email'], ['component.show'])->plainTextToken;

            $user->userSettings;
            $user->entity;
            $user->branches[0]->entity;
            $UserController = New UserController;
            $user->privileges = $UserController->getRolCapabilities($user);

            // $roles = DB::table('roles')
            // ->leftJoin('model_has_roles', 'permissions.id', '=', 'permissions.lookUpList_id')
            // ->where('model_has_roles.model_id', '=', $user->id)
            // ->get();

            // $users = DB::table('permissions')
            // ->leftJoin('roles', 'permissions.id', '=', 'permissions.lookUpList_id')
            // ->where('u_look_up_list_value.id', '=', 2)
            // ->get();

            // $role = Role::where('id', $user)->get();
            // // $user->getAllPermissions();

            $response = [
                'user' => $user,
                'token' => $token
            ];

            return response([
                'data' => $response
            ], 200);
        }

        return response([
            'message' => 'Invalid Credentials',
            'status' => false
        ], 401);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        Auth::logout();

        return [
            'message' => 'Logged out',
            'status' => true
        ];
    }

}
