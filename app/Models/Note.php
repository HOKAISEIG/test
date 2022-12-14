<?php

namespace App\Models;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Note extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'uuid';
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function comments() {
        return $this->hasMany(Comment::class);
    }
    public function likedUsers() {
        return $this->belongsToMany(User::class, 'note_user')->withPivot('value')->wherePivot('value',0);
    }
    public function dislikedUsers(){
        return $this->belongsToMany(User::class,'note_user')->withPivot('value')->wherePivot('value',1);
    }
   
    
}
