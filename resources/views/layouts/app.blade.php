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
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Sidebar ve İçerik için Flex Container -->
            <div class="flex">
                <!-- Sidebar (Sol Bölge) -->
                <aside class="bg-gray-800 w-64 min-h-screen flex flex-col">
                    <div class="p-4">
                        <h2 class="text-white text-2xl font-semibold">Yurt Yönetimi</h2>
                    </div>
                    <nav class="flex-1 px-2 py-4 space-y-2">
                        <!-- Profil Bilgileri ve Güncelleme -->
                        <a href="" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                            <i class="fas fa-home mr-3"></i>
                            <span>Profil Bilgileri ve Güncelleme</span>
                        </a>
                        <!-- İzin Alma Sistemi -->
                        <a href="{{ route('student.izin.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                            <i class="fas fa-users mr-3"></i>
                            <span>İzin Alma Sistemi</span>
                        </a>
                        <!-- Oda Bilgileri Görüntüleme ve Değişiklik Talebi -->
                        <a href="{{ route('student.oda.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                            <i class="fas fa-bed mr-3"></i>
                            <span>Oda Bilgileri Görüntüleme ve Değişiklik Talebi</span>
                        </a>
                        <!-- Yemekhane Takibi ve Menü Görüntüleme -->
                        <a href="{{ route('student.menu.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                            <i class="fas fa-money-bill mr-3"></i>
                            <span>Yemekhane Takibi ve Menü Görüntüleme</span>
                        </a>
                        <!-- Aidat ve Borç Takibi -->
                        <a href="{{ route('student.aidat.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                            <i class="fas fa-bullhorn mr-3"></i>
                            <span>Aidat ve Borç Takibi</span>
                        </a>
                        <!-- Ziyaretçi Bildirimi -->
                        <a href="{{ route('student.ziyaretci.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                            <i class="fas fa-tools mr-3"></i>
                            <span>Ziyaretçi Bildirimi</span>
                        </a>
                        <!-- Duyuru Sistemi -->
                        <a href="{{ route('student.duyuru.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                            <i class="fas fa-tools mr-3"></i>
                            <span>Duyuru Sistemi</span>
                        </a>
                        <!-- Dilek ve Şikayet Bildirimi -->
                        <a href="{{ route('student.sikayet.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                            <i class="fas fa-tools mr-3"></i>
                            <span>Dilek ve Şikayet Bildirimi</span>
                        </a>
                    </nav>
                </aside>

                <!-- Ana İçerik Bölgesi (Sağ Bölge) -->
                <div class="flex-1">
                    <!-- Page Content -->
                    <main>
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>

        @stack('scripts')
    </body>
</html>
