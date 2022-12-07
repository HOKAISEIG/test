
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Blogs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('sucess'))
                {{ session('sucess') }}
            @endif
            @if(session('co_sucess'))
                    {{ session('co_sucess') }}
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p(-6 bg-white border-b border-gray-200">
                    
                        <div class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">
                            <h1 class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg font-bold text-5xl">{{ $note->title }}</h1>
                            

                            <p class="mt-2">
                                {{($note->text)}}
                            </p>

                            <span class="block mt-4 text-sm opacity-70">
                                Created- 
                                {{ $note->created_at->diffForHumans(); }}
                                <br>
                                Updated- 
                                {{ $note->updated_at->diffForHumans(); }}
                            </span>
                            <br>
                        </div>
                    <!--like unlike section!-->
                    <div>    
                      
                        <a href="#" onclick="document.getElementById('like-form-{{ $note->id }}').submit();">
                            <i  class="{{Auth::user()->likedNotes()->where(['note_id'=>$note->id, 'value'=>'0'])->count() > 0 ? "fa fa-thumbs-up" : "fa fa-thumbs-o-up"}}" id= "likeIcon" style="font-size:48px"  ></i>
                        </a>
                        {{ $note->likedUsers->count() }}
                        <form action="{{ route('likePost',$note->id)  }}"method="POST" style="display: none" id="like-form-{{ $note->id }}">@csrf</form>

                        <a href="#" onclick="document.getElementById('dislike-form-{{ $note->id }}').submit();">
                            <i  class="{{Auth::user()->dislikedNotes()->where(['note_id'=>$note->id, 'value'=>'1'])->count() > 0 ? "fa fa-thumbs-down" : "fa fa-thumbs-o-down"}}" id= "dislikeIcon" style="font-size:48px"  ></i>
                        </a>
                        {{ $note->dislikedUsers->count() }}
                        <form action="{{ route('dislikePost',$note->id) }}" method="POST" style="display: none" id="dislike-form-{{ $note->id }}">@csrf</form>
                        <span></span>
                        
                       
                       
                   
                    </div>  
                </div>
            </div>
    </div>
   
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg text-4xl">
                    Comment Section:
            </div>
           
                @forelse ($note->comments as $comment) 
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 comcont border-b border-gray-200">
                        {{ $comment->c_body }}
                        <br>
                        Commented on: {{ $comment->created_at->format('Y-m-d') }}
                        <br>
                    
                        @if($note->user_id == $comment->user_id)
                            By->Author
                        @else
                            By->{{ $comment->user->name }}
                        @endif
                        @if(Auth::id()==$comment->user_id)
                            <div>
                                <button type="button" value="{{ $comment->id }}"class="btn editBtn">
                                    edit
                                </button>
                                
                                </button>
                                <button type="button" value="{{ $comment->id }}"class="btn deleteBtn">
                                    delete
                                </button>
                            </div>
                    
                        @endif
                        @can('delete_comment')
                            
                            <form action="{{ route('destroyCom', $comment->id)}}" method="POST" >
                                @csrf
                                @method('POST')
                                <button class="btn deleteBtn">DELETE</button>
                            </form>
                            
                        @endcan

                        <br>
                        <span>--------------------------------------</span>
                       
                    </div>
                    @empty
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10   ">
                        No comments yet
                    </div>
                @endforelse
                    
            
        </div>
    </div>
 
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if(session('message'))
                    {{ session('message') }}
                @endif
                <div class="p(-6 bg-white border-b border-gray-200 text-4xl">
                    Write a comment-
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" id = "postDiv">
                        <form action="{{ url('comments') }}" method="post">
                           <input type="hidden" name="post_uuid" value= "{{ $note->uuid}}">
                            @csrf
                           
                            <x-textarea 
                            name="c_body" 
                            rows="3" 
                            field="text" 
                            placeholer="Start commenting here..." 
                            class="w-full mt-6"
                            ></x-textarea>
                            
                            <x-button class="mt-6" id="postBtn">Post</x-button>
                        </form>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" id="updateDiv">
                        <form action="{{ url('update-comment')}}" method="post">
                            @method('put')
                            @csrf
                            <input hidden name="comment_id" id="comment_id">
                            <x-textarea id="com_area"
                            name="comment"
                            field="comment" 
                            rows="3" 
                            field="text"  
                            class="w-full mt-6"
                            ></x-textarea>
                            
                            <x-button  id="updateBtn" >Update</x-button>
                        </form>
                        <x-button  id="cancelBtn">Cancel</x-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <script>
       
        
        $(document).ready(function(){

            $('#updateDiv').hide();
            var id;

           

           $(document).on('click','.editBtn',function(){
                id = $(this).val();
                $.ajax({
                    type:"GET",
                    url: "/edit-comment/"+id,
                    success: function(response) {
                        $('#com_area').val(response.comment.c_body);
                        $('#comment_id').val(response.comment.id)
                        $('#updateDiv').show();
                        $('#postDiv').hide();
                    }
                });
            });

            $(document).on('click','#cancelBtn',function(){
                $('#com_area').val("");
                $('#updateDiv').hide();
                $('#postDiv').show();
            });

            $(document).on('click','.deleteBtn',function(){
               if(confirm('Confirm?'))
               {
                    var thisClicked = $(this);
                    var comment_id = thisClicked.val();
                  
                    $.ajax({
                        type:"POST",
                        url: "{{ route('deleteComment') }}",
                        data: {
                            '_token':'{{ csrf_token() }}',
                        'comment_id' : comment_id
                    },
                    success: function(response) {
                        if(response.status == 200){

                            thisClicked.closest('.comcont').remove();
                            alert(response.message);
                        
                        }
                        else{
                            alert(response.message)
                        }
                        
                    } 
                });
               }
            });
         });
    </script>

</x-app-layout>
