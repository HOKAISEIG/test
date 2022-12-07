<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Cache\RedisTaggedCache;

class AdminController extends Controller
{
    public function destroyComment($id)
    {
        $comment = Comment::where("id", $id)->first();
        $this->authorize('delete_comment');
        $comment-> delete();
        return redirect()->back();
    }
    public function destroyPost(Note $note)
    {
        $this->authorize('delete_post');
        $note-> delete();
        return redirect()->back();
    }
}


