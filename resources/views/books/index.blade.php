@extends('layouts.layoutbook')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold mb-6 text-indigo-700">Book List</h1>

    <!-- Filter -->
    <form method="GET" class="mb-6">
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

    <!-- Book Table -->
    <div class="bg-white shadow rounded p-4">
        <table class="w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="text-left p-2">Title</th>
                    <th class="text-left p-2">Author</th>
                    <th class="text-left p-2">Category</th>
                    <th class="text-left p-2">Cover</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                    <tr class="border-t">
                        <td class="p-2">
                            <a href="{{ route('books.show', $book->id) }}" class="text-indigo-600 hover:underline">
                                {{ $book->title }}
                            </a>
                        </td>
                        <td class="p-2">{{ $book->author }}</td>
                        <td class="p-2">
                            <a href="{{ route('books.index', ['category' => $book->category_id]) }}"
                               class="text-indigo-600 hover:underline">
                                {{ $book->kategori->name ?? 'N/A' }}
                            </a>
                        </td>
                        <td class="p-2">
                            @if($book->cover)
                                <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover" class="h-16 rounded shadow">
                            @else
                                <span class="text-gr    ay-500">No cover</span>
                            @endif
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
