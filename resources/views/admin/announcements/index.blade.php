@extends('admin.layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Duyuru Yönetimi</h2>
                    <button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Yeni Duyuru Ekle
                    </button>
                </div>

                <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
                    <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                        <thead>
                            <tr class="text-left">
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Başlık</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">İçerik</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Yayın Tarihi</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Durum</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <!-- Duyuru verileri buraya dinamik olarak eklenecek -->
                            <!-- Örnek satır -->
                            <tr>
                                <td class="border-t px-6 py-4">Yurt Bakım Çalışması</td>
                                <td class="border-t px-6 py-4 max-w-md truncate">15-16 Mart tarihleri arasında su kesintisi olacaktır...</td>
                                <td class="border-t px-6 py-4">2024-03-13</td>
                                <td class="border-t px-6 py-4">
                                    <span class="px-2 py-1 text-sm rounded-full bg-blue-100 text-blue-800">Aktif</span>
                                </td>
                                <td class="border-t px-6 py-4">
                                    <div class="flex space-x-3">
                                        <button class="text-blue-600 hover:text-blue-900">Düzenle</button>
                                        <button class="text-red-600 hover:text-red-900">Sil</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
