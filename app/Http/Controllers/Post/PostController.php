<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function view;


class PostController extends Controller
{

    public function index($id)
    {
        $Post = Post::getPost($id);
        if($Post) {
            return view('post', [
                'post' => $Post
            ]);
        } else {
            return view('components.error.404');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $editor = ['blocks' => [ ['id' => 'first', 'type' => 'header', 'data' => ['text' => 'New draft', 'level' => 1]], ['id' => 'first1', 'type' => 'paragraph', 'data' => ['text' => 'Insert some text...']]]];

        return view('editor', [
            'editor' => $editor
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        $editor = ['blocks' => [ ['id' => 'first', 'type' => 'header', 'data' => ['text' => 'New draft', 'level' => 1]], ['id' => 'first1', 'type' => 'paragraph', 'data' => ['text' => 'Insert some text...']]]];
        if($id) {
            $Post = Post::getPost($id);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $_POST['data'] = str_replace('\\', '', $_POST['data']);
        $data = json_decode($_POST['data'], true);
        if(!$id) {
            $id = Post::create();
        }
        $Post = Post::getPost($id);
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
            } else {
                $Post->update_post('status', 'draft');
            }
        }

        return $_POST['data'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
