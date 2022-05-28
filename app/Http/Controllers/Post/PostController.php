<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post\Post;
use function view;


class PostController extends Controller
{

    public function index($post_id)
    {
        $Post = Post::getPost($post_id);
        if($Post) {
            return view('post', [
                'post' => $Post
            ]);
        } else {
            return view('components.error.404');
        }
    }

}
