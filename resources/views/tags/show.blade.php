<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Categories') }}
            </h2>
            <a href="{{ route('tags.edit', $tag->id) }}" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                {{ __('Edit Tag') }}
            </a>
            <form action="{{ route('tags.destroy', $tag->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600">
                    {{ __('Delete Tag') }}
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold mb-4">Tag Details</h1>
                    <p><strong>Name:</strong> {{ $tag->name }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>