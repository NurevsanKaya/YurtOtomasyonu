@extends('Home')

<br>
<br>
<br>
@section('content')
    @vite('resources/js/gallery.js')
    @vite('resources/css/gallery.css')
    <section class="gallery py-5">
        <div class="container">
            <h2 class="text-center fw-bold mb-4">Galeri</h2>

            <!-- Filtreleme Butonları -->
            <div class="text-center mb-4">
                <button class="btn btn-primary filter-btn" data-filter="all">Tümü</button>
                <button class="btn btn-outline-primary filter-btn" data-filter="odalar">Odalar</button>
                <!--<button class="btn btn-outline-primary filter-btn" data-filter="yemekler">Yemekler</button>-->
                <button class="btn btn-outline-primary filter-btn" data-filter="ortak-alanlar">Ortak Alanlar</button>
            </div>

            <!-- Galeri Resimleri -->
            <div class="row">
                <div class="col-md-4 gallery-item odalar">
                    <img src="https://www.ardesogrenciyurdu.com/wp-content/uploads/2024/07/37.webp" class="img-fluid rounded shadow">
                </div>
                <!--
                <div class="col-md-4 gallery-item yemekler">
                    <img src="https://www.ardesogrenciyurdu.com/wp-content/uploads/2024/07/37.webp" class="img-fluid rounded shadow">
                </div>-->
                <div class="col-md-4 gallery-item ortak-alanlar">
                    <img src="https://www.ardesogrenciyurdu.com/wp-content/uploads/2024/07/37.webp" class="img-fluid rounded shadow">
                </div>

                <div class="col-md-4 gallery-item odalar">
                    <img src="https://www.ardesogrenciyurdu.com/wp-content/uploads/2024/07/37.webp" class="img-fluid rounded shadow">
                </div>
                <!--
               <div class="col-md-4 gallery-item yemekler">
                   <img src="https://www.ardesogrenciyurdu.com/wp-content/uploads/2024/07/37.webp" class="img-fluid rounded shadow">
               </div>-->
                <div class="col-md-4 gallery-item ortak-alanlar">
                    <img src="https://www.ardesogrenciyurdu.com/wp-content/uploads/2024/07/37.webp" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

@endsection




