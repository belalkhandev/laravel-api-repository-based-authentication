<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Auth\AuthInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $auth;

    public function __construct(AuthInterface $auth)
    {
        $this->auth = $auth;
    }

    public function register(Request $request)
    {
        //set validation rules
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ];

        //make validation
        $validation = Validator::make($request->all(), $rules);

        //check validation
        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validation->errors()
            ]);
        }

        return $this->auth->register($request);

    }

    public function login(Request $request)
    {
        //set validation rules
        $rules = [
            'email' => 'required',
            'password' => 'required',
        ];

        //make validation
        $validation = Validator::make($request->all(), $rules);

        //check validation
        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validation->errors()
            ]);
        }

        return $this->auth->login($request);
    }


    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->AauthAcessToken()->delete();
        }

        return response()->json([
            'status' => true,
            'message' => 'Successfully logged out'
        ]);
    }
}
