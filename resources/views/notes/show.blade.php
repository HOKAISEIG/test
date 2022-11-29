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
                  

                 

                </div>
            </div>
    </div>
   
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg text-4xl">
                    Comment Section:
            </div>
           
                @forelse ($note->comments as $comment) 
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10  ">
                    {{ $comment->c_body }}
                    Commented on: {{ $comment->created_at->format('Y-m-d') }}
                    @if($comment->user)
                        {{ $comment->user->name }}
                    @endif
                    @if(Auth::id() == $comment->user_id)
                        <div>
                            <button type="button" value="{{ $comment->id }}"class="btn editBtn">
                                edit
                            </button>
                            
                            </button>
                            <a href="{{ route('login') }}" class="btn">
                                delete
                            </a>
                        </div>
                    @endif

                    <span><br></span>
                    
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
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <form action="{{ url('comments') }}" method="post">
                           <input type="hidden" name="post_uuid" value= "{{ $note->uuid}}">
                            @csrf
                           
                            <x-textarea id="com_area"
                            name="c_body" 
                            rows="3" 
                            field="text" 
                            placeholer="Start commenting here..." 
                            class="w-full mt-6"
                            :value="@old('text')"></x-textarea>
                            
                            <x-button class="mt-6" id="post-btn">Post</x-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <script>
        $(document).ready(function(){
           $(document).on('click','.editBtn',function(){
                
                var id = $(this).val();
                
              
                $.ajax({
                    type:"GET",
                    url: "/edit-comment/"+id,
                    success: function(response) {
                       
                        $('#com_area').val(response.comment.c_body);
                        
                    }

                });
                
               
            });
         });

    </script>

</x-app-layout>
