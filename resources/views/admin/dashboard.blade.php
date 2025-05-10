@extends('layouts.layoutbook')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-indigo-700 text-white flex flex-col space-y-4 p-6" style="background-color: #6356d9">
        <h2 class="text-2xl font-bold mb-6" style="font-size: 32px;">Admin Panel</h2>
        <nav class="space-y-2 flex" style="gap: 2rem; flex-direction: column;">
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded hover:bg-indigo-600" style="background-color: white; color: #6356d9;">Dashboard Home</a>
            <a href="{{ route('category.crudCategory') }}" class="block px-4 py-2 rounded hover:bg-indigo-600" style="background-color: white; color: #6356d9;">Manage Categories</a>
            <a href="{{ route('books.crudBook') }}" class="block px-4 py-2 rounded hover:bg-indigo-600" style="background-color: white; color: #6356d9;">Manage Books</a>
        </nav>
    </aside>
    
    <!-- Main Content -->
    <main class="flex-1 p-10">
        <h1 class="text-3xl font-semibold mb-6 text-indigo-800" style="font-size:40px;">Dashboard Overview</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Books -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold text-gray-700">Total Books</h2>
                <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $totalBooks }}</p>
            </div>

            <!-- Total Categories -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold text-gray-700">Total Categories</h2>
                <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $totalCategories }}</p>
            </div>

            <!-- Total Users -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold text-gray-700">Total Users</h2>
                <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $totalUsers }}</p>
            </div>
        </div>
    </main>
</div>
@endsection
