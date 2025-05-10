@extends('layouts.layoutbook') 

@section('content')
<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-5xl mx-auto px-4">
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-3">
                <!-- Cover -->
                <div class="p-6 flex items-center justify-center bg-gray-50">
                    @if($book->cover)
                        <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }}" class="w-full max-w-xs rounded-xl shadow" style="width: 350px">
                    @else
                        <div class="w-48 h-64 bg-gray-300 flex items-center justify-center text-gray-500 rounded-xl">
                            No Cover Image
                        </div>
                    @endif
                </div>

                <!-- Details -->
                <div class="md:col-span-2 p-6 space-y-4 flex" style="flex-direction: column; gap: 2rem;">
                    <h1 class="font-bold text-gray-800 text-7xl" style="font-size: 40px; font-weight: 600;">{{ $book->title }}</h1>
                    <div class="text-sm text-gray-600">
                        <span class="font-semibold" style="font-size: 24px; font-weight: 600;">Author:</span> {{ $book->author }}
                    </div>

                    <div class="text-sm text-gray-600" style="font-size: 24x; font-weight: 600;">
                        <span class="font-semibold">Category:</span> {{ $book->kategori->name ?? 'Uncategorized' }}
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 mb-2" style="font-size: 24px; font-weight: 600;">Description</h2>
                        <p class="text-gray-700 leading-relaxed">
                            {{ $book->description ?? 'No description available.' }}
                        </p>
                    </div>

                    <div class="pt-4">
                        <a href="{{ route('books.index') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded" style="background-color: #5546e7">
                            Back to Book List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
