<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index($user_id)
    {
        $User = User::findOrFail($user_id);
        if($User) {
            return view('profile', ['user_id' => $user_id]);
        } else {
            return view('components.error.404');
        }
    }
}
