<?php

namespace App\Models\Comment;

use App\Models\Post\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @property mixed $id
 * @property mixed $post_id
 * @property mixed $author_id
 * @property mixed $created_at
 * @property mixed $status
 * @property mixed $content
 */

class Comment extends Model
{
    use HasFactory;

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

        return Comment::where('status', $status)
            ->when(isset($args['author_id']), function ($query) use ($args) {
                $query->where('author_id', $args['author_id']);
            })->when(isset($args['post_id']), function ($query) use ($args) {
                $query->where('post_id', $args['post_id']);
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
}
