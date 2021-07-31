<?php
namespace App\Repositories\User;

interface UserInterface{
    public function get($id);

    public function all();
}
