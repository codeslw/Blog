<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Post extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user(){
        return $this->belongsTo(\App\Models\User::class);
    }
    public function comments(){
        return $this->hasMany(\App\Models\Comment::class);
    }
    public function likes(){
        return $this->hasMany(Like::class);
    }
}
