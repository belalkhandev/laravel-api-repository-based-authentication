<?php
namespace App\Repositories\User;

use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User as ResourceUser;

class UserRepository implements UserInterface{

    public  function authUser()
    {
        if ($this->guard()->check()) {
            return response()->json([
                'status' => true,
                'user' => ResourceUser::make($this->guard()->user())
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Unauthorized'
        ], 401);

    }

    public function all()
    {
        if ($this->guard()->check()) {
            return response()->json([
                'status' => true,
                'users' => ResourceUser::collection(User::where('id', '!=', $this->guard()->user()->id)->get())
            ]);
        }
    }

    public function guard()
    {
        return Auth::guard('api');
    }
}
