<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::id();
        //$usernotes = Note::where('user_id',$userId)->latest('updated_at')->paginate(1,['*'], 'user');
           
        $usernotes = Auth::user()->notes()->latest('updated_at')->paginate(1);
        $othernotes= Note::where('user_id','!=',$userId)->latest('updated_at')->paginate(5 ,['*'], 'other');
        return view('notes.index')->with('data',['u' =>$usernotes, 'o' =>$othernotes, ]);
           
    }
        
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => "required|max:120",
            'text' => 'required'

        ]);

        $blog = new NOTE([
            'uuid' =>Str::uuid(),
            'user_id' => Auth::id(),
            'title' => $request ->title,
            'text' => $request -> text
        ]);

        $blog ->save();
        return redirect()->route('notes.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        
        
        return view('notes.show')->with('note',$note);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
       
        if($note->user_id != Auth::id()){
          return abort(403);
        }
        
        return view('notes.edit')->with('note',$note);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        if($note->user_id != Auth::id()){
            return abort(403);
          }
        $request->validate([
            'title' => "required|max:120",
            'text' => 'required'

        ]);
        $note->update([
            
            'title'=>$request->title,
            'text'=>$request->text

        ]);
        //return view('notes.show')->with('note',$note);
        return redirect()->route('notes.show',['note'=>$note])->with('sucess','Blog updated sucessfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        if($note->user_id != Auth::id()){
            return abort(403);
          }
        $note->delete();
        $userId = Auth::id();
        $usernotes = Note::where('user_id',$userId)->latest('updated_at')->paginate(1,['*'], 'user');
        $othernotes= Note::where('user_id','!=',$userId)->latest('updated_at')->paginate(10 ,['*'], 'other');

        return redirect()->route('notes.index');
    }
}
