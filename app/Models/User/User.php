<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Laravolt\Avatar\Avatar;

/**
 * @property mixed $id
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //
    // Получаем значение метаполя по ID поста и ключу
    //
    public function get_meta($meta_key, $user_id = false): string
    {
        if(!$user_id){
            $user_id = $this->id;
        }
        $query = UserMeta::select('user_metas.*')
            ->where('user_id', '=', $user_id)
            ->where('meta_key', '=', $meta_key)
            ->paginate(1)->first();
        $result = '';
        if($query){
            $result = $query->meta_value;
        }

        return $result;
    }

    public function update_meta($key, $value, $user_id = false){

        if(!$user_id){
            $user_id = $this->id;
        }

        DB::table('user_metas')
            ->updateOrInsert(
                ['meta_key' => $key, 'user_id' => $user_id],
                ['meta_value' => $value]
            );
    }

    public function notEmptyClass($string = ''){
        if($string != ''){
            echo 'not-empty';
        }
    }

    public function get_avatar(){
        $config = include config_path().'/laravolt/avatar.php';
        $image_url = $this->get_meta('avatar');
        $avatar = new Avatar($config);

        if($image_url == '') {
            echo  $avatar->create($this->name)->toSvg();
        } else {
            echo '<img src=".$image_url.">';
        }
    }
}
