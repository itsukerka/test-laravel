<?php

namespace App\Models\Comment;

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
