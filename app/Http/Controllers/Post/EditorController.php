<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post\Post;
use Illuminate\Support\Facades\Auth;

class EditorController extends Controller
{
    public function save($post_id = false){
        $_POST['data'] = str_replace('\\', '', $_POST['data']);
        $data = json_decode($_POST['data'], true);
        if(!$post_id) {
            $post_id = Post::create();
        }
        $Post = Post::getPost($post_id);
        //Проверяем существует ли запись и есть ли право на редактирование
        if($Post AND $Post->canEdit()) {
            $title = $data['blocks'][0]['data']['text'];
            $excerpt = $data['blocks'][1]['data']['text'];
            $Post->update_post('title', $title);
            $Post->update_post('excerpt', $excerpt);
            $Post->update_post('slug', strtolower(str_replace(' ', '-', $title)));
            $Post->update_meta('post_content', json_encode($data, JSON_UNESCAPED_UNICODE));
            if(isset($_POST['status']) AND Auth::user()->role == 'admin'){
                $Post->update_post('status', strval($_POST['status']));
            }
        }

        return $_POST['data'];
    }
    public function index($post_id = false)
    {
        $editor = ['blocks' => [ ['id' => 'first', 'type' => 'header', 'data' => ['text' => 'New draft', 'level' => 1]], ['id' => 'first1', 'type' => 'paragraph', 'data' => ['text' => 'Insert some text...']]]];
        if($post_id) {
            $Post = Post::getPost($post_id);
            //Проверяем существует ли запись и есть ли право на редактирование
            if($Post AND $Post->canEdit()) {
                $editor = $Post->content;
                if (!is_array($editor)) {
                    $editor = ['blocks' => [ ['id' => 'first', 'type' => 'header', 'data' => ['text' => $Post->title, 'level' => 1]], ['id' => 'first1', 'type' => 'paragraph', 'data' => ['text' => $Post->excerpt]], ['id' => 'second', 'type' => 'paragraph', 'data' => ['text' => $Post->content]]]];
                }
            } else {
                return view('components.error.404');
            }
        }

        return view('editor', [
            'editor' => $editor
        ]);
    }
}
