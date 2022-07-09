<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property mixed $id
 */

class Meta extends Model
{
    use HasFactory;

    public function create($type, $key, $value){
        $table = $type.'_metas';
        DB::table($table)
            ->updateOrInsert(
                ['meta_key' => $key, 'item_id' => $this->id],
                ['meta_value' => $value]
            );
    }

    public function edit($type, $key, $value) {
        $this->create($type, $key, $value);
    }

    public function get($type, $key){
        $table = $type.'_metas';
        $query = DB::table($table)
            ->where('item_id', '=', $this->id)
            ->where('meta_key', '=', $key)
            ->first();
        $result = '';
        if($query){
            $result = $query->meta_value;
        }

        return $result;
    }

    public function remove($type, $key){
        $table = $type.'_metas';
        DB::table($table)
            ->where('item_id', '=', $this->id)
            ->where('meta_key', '=', $key)
            ->first()->delete();
    }
}
