<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gist extends Model
{
    use HasFactory;
//    use softDeletes;

    protected $fillable = ['user_id', 'topic', 'body', 'created_at', 'updated_at', 'deleted_at'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
