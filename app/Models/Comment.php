<?php

namespace App\Models;

use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $table = "comments";
    protected $fillable = [
        'user_id',
        'uuid',
        'c_body',
        'note_id'
    ];
  
    public function note(){
        return $this->belongsTo(Note::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
