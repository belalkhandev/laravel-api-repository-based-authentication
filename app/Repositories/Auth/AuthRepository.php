<?php
namespace App\Repositories\Auth;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User as ResourceUser;

class AuthRepository implements AuthInterface{

    public  function login($request)
    {
        $credentials = $request->only('email', 'password');

        if ($authorized = Auth::guard()->attempt($credentials)) {
            $user = Auth::guard()->user();

            if ($user) {
                $token = $user->createToken('laravue')->accessToken;

                return response()->json([
                    'status' => true,
                    'message' => 'Logged in successfully',
                    'user' => ResourceUser::make($user),
                    'token' => $token
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to Login, Invalid credentials',
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Failed to login, Invalid credentials'
            ]);
        }
    }

    public function register($request)
    {
        //register new user
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->birthdate = $request->input('birthdate') ? Carbon::parse($request->input('birthdate'))->format('Y-m-d') : null;
        $user->password = app('hash')->make($request->input('password'));

        if ($user->save()) {
            $token = $user->createToken('laravue')->accessToken;

            return response()->json([
                'status' => true,
                'message' => 'User Registered Successfully',
                'user' => ResourceUser::make($user),
                'token' => $token
            ]);
        }

        return false;
    }
}
