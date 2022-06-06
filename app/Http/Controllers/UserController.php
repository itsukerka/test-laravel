<?php

namespace App\Http\Controllers;

use App\Models\User\User;

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

    public function edit($user_id)
    {
        return view('profile.edit', ['user_id' => $user_id]);
    }
    public function update($user_id)
    {
        $_POST['data'] = str_replace('\\', '', $_POST['data']);
        $data = json_decode($_POST['data'], true);
        $User = User::findOrFail($user_id);
        foreach($data as $meta_key => $meta_value){
            if($meta_key !== '_token' AND $meta_key !== 'fullname') {
                $User->update_meta($meta_key, $meta_value);
            }
        }
    }
}
