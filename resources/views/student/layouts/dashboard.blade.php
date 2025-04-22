<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md border-r">
            <div class="p-6 border-b">
                <h1 class="text-lg font-semibold text-gray-800">Öğrenci Paneli</h1>
            </div>
            <nav class="flex flex-col p-4 space-y-2 text-sm text-gray-700">
                <a href="{{ route('student.duyuru.index') }}"
                   class="block py-2 px-4 rounded hover:bg-gray-100 {{ request()->routeIs('student.duyuru.index') ? 'bg-gray-200 font-semibold' : '' }}">
                    Duyurular
                </a>
                <a href="{{ route('student.izin.index') }}"
                   class="block py-2 px-4 rounded hover:bg-gray-100 {{ request()->routeIs('student.izin.index') ? 'bg-gray-200 font-semibold' : '' }}">
                    İzinler
                </a>
                <a href="{{ route('student.oda.index') }}"
                   class="block py-2 px-4 rounded hover:bg-gray-100 {{ request()->routeIs('student.oda.index') ? 'bg-gray-200 font-semibold' : '' }}">
                    Oda Bilgileri
                </a>
                <a href="{{ route('student.menu.index') }}"
                   class="block py-2 px-4 rounded hover:bg-gray-100 {{ request()->routeIs('student.menu.index') ? 'bg-gray-200 font-semibold' : '' }}">
                    Yemekhane
                </a>
                <a href="{{ route('student.aidat.index') }}"
                   class="block py-2 px-4 rounded hover:bg-gray-100 {{ request()->routeIs('student.aidat.index') ? 'bg-gray-200 font-semibold' : '' }}">
                    Aidat
                </a>
                <a href="{{ route('student.ziyaretci.index') }}"
                   class="block py-2 px-4 rounded hover:bg-gray-100 {{ request()->routeIs('student.ziyaretci.index') ? 'bg-gray-200 font-semibold' : '' }}">
                    Ziyaretçi
                </a>
                <a href="{{ route('student.sikayet.index') }}"
                   class="block py-2 px-4 rounded hover:bg-gray-100 {{ request()->routeIs('student.sikayet.index') ? 'bg-gray-200 font-semibold' : '' }}">
                    Şikayet
                </a>
            </nav>
        </aside>

        <!-- İçerik Alanı -->
        <main class="flex-1 p-8">
            @yield('content')
        </main>



    </div>
</x-app-layout>
