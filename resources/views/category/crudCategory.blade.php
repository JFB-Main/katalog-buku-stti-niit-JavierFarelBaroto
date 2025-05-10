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

<div class="min-w-4xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-column" style="width: max-content;">
    <div class="bg-white rounded-2xl shadow p-6 sm:p-8" style="width: 100%;">
        <h2 class="text-2xl font-bold text-indigo-700 mb-6">
            {{ isset($catEdit) ? 'Edit Categories' : 'Add New Categories' }}
        </h2>

        <form action="{{ isset($catEdit) ? route('categories.update', $catEdit->id) : route('categories.store') }}" method="POST" enctype="multipart/form-data"class="space-y-6">
            <!-- csrf token and if else statement for dual action method purpose, between updating and adding-->
            @csrf
            @if(isset($catEdit))
                @method('PUT')
            @endif

            <!-- Name -->
            <div>
                <label for="Name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $catEdit->name ?? '') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-400"
                    required>
            </div>

            <!-- Submit -->
            <div>
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-200" style="background-color: #5546e7">
                    {{ isset($catEdit) ? 'Update Category' : 'Add Category' }}
                </button>
            </div>
        </form>
    </div>
    <div class="bg-white shadow rounded p-4 flex flex-column" style="flex-direction: column">
        <div class="min-w-fit" style="width: fit-content">
        </div>
        <table class="w-full table-auto" style="width: 1000px;">
            <thead class="bg-gray-100">
                <tr>
                    <th class="text-left p-2">Id</th>
                    <th class="text-left p-2">Name</th>
                    <th class="text-left p-2">Created At</th>
                    <th class="text-left p-2">Updated At</th>
                    <th class="text-left p-2">Edit</th>
                </tr>
            </thead>
            <tbody>
                @forelse($catCrud as $c)
                    <tr class="border-t">
                        <td class="p-2">{{ $c->id }}</td>
                        <td class="p-2">{{ $c->name }}</td>
                        <td class="p-2">{{ $c->created_at }}</td>
                        <td class="p-2">{{ $c->updated_at }}</td>
                        <td class="flex justify-center gap-4 p-6">
                            <!-- Update Button Form -->
                            <form method="GET" action="/editCategory?">
                                @csrf
                                <input type="hidden" name="id" value="{{ $c->id }}">
                                <button type="submit" class="text-white px-4 py-2 rounded hover:bg-indigo-50 bg-indigo-600" style="background-color: #5546e7">
                                    Update
                                </button>
                            </form>

                            <!-- Delete Button Form -->
                            <form method="POST" action="{{ route('categories.destroy', $c->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this Category?')" class="text-white px-4 py-2 rounded hover:bg-indigo-50 bg-red-600">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-500">No Category found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $catCrud->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
