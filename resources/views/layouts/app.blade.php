<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Memastikan body dan html memiliki tinggi penuh */
        html, body {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }

        /* Mengatur padding untuk main content agar konten tidak tersembunyi di bawah footer */
        main {
            padding-bottom: 100px; /* Sesuaikan dengan tinggi footer */
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div id="main-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-x-hidden fixed inset-x-0 mx-auto top-0 z-50 w-full md:inset-x-0 max-h-screen scroll-m-0"></div>

    <div class="flex h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Sidebar -->
        <aside class="w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 overflow-y-auto">
            @include('layouts.navigation')
        </aside>

        <!-- Main Content -->
        <div class="flex flex-col flex-1">
            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow sticky top-0 z-10">
                    <div class="px-4 sm:px-6 lg:px-8 py-6">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white dark:bg-gray-800 shadow-inner py-3 border-t border-gray-200 dark:border-gray-700 sticky bottom-0 z-10">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="text-center text-gray-600 dark:text-gray-400">
                        procurement@inkamultisolusi
                    </div>
                </div>
            </footer>

            {{-- Untuk inject js per halaman --}}
            @isset($js)
                {{ $js }}
            @endisset
        </div>
    </div>
</body>

</html>