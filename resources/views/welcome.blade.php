@extends('home')

@section('content')

<main class="main">

    <!-- About Section -->
    <section id="about" class="about section">

        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-7 mb-5 mb-lg-0 order-lg-2" data-aos="fade-up" data-aos-delay="400">
                    <div class="swiper init-swiper">
                        <script type="application/json" class="swiper-config">
                            {
                              "loop": true,
                              "speed": 600,
                              "autoplay": {
                                "delay": 5000
                              },
                              "slidesPerView": "auto",
                              "pagination": {
                                "el": ".swiper-pagination",
                                "type": "bullets",
                                "clickable": true
                              },
                              "breakpoints": {
                                "320": {
                                  "slidesPerView": 1,
                                  "spaceBetween": 40
                                },
                                "1200": {
                                  "slidesPerView": 1,
                                  "spaceBetween": 1
                                }
                              }
                            }
                        </script>
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="assets/img/3.png" alt="Image" class="img-fluid">
                            </div>
                            <div class="swiper-slide">
                                <img src="assets/img/2.png" alt="Image" class="img-fluid">
                            </div>
                            <div class="swiper-slide">
                                <img src="assets/img/1.png" alt="Image" class="img-fluid">
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
                <div class="col-lg-4 order-lg-1">
                    <span class="section-subtitle" data-aos="fade-up">GülNur Kız  Öğrenci Yurdu</span>
                    <h1 class="mb-4" data-aos="fade-up">
                        ÇOMÜ Kampüsü'ndeki Tek Özel Yurt

                    </h1>
                    <p data-aos="fade-up">
                        Ardes Öğrenci Yurdu, ÇOMÜ Terzioğlu Kampüsü'ndeki tek özel yurttur. Kampüs içinde konforlu yaşam ve tüm fakültelere kolay erişim imkanı.
                    </p>
                    <a href="{{ route('reservation.index') }}" class="btn btn-get-started">
                        REZERVASYON YAP
                    </a>
                </div>
            </div>
        </div>
    </section><!-- /About Section -->



                <div class="col-lg-8">
                    <div class="swiper init-swiper-tabs">
                        <script type="application/json" class="swiper-config">
                            {
                              "loop": true,
                              "speed": 600,
                              "autoHeight": true,
                              "autoplay": {
                                "delay": 5000
                              },
                              "slidesPerView": "auto",
                              "pagination": {
                                "el": ".swiper-pagination",
                                "type": "bullets",
                                "clickable": true
                              },
                              "breakpoints": {
                                "320": {
                                  "slidesPerView": 1,
                                  "spaceBetween": 40
                                },
                                "1200": {
                                  "slidesPerView": 1,
                                  "spaceBetween": 1
                                }
                              }
                            }
                        </script>

                        <script type="application/json" class="swiper-config">
                            {
                              "loop": true,
                              "speed": 600,
                              "autoplay": {
                                "delay": 5000
                              },
                              "slidesPerView": "auto",
                              "pagination": {
                                "el": ".swiper-pagination",
                                "type": "bullets",
                                "clickable": true
                              },
                              "breakpoints": {
                                "320": {
                                  "slidesPerView": 1,
                                  "spaceBetween": 40
                                },
                                "1200": {
                                  "slidesPerView": 1,
                                  "spaceBetween": 1
                                }
                              }
                            }
                        </script>


</main>


<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Preloader -->
<div id="preloader"></div>

<!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

<!-- Main JS File -->
<script src="assets/js/main.js"></script>

@endsection
