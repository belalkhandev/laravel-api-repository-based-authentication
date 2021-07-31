<?php
namespace App\Repositories\User;

use App\User;

class UserRepository implements UserInterface{
    public  function get($id)
    {
        return User::find($id);
    }

    public function all()
    {
        return User::all();
    }
}
