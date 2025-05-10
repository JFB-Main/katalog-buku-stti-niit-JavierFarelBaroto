@extends('layouts.layoutbook')

@section('content')
@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded">
        <ul class="list-disc ml-4">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="min-w-4xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-column" style="">
    <div class="bg-white rounded-2xl shadow p-6 sm:p-8" style="width: 100%;">
        <h2 class="text-2xl font-bold text-indigo-700 mb-6">
            {{ isset($book) ? 'Edit Book' : 'Add New Book' }}
        </h2>

        <form action="{{ isset($book) ? route('books.update', $book->id) : route('books.store') }}" method="POST" enctype="multipart/form-data"class="space-y-6" style="width: max-content">
            @csrf
            @if(isset($book))
                @method('PUT')
            @endif

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', default: $book->title ?? '') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-400"
                    required>
            </div>

            <!-- Author -->
            <div>
                <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Author</label>
                <input type="text" id="author" name="author" value="{{ old('author', $book->author ?? '') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-400"
                    required>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-400"
                >{{ old('description', $book->description ?? '') }}</textarea>
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category_id" id="category_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-400"
                    required>
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ (old('category_id', $book->category_id ?? '') == $category->id) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Cover Upload -->
            <div>
                <label for="cover" class="block text-sm font-medium text-gray-700 mb-1">Cover Image</label>
                <input type="file" id="cover" name="cover"
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                           file:rounded-lg file:border-0
                           file:text-sm file:font-semibold
                           file:bg-indigo-50 file:text-indigo-700
                           hover:file:bg-indigo-100" />
                @if(isset($book) && $book->cover)
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover Image" class="h-20 rounded shadow">
                    </div>
                @endif
            </div>

            <!-- Submit -->
            <div>
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-200" style="background-color: #5546e7">
                    {{ isset($book) ? 'Update Book' : 'Add Book' }}
                </button>
            </div>
        </form>
    </div>

    
    <div class="bg-white shadow rounded p-4 flex flex-column" style="flex-direction: column">
           <!-- Filter -->
        <div class="min-w-fit" style="width: fit-content">
            <form method="GET" action="" class="mb-6">
                @csrf
                @if(isset($book))
                    <input type="hidden" name="id" value="{{ $book->id }}" />
                @endif
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-4">
                        <select name="category" class="p-2 border rounded w-1/2">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <input name="author" type="text" placeholder="Search Author">
                        <input name="booktitle" type="text" placeholder="Search By Book Title">
                    </div>
                    <button type="submit" class="text-white px-4 py-2 rounded hover:bg-indigo-50 bg-indigo-600" style="background-color: #5546e7">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Book Table -->
        <table class="w-full table-auto" style="width: 1000px;">
            <thead class="bg-gray-100">
                <tr>
                    <th class="text-left p-2">Title</th>
                    <th class="text-left p-2">Author</th>
                    <th class="text-left p-2">Category</th>
                    <th class="text-left p-2">Cover</th>
                    <th class="text-left p-2">Edit</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                    <tr class="border-t p-2">
                        <td>
                            <a href="{{ route('books.show', $book->id) }}" class="text-indigo-600 hover:underline">
                                {{ $book->title }}
                            </a>
                        </td>
                        <td class="p-2">{{ $book->author }}</td>
                        <td class="p-2">
                            <a href="{{ route('books.crudBook', ['category' => $book->category_id]) }}"
                               class="text-indigo-600 hover:underline">
                                {{ $book->kategori->name ?? 'N/A' }}
                            </a>
                        </td>
                        <td class="p-2">
                            @if($book->cover)
                                <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover" class="h-16 rounded shadow">
                            @else
                                <span class="text-gray-500">No cover</span>
                            @endif
                        </td>
                        <td class="flex justify-center gap-4 p-6">
                            <!-- Update Button Form -->
                            <form method="GET" action="/editBook?">
                                @csrf
                                <input type="hidden" name="id" value="{{ $book->id }}">
                                <button type="submit" class="text-white px-4 py-2 rounded hover:bg-indigo-50 bg-indigo-600" style="background-color: #5546e7">
                                    Update
                                </button>
                            </form>

                            <!-- Delete Button Form -->
                            <form method="POST" action="{{ route('books.destroy', $book->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this book?')" class="text-white px-4 py-2 rounded hover:bg-indigo-50 bg-red-600">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-500">No books found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $books->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
