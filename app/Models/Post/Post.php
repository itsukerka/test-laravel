<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @property mixed $id
 * @property mixed $post_id
 * @property mixed $author_id
 * @property mixed $created_at
 * @property mixed $post_content
 * @property mixed $status
 * @property mixed $title
 * @property mixed $slug
 * @property mixed $content
 */
class Post extends Model
{
    use HasFactory;
    protected $primaryKey = "post_id";

    //
    // Получаем запись с контентом по его ID
    //

    public static function getPost($post_id)
    {
        $post_data = false;
        $query = Post::find($post_id);
        if($query){
            $post_data = $query;

            // Если статья принадлежит юзеру или юзер админ – возвращаем статью
            if($post_data->status != 'publish' AND !Auth::id()) {
                return false;
            }
            if ($post_data->status != 'publish' AND (Auth::id() != $post_data->author_id OR Auth::user()->role != 'admin')) {
                return false;
            }

            $get_content = (new Post)->get_meta(['post_id' => $post_id, 'meta_key' => 'post_content']);
            $post_content = json_decode($get_content, true);
            if(!is_array($post_content)){
                $post_content = $get_content;
            }
            $post_data->content = $post_content;
        }

        return $post_data;
    }

    //
    // Получаем значение метаполя по ID поста и ключу
    //
    public function get_meta($args = []): string
    {
        if(!isset($args['post_id'])){
            $args['post_id'] = $this->post_id;
        }
        $query = PostMeta::select('post_metas.*')
            ->where('post_id', '=', $args['post_id'])
            ->where('meta_key', '=', $args['meta_key'])
            ->paginate(1)->first();
        $result = '';
        if($query){
            $result = $query->meta_value;
        }

        return $result;
    }

    public function meta($key, $post_id = false): string
    {
        if(!$post_id){
            $post_id = $this->post_id;
        }
        $query = PostMeta::select('post_metas.*')
            ->where('post_id', '=', $post_id)
            ->where('meta_key', '=', $key)
            ->paginate(1)->first();
        $result = '';
        if($query){
            $result = $query->meta_value;
        }

        return $result;
    }

    public function update_meta($key, $value){
        DB::table('post_metas')
            ->updateOrInsert(
                ['meta_key' => $key, 'post_id' => $this->post_id],
                ['meta_value' => $value]
            );
    }

    public function update_post($key, $value){
        DB::table('posts')
            ->where('post_id', $this->post_id)
            ->update([$key => $value]);
    }

    //
    // Запрос на получение записей по параметрам
    //
    public static function get($args = []) {
        $status = 'publish';
        $posts_per_page = 15;

        if(isset($args['status'])){
            $status = $args['status'];
        }


        if(isset($args['posts_per_page'])){
            $posts_per_page = $args['posts_per_page'];
        }

        return Post::where('status', $status)
            ->when(isset($args['post_author']), function ($query) use ($args) {
                $query->where('author_id', $args['post_author']);
            })
            ->latest()
            ->paginate($posts_per_page);
    }


    public static function create(): int
    {
        return DB::table('posts')
            ->insertGetId(
                ['author_id' => Auth::user()->id, 'status' => 'draft', 'created_at' =>  \Carbon\Carbon::now()],
            );
    }

    public function canEdit(): bool
    {
        if(Auth::id()) {
            if (Auth::id() == $this->author_id || Auth::user()->role == 'admin') {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function renderContent(){
        $render = '';
        if(!is_array($this->content)){
            return $this->content;
        }
        foreach($this->content['blocks'] as $block){
           $render .= view('components.blocks.'.$block['type'], $block['data']);
        }

        echo $render;
    }
}
