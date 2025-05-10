    <!-- This is the layout that is used for this study case laravel project -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name', 'Book Catalog') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col font-sans">

    <!-- Navbar -->
    <header class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div>
                <a href="{{ url('/') }}" class="text-2xl font-bold text-indigo-600">BookCatalog</a>
            @auth
                <span class="text-sm text-gray-600">Hi, {{ Auth::user()->name }}</span>
            </div>


                <div class="flex items-center gap-4">
                    <a href="{{ route('books.index') }}" class="text-sm text-indigo-600 hover:underline">Home</a>
                    <a href="{{ route('admin.dashboard') }}" class="text-sm text-indigo-600 hover:underline">Admin</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-600 hover:underline">Logout</button>
                    </form>
                </div>
            @else
                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:underline">Login</a>
                    <a href="{{ route('register') }}" class="text-sm text-indigo-600 hover:underline">Register</a>
                </div>
            @endauth
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-10 py-4">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} BookCatalog. All rights reserved.
        </div>
    </footer>

</body>
</html>