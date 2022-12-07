<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    //
    
    public function likePost($note_id) 
    {
        $user = Auth::user();
        $likePost = $user->likedNotes()->where(['note_id'=>$note_id])->count();
        if($likePost == 0 ) 
        {   
            if($user->dislikednotes()->where('note_id',$note_id)->count() == 1){
                $user->dislikedNotes()->detach($note_id);
            }
            $user->likedNotes()->attach($note_id,['value'=>'0']);
        }
        else 
        {
            $user->likedNotes()->detach($note_id);
        }
        return redirect()->back();
    }
    public function dislikePost($note_id)
    {
        $user =Auth::user();
        $dislikePost = $user->dislikedNotes()->where(['note_id'=>$note_id])->count();
        if($dislikePost == 0)
        {
            if($user->likedNotes()->where('note_id',$note_id)->count()==1){
                $user->likedNotes()->detach($note_id);
            }
            $user->dislikedNotes()->attach($note_id,['value'=>'1']);
        }
        else{
            $user->dislikedNotes()->detach($note_id);
        }   
        return redirect()->back();
    }
}

