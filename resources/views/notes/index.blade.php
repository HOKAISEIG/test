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
                    @forelse ($notes as $note) 
                        <div class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">
                            <h2 class="font-bold text-2xl">
                                {{ $note->Title }}
                            </h2>

                            <p class="mt-2">
                                {{ $note->Text}}
                            </p>

                            <span class="block mt-4 text-sm opacity-70">
                                {{ $note->updated_at->diffForHumans(); }}
                            </span>
                            <br>
                        </div>
                    @empty
                    <p class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">You have no blogs</p>
                    
                    @endforelse

                    {{ $notes ->links() }}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>