<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Blogs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p(-6 bg-white border-b border-gray-200">
                    @forelse ($data['u'] as $note) 
                        <div class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">
                            <h1 class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg font-bold text-5xl">Your blogs</h1>
                            
                            <h2 class="font-bold text-xl">
                                <a href="{{ route('notes.show',$note) }}">{{ $note->title }}</a>
                            </h2>

                            <p class="mt-2">
                                {{ Str::limit($note->text,300)}}
                            </p>

                            <span class="block mt-4 text-sm opacity-70">
                                {{ $note->updated_at->diffForHumans(); }}
                            </span>
                            
                           
                            <a href="{{ route('notes.edit', $note) }}" class="btn-link">Edit blog</a>
                            <br>
                            <span>
                                <br>
                            </span>
                            <form action="{{ route('notes.destroy', $note) }}" method="post">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn-link" onclick="return confirm('Are you sure that you want to delete this blog?')">Delete this blog</button>
                            </form>
                        </div>
                    @empty
                    <p class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">You have no blogs</p>
                    
                    @endforelse

                    {{ $data['u'] ->links() }}

                </div>
                
            </div>
            <div class="p(-6 bg-white border-b border-gray-200">
                <h1 class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg font-bold text-5xl">Other blogs</h1>
                @forelse ($data['o'] as $note) 
                    <div class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">
 
                        <h2 >
                            <a href="{{ route('notes.show',$note) }}" class="font-bold text-xl ">{{ $note->title }}</a>
                        </h2>

                        <p class="mt-2">
                            {{ Str::limit($note->text,300)}}
                        </p>
                        
                        <span class="block mt-4 text-sm opacity-70">
                           Author-
                            {{ $note->user->name }}
                           
                        </span>
                        <span class="block mt-4 text-sm opacity-70">
                            {{ $note->updated_at->diffForHumans(); }}
                        </span>
                        <br>
                       

                    </div>
                @empty
                <p class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">There are no blogs</p>
                
                @endforelse

                {{ $data['o'] ->links() }}

            </div>
        </div>
        </div>
    </div>
</x-app-layout>
