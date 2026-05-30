<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TipVerify')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen">

    {{-- Navigácia --}}
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-5xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/" class="font-bold text-lg tracking-tight text-gray-900">TipVerify</a>

            <div class="flex items-center gap-4">
                @auth
                    <span class="text-sm text-gray-500">{{ auth()->user()->name }}</span>
                    @if(auth()->user()->is_admin)
                        <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full font-medium">Admin</span>
                    @endif
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit" class="text-sm text-gray-600 hover:text-gray-900 cursor-pointer bg-transparent border-0 p-0">
                            Odhlásiť
                        </button>
                    </form>
                @else
                    <a href="/login" class="text-sm text-gray-600 hover:text-gray-900">Prihlásiť</a>
                    <a href="/register" class="text-sm bg-blue-600 text-white px-3 py-1.5 rounded hover:bg-blue-700">Registrovať</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Flash správy --}}
    <div class="max-w-5xl mx-auto px-4 mt-4">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded text-sm">
                {{ session('error') }}
            </div>
        @endif
    </div>

    {{-- Hlavný obsah --}}
    <main class="max-w-5xl mx-auto px-4 py-6">
        @yield('content')
    </main>

</body>
</html>