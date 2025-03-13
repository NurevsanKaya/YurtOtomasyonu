@extends('admin.layouts.app')

@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Toplam Öğrenci -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500">Toplam Öğrenci</p>
                <h3 class="text-2xl font-semibold">{{ $totalStudents ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <!-- Boş Odalar -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-bed text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500">Boş Odalar</p>
                <h3 class="text-2xl font-semibold">{{ $emptyRooms ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <!-- Bekleyen Ödemeler -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-100 text-red-600">
                <i class="fas fa-money-bill text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500">Bekleyen Ödemeler</p>
                <h3 class="text-2xl font-semibold">{{ $pendingPayments ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <!-- Bakım Talepleri -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <i class="fas fa-tools text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500">Bakım Talepleri</p>
                <h3 class="text-2xl font-semibold">{{ $maintenanceRequests ?? 0 }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Son Aktiviteler -->
<div class="mt-8 bg-white rounded-lg shadow">
    <div class="p-6">
        <h2 class="text-lg font-semibold text-gray-700">Son Aktiviteler</h2>
        <div class="mt-4">
            <div class="flow-root">
                <ul class="-my-5 divide-y divide-gray-200">
                    @forelse($recentActivities ?? [] as $activity)
                    <li class="py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <i class="fas fa-circle-info text-blue-500"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    {{ $activity->description }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ $activity->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </li>
                    @empty
                    <li class="py-4">
                        <p class="text-gray-500 text-center">Henüz aktivite bulunmuyor.</p>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
