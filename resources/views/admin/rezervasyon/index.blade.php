@extends('admin.layouts.app')

@section('content')

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Ad Soyad</th>
            <th>Telefon</th>
            <th>E-posta</th>
            <th>Oda Türü</th>
            <th>Giriş Tarihi</th>
            <th>Kalma Süresi</th>
            <th>Durum</th>
            <th>İşlem</th>
        </tr>
        </thead>
        <tbody>
        @foreach($reservations as $rez)
            <tr>
                <td>{{ $rez->name }}</td>
                <td>{{ $rez->phone }}</td>
                <td>{{ $rez->email }}</td>
                <td>{{ ucfirst($rez->room_type) }}</td>
                <td>{{ \Carbon\Carbon::parse($rez->entry_date)->format('d.m.Y') }}</td>
                <td>{{ ucfirst($rez->stay_duration) }}</td>
                <td>
                <span class="badge bg-{{ $rez->status == 'bekliyor' ? 'warning' : ($rez->status == 'onaylandı' ? 'success' : 'danger') }}">
                    {{ ucfirst($rez->status) }}
                </span>
                </td>
                <td>
                    <a href="{{ route('admin.rezervasyon.show', $rez->id) }}" class="btn btn-sm btn-primary">Detay</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


@endsection
