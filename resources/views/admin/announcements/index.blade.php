@extends('admin.layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Duyuru Yönetimi</h2>
                        <button type="button" onclick="openAnnouncementModal()" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Yeni Duyuru Ekle
                        </button>
                    </div>

                    <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
                        <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                            <thead>
                            <tr class="text-left">
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Başlık</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">İçerik</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Başlangıç Tarihi</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Bitiş Tarihi</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Durum</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">İşlemler</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                            @foreach($announcements as $announcement)
                            <tr>
                                <td class="border-t px-6 py-4">
                                    {{ $announcement->title }}
                                </td>
                                <td class="border-t px-6 py-4">
                                    {{ Str::limit($announcement->content, 50) }}
                                </td>
                                <td class="border-t px-6 py-4">
                                    {{ \Carbon\Carbon::parse($announcement->start_date)->format('Y-m-d') }}
                                </td>
                                <td class="border-t px-6 py-4">
                                    {{ \Carbon\Carbon::parse($announcement->end_date)->format('Y-m-d') }}
                                </td>
                                <td class="border-t px-6 py-4">
                                    @if ($announcement->status == 'Aktif')
                                        <span class="px-2 py-1 text-sm rounded-full bg-green-100 text-green-800">
                                            {{ $announcement->status }}
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-sm rounded-full bg-red-100 text-red-800">
                                            {{ $announcement->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="border-t px-6 py-4">
                                    <div class="flex space-x-3">
                                        <button type="button" onclick="openEditModal({{ $announcement->id }})" class="text-blue-600 hover:text-blue-900">
                                            Düzenle
                                        </button>
                                        <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Emin misiniz?')">
                                                Sil
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Yeni Duyuru Ekleme Modal -->
    <div id="announcementModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Yeni Duyuru Ekle</h3>
                <form action="/admin/announcements" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Başlık</label>
                        <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-gray-700">İçerik</label>
                        <textarea name="content" id="content" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Başlangıç Tarihi</label>
                        <input type="date" name="start_date" id="start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="end_date" class="block text-sm font-medium text-gray-700">Bitiş Tarihi</label>
                        <input type="date" name="end_date" id="end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Durum</label>
                        <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Durum Seçin</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Pasif">Pasif</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeAnnouncementModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            İptal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Kaydet
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Duyuru Düzenleme Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Duyuru Düzenle</h3>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="edit_title" class="block text-sm font-medium text-gray-700">Başlık</label>
                        <input type="text" name="title" id="edit_title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="edit_content" class="block text-sm font-medium text-gray-700">İçerik</label>
                        <textarea name="content" id="edit_content" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="edit_start_date" class="block text-sm font-medium text-gray-700">Başlangıç Tarihi</label>
                        <input type="date" name="start_date" id="edit_start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="edit_end_date" class="block text-sm font-medium text-gray-700">Bitiş Tarihi</label>
                        <input type="date" name="end_date" id="edit_end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="edit_status" class="block text-sm font-medium text-gray-700">Durum</label>
                        <select name="status" id="edit_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Durum Seçin</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Pasif">Pasif</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            İptal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Güncelle
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    function openAnnouncementModal() {
        document.getElementById('announcementModal').classList.remove('hidden');
    }

    function closeAnnouncementModal() {
        document.getElementById('announcementModal').classList.add('hidden');
    }

    function openEditModal(announcementId) {
        // Duyuru bilgilerini getir
        fetch(`/admin/announcements/${announcementId}`)
            .then(response => response.json())
            .then(data => {
                // Form alanlarını doldur
                document.getElementById('edit_title').value = data.title;
                document.getElementById('edit_content').value = data.content;
                document.getElementById('edit_start_date').value = data.start_date;
                document.getElementById('edit_end_date').value = data.end_date;
                document.getElementById('edit_status').value = data.status;

                // Form action'ını güncelle
                document.getElementById('editForm').action = `/admin/announcements/${announcementId}`;

                // Modal'ı göster
                document.getElementById('editModal').classList.remove('hidden');
            });
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    // Modal dışına tıklandığında kapatma
    window.onclick = function(event) {
        const announcementModal = document.getElementById('announcementModal');
        const editModal = document.getElementById('editModal');
        
        if (event.target == announcementModal) {
            closeAnnouncementModal();
        }
        if (event.target == editModal) {
            closeEditModal();
        }
    }
    </script>
@endsection
