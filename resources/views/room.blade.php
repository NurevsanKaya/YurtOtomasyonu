
@extends('Home')
@section('content')

    @vite('resources/js/room.js')
    @vite('resources/css/room.css')
    <br>
    <br>
    <br>
    <br>
    <header>
        <h1>Odalarımız</h1>
        <p>Konforlu ve modern odalarımızı keşfedin.</p>
    </header>
    <main>
        <section class="room-list">
            <div class="room-card">
                <img src="oda1.jpg" alt="Oda 1">
                <h2>Tek Kişilik Oda</h2>
                <p>Geniş ve konforlu tek kişilik oda.</p>
                <button class="view-details" onclick="window.location.href='{{ url('/oneroom') }}'">Detayları Gör</button>


            </div>
            <div class="room-card">
                <img src="oda1.jpg" alt="Oda 2">
                <h2>İki Kişilik Özel Oda</h2>
                <p> 2 kişilik özel odaları, konfor ve işlevselliği bir arada sunarak öğrencilerin ihtiyaçlarını en üst düzeyde karşılıyor.</p>
                <button class="view-details" onclick="window.location.href='{{ url('/tworoom') }}'">Detayları Gör</button>


            </div>
            <div class="room-card">
                <img src="oda1.jpg" alt="Oda 3">
                <h2>Üç Kişilik Oda</h2>
                <p>asasaa.</p>
                <button class="view-details" onclick="window.location.href='{{ url('/threeroom') }}'">Detayları Gör</button>

            </div>
            <div class="room-card">
                <img src="oda1.jpg" alt="Oda 1">
                <h2>Dört Kişilik Oda</h2>
                <p>Geniş ve konforlu tek kişilik oda.</p>
                <a href="{{ url('/fourroom') }}" class="view-details">Detayları Gör</a>

            </div>
        </section>
    </main>





@endsection
