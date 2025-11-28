<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Rany Shop</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="shortcut icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

        <!-- Styles -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="antialiased bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
        <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                    <div class="flex lg:justify-center lg:col-start-2">
                        <div class="flex items-center justify-center w-24 h-24 bg-yellow-500 rounded-lg shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" class="w-16 h-16 text-white">
                                <rect x="20" y="30" width="60" height="50" rx="4" fill="currentColor"/>
                                <path d="M 30 30 L 30 25 Q 30 20 35 20 L 65 20 Q 70 20 70 25 L 70 30" stroke="currentColor" stroke-width="3" fill="none"/>
                                <circle cx="40" cy="50" r="3" fill="white"/>
                                <circle cx="60" cy="50" r="3" fill="white"/>
                            </svg>
                        </div>
                    </div>
                    @if (Route::has('login'))
                        <nav class="-mx-3 flex flex-1 justify-end">
                            @auth
                                <a
                                    href="{{ url('/dashboard') }}"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                >
                                    Dashboard
                                </a>
                            @else
                                <a
                                    href="{{ route('login') }}"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                >
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a
                                        href="{{ route('register') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </header>

                <main class="mt-6 text-center">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-6xl">
                        Welcome to <span class="text-[#FF2D20]">Rany Shop</span>
                    </h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300">
                        Your one-stop shop for everything aesthetic and amazing.
                    </p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a href="{{ route('home.index') }}" class="rounded-md bg-[#FF2D20] px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#FF2D20]/80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#FF2D20]">
                            Shop Now
                        </a>
                    </div>
                </main>

                <footer class="py-16 text-center text-sm text-gray-500 dark:text-gray-400">
                    &copy; {{ date('Y') }} Rany Shop. All rights reserved.
                </footer>
            </div>
        </div>
    </body>
</html>
