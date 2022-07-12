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

    public static function get($id)
    {
        $post_data = false;
        $query = Post::find($id);
        $get_content = '';
        if($query){
            $Post = $query;

            // Если статья принадлежит юзеру или юзер админ – возвращаем статью
            if($Post->status != 'publish' AND !Auth::id()) {
                return false;
            }
            if ($Post->status != 'publish' AND (Auth::id() != $Post->author_id OR Auth::user()->role != 'admin')) {
                return false;
            }

            $query_post_content = PostMeta::select('*')
                ->where('post_id', '=', $id)
                ->where('meta_key', '=', 'post_content')
                ->paginate(1)->first();

            if($query_post_content){
                $get_content = $query_post_content->meta_value;
            }

            $content = json_decode($get_content, true);

            if(!is_array($content)){
                $content = $get_content;
            }
            $Post->content = $content;
        }

        return $Post;
    }



    //
    // Запрос на получение записей по параметрам
    //
    public static function query($args = []) {
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

    public function content(){
        $render = '';
        if(!is_array($this->content)){
            return $this->content;
        }
        foreach($this->content['blocks'] as $block){
           $render .= view('components.blocks.'.$block['type'], $block['data']);
        }

        echo $render;
    }

    public static function slugify($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
