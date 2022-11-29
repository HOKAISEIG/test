<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class CommentController extends Controller
{
    public function store(Request $request )
    {
        // $request->validate([
        //     'c_body' => "required|max:120",
        
        // ]);
        $validator = Validator::make($request->all(),[
            'c_body' => 'required'
        ]);
        if($validator->fails()){
            return back()->with('message','Comment is mandatory');
        }
        else{
            $note = Note::where('uuid', $request->post_uuid)->first();
            if($note){ 
               
              
                $com = new Comment([
                    'note_id'=> $note ->id,
                    'user_id' => Auth::user()->id,
                    'c_body' => $request->c_body,
                    'uuid' =>Str::uuid(),  
                ]);
        
                $com->save();
                
                return redirect()->route('notes.show',['note'=>$note])->with('co_sucess','Commented sucessfully.');
               
            }
            else 
            {
                return redirect()->back()-> with('message','No such post found');
            }
        }


        
    }
    public function edit($id)
    {

        $comment = Comment::find($id);
        return response()->json([
            'status'=>200,
            'comment'=>$comment,
        
        ]);
    }

}
