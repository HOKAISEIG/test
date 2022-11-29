<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Blogs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('notes.store') }}" method="post">
                    @csrf
                    <x-input 
                    type="text"  
                    name="title" 
                    field="title" 
                    placeholder="Title" 
                    class="w-full mt-6" 
                    aria-autocomplete="off"
                    :value="@old('title')"></x-input>
                   
                    <x-textarea 
                    name="text" 
                    rows="10" 
                    field="text" 
                    placeholder="Start typing here..." 
                    class="w-full mt-6"
                    :value="@old('text')"></x-textarea>
                    
                    <x-button class="mt-6">Post</x-button>
                </form>
            </div>
        </div>
        </div>
    </div>
</x-app-layout>
