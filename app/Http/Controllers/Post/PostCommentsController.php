<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $comments = Comment::select('*')
            ->where(['post_id', $id])
            ->where(['parent', NULL]);
        return view('components.comment.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('components.comment.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request, $id)
    {
        $validated = $request->validated();
        $parent = NULL;
        if($validated->has('parent')){
            $parent = $validated->get('parent');
        }

        $id = DB::table('comments')
            ->insertGetId(
                ['author_id' => Auth::user()->id,
                    'status' => 'pending',
                    'created_at' =>  \Carbon\Carbon::now(),
                    'content' => $validated->get('content'),
                    'parent' => $parent],
            );

        if(Auth::user()->role == 'admin'){
            DB::table('comments')
                ->where('id', $id)
                ->update(['status' => 'publish']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $comment_id
     */
    public function show($comment_id)
    {
        $comment = Comment::find($comment_id);
        return view('components.comment.show', compact('comment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $comment_id
     */
    public function edit($comment_id)
    {
        $comment = Comment::find($comment_id);
        if($comment->canEdit()) {
            return view('components.comment.edit', compact('comment'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CommentRequest  $request
     * @param  int  $comment_id
     * @return \Illuminate\Http\Response
     */
    public function update(CommentRequest $request, $comment_id)
    {
        $validated = $request->validated();

        DB::table('comments')
            ->where('id', $comment_id)
            ->update(['content' => $validated->get('content')]);

        if(Auth::user()->role != 'admin'){
            DB::table('comments')
                ->where('id', $comment_id)
                ->update(['status' => 'pending']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $comment_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($comment_id)
    {
        DB::table('comments')
            ->where('id', $comment_id)
            ->update(['status' => 'delete']);
    }
}
