@extends('student.layouts.dashboard')

@section('title', 'Şikayet ve Talepler')
@section('content')
    <div class="flex-1">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Yeni Şikayet Formu -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h2 class="text-xl font-semibold mb-4">Yeni Şikayet/Talep Oluştur</h2>
                        <form method="POST" action="{{ route('student.complaint.store') }}">
                            @csrf
                            <!-- Başlık -->
                            <div class="mb-4">
                                <label for="title" class="block text-gray-700 font-medium mb-1">Başlık</label>
                                <input
                                    type="text"
                                    id="title"
                                    name="title"
                                    class="w-full border border-gray-300 p-2 rounded"
                                    placeholder="Başlığı giriniz"
                                    required
                                >
                            </div>

                            <!-- Açıklama -->
                            <div class="mb-4">
                                <label for="description" class="block text-gray-700 font-medium mb-1">Açıklama</label>
                                <textarea
                                    id="description"
                                    name="description"
                                    rows="4"
                                    class="w-full border border-gray-300 p-2 rounded"
                                    placeholder="Açıklamayı giriniz"
                                    required
                                ></textarea>
                            </div>

                            <!-- Gönder Butonu -->
                            <div class="text-center">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                    Gönder
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Geçmiş Şikayetler -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h2 class="text-xl font-semibold mb-4">Geçmiş Şikayetlerim</h2>
                        @if($complaints->count() > 0)
                            <div class="max-h-[318px] overflow-y-auto"> <!-- 318px = (53px x 5 satır) + 53px başlık -->
                                <div class="space-y-4">
                                    @foreach($complaints as $complaint)
                                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h3 class="text-lg font-medium text-gray-900">{{ $complaint->title }}</h3>
                                                    <p class="mt-2 text-gray-600">{{ $complaint->description }}</p>
                                                </div>
                                                <div class="flex flex-col items-end">
                                                    <span class="text-sm text-gray-500">
                                                        {{ $complaint->created_at->format('d.m.Y H:i') }}
                                                    </span>
                                                    <span class="mt-2 px-3 py-1 text-sm rounded-full
                                                        @if($complaint->status === 'bekliyor')
                                                            bg-yellow-100 text-yellow-800
                                                        @elseif($complaint->status === 'çözüldü')
                                                            bg-green-100 text-green-800
                                                        @else
                                                            bg-red-100 text-red-800
                                                        @endif
                                                    ">
                                                        {{ ucfirst($complaint->status) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <p class="text-gray-500 text-center">Henüz şikayet/talep oluşturmadınız.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
