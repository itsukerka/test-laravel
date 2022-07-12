<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function view;


class PostController extends Controller
{

    public function index($id)
    {
        $Post = Post::get($id);
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
     */
    public function store(Request $request)
    {
        $_POST['data'] = str_replace('\\', '', $_POST['data']);
        $data = json_decode($_POST['data'], true);
        $title = $data['blocks'][0]['data']['text'];
        $excerpt = $data['blocks'][1]['data']['text'];
        $slug = Post::slugify($title);

        $id = DB::table('posts')
            ->insertGetId(
                ['author_id' => Auth::user()->id,
                    'status' => 'draft',
                    'created_at' =>  \Carbon\Carbon::now(),
                    'title' => $title,
                    'excerpt' => $excerpt,
                    'slug'=> $slug],
            );
        DB::table('post_metas')
            ->updateOrInsert(
                ['meta_key' => 'post_content', 'post_id' => $id],
                ['meta_value' => json_encode($data, JSON_UNESCAPED_UNICODE)]
            );
        if(isset($_POST['status']) AND Auth::user()->role == 'admin'){
            DB::table('posts')
                ->where('post_id', $id)
                ->update(['status' => strval($_POST['status'])]);
        } else {
            DB::table('posts')
                ->where('post_id', $id)
                ->update(['status' => 'draft']);
        }

        return $id;
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
            $Post = Post::get($id);
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

        $Post = Post::get($id);
        //Проверяем существует ли запись и есть ли право на редактирование
        if($Post AND $Post->canEdit()) {
            $title = $data['blocks'][0]['data']['text'];
            $excerpt = $data['blocks'][1]['data']['text'];

            DB::table('posts')
                ->where('post_id', $id)
                ->update(['title' => $title, 'excerpt' => $excerpt]);

            DB::table('post_metas')
                ->updateOrInsert(
                    ['meta_key' => 'post_content', 'post_id' => $id],
                    ['meta_value' => json_encode($data, JSON_UNESCAPED_UNICODE)]
                );
            if(isset($_POST['status']) AND Auth::user()->role == 'admin'){
                DB::table('posts')
                    ->where('post_id', $id)
                    ->update(['status' => strval($_POST['status'])]);
            } else {
                DB::table('posts')
                    ->where('post_id', $id)
                    ->update(['status' => 'draft']);
            }
        }

        return $id;
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
