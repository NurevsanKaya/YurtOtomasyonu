<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yurt Otomasyonu - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="bg-gray-800 w-64 min-h-screen flex flex-col">
            <div class="p-4">
                <h2 class="text-white text-2xl font-semibold">Yurt Yönetimi</h2>
            </div>
            <nav class="flex-1 px-2 py-4 space-y-2">
                <a href="/admin/dashboard" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-home mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="/admin/students" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-users mr-3"></i>
                    <span>Öğrenciler</span>
                </a>
                <a href="/admin/rooms" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-bed mr-3"></i>
                    <span>Odalar</span>
                </a>
                <a href="/admin/announcements" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-bullhorn mr-3"></i>
                    <span>Duyurular</span>
                </a>
                <a href="{{ route('admin.unpaid-students.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-exclamation-circle mr-3"></i>
                    <span>Ödeme Yapmayanlar</span>
                </a>
                <a href="{{ route('admin.reservations.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-calendar-check mr-3"></i>
                    <span>Rezervasyon Talepleri</span>
                </a>
                <a href="{{ route('admin.visitors.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-calendar-check mr-3"></i>
                    <span>Ziyaretci Talepleri</span>
                </a>
                <a href="{{ route('admin.permission.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-calendar-check mr-3"></i>
                    <span>İzin Talepleri</span>
                </a>
                <a href="{{ route('admin.complaint.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-exclamation-circle mr-3"></i>
                    <span>Şikayet ve Talepler</span>
                </a>
                <a href="{{ route('admin.room-change-requests.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-exchange-alt mr-3"></i>
                    <span>Oda Değişikliği Talepleri</span>
                </a>
                <!-- Ödeme Yönetimi -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-money-bill mr-3"></i>
                            <span>Ödeme Yönetimi</span>
                        </div>
                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="pl-4 mt-2 space-y-1">
                        <a href="{{ route('admin.payments.index') }}" class="block px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                            <i class="fas fa-list mr-2"></i>
                            <span>Ödemeler</span>
                        </a>
                        <a href="{{ route('admin.room-prices.index') }}" class="block px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                            <i class="fas fa-tag mr-2"></i>
                            <span>Oda Fiyatları</span>
                        </a>
                    </div>
                </div>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col">
            <!-- Navbar -->
            <header class="bg-white shadow">
                <div class="flex justify-between items-center px-6 py-4">
                    <h1 class="text-2xl font-semibold text-gray-800">@yield('header')</h1>
                    <div class="relative">
                        <button id="profileButton" class="flex items-center space-x-2 focus:outline-none">
                            <span class="text-gray-700">Admin</span>
                            <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name=Admin" alt="Profile">
                        </button>
                        <div id="profileMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                            <a href="/admin/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i> Profil
                            </a>
                            <a href="/admin/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog mr-2"></i> Ayarlar
                            </a>
                            <hr class="my-1">
                            <form action="/admin/logout" method="POST" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Çıkış Yap
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Profile dropdown toggle
        const profileButton = document.getElementById('profileButton');
        const profileMenu = document.getElementById('profileMenu');

        profileButton.addEventListener('click', () => {
            profileMenu.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!profileButton.contains(e.target) && !profileMenu.contains(e.target)) {
                profileMenu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
