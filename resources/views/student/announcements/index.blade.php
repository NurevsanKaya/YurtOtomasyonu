@extends('student.layouts.dashboard')

@section('title', 'Duyurular')
@section('content')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($announcements->isEmpty())
                        <p class="text-center text-gray-500 dark:text-gray-400">Henüz duyuru bulunmamaktadır.</p>
                    @else
                        <div class="space-y-6">
                            @foreach($announcements as $announcement)
                                <div class="bg-white dark:bg-gray-800 border rounded-lg shadow-sm p-6">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $announcement->title }}</h3>
                                            <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $announcement->content }}</p>
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            <p>Başlangıç: {{ \Carbon\Carbon::parse($announcement->start_date)->format('d.m.Y') }}</p>
                                            <p>Bitiş: {{ \Carbon\Carbon::parse($announcement->end_date)->format('d.m.Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
