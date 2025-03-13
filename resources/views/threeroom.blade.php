@extends('home')

@section('content')



    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min2.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min2.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min2.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main2.css" rel="stylesheet">


    <!-- =======================================================
    * Template Name: QuickStart
    * Template URL: https://bootstrapmade.com/quickstart-bootstrap-startup-website-template/
    * Updated: Aug 07 2024 with Bootstrap v5.3.3
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->


    <!-- Features Section -->
    <section id="features" class="features section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Features</h2>
            <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
        </div><!-- End Section Title -->

        <div class="container">
            <div class="row justify-content-between">

                <div class="col-lg-5 d-flex align-items-center">

                    <ul class="nav nav-tabs" data-aos="fade-up" data-aos-delay="100">
                        <li class="nav-item">
                            <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#features-tab-1">
                                <i class="bi bi-binoculars"></i>
                                <div>
                                    <h4 class="d-none d-lg-block">Konforlu ve Özel Alanlar</h4>
                                    <p>
                                        Tek kişilik odalarımızda, kişisel alanınıza sahip olmanın ayrıcalığını yaşayın. Ferah ve modern tasarımıyla, huzurlu bir ortam sunuyoruz.
                                    </p>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-2">
                                <i class="bi bi-box-seam"></i>
                                <div>
                                    <h4 class="d-none d-lg-block">Tüm İhtiyaçlarınız İçin Tasarlandı</h4>
                                    <p>
                                        Odalarda çalışma masası, rahat bir yatak ve dolap gibi tüm temel ihtiyaçlarınız düşünülerek düzenlenmiştir."
                                    </p>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-3">
                                <i class="bi bi-brightness-high"></i>
                                <div>
                                    <h4 class="d-none d-lg-block">Huzurlu Bir Konaklama Deneyimi</h4>
                                    <p>
                                        Sessiz ve sakin ortamı ile verimli çalışabilir veya dinlenmenin tadını çıkarabilirsiniz.
                                    </p>
                                </div>
                            </a>
                        </li>
                    </ul><!-- End Tab Nav -->

                </div>

                <div class="col-lg-6">

                    <div class="tab-content" data-aos="fade-up" data-aos-delay="200">

                        <div class="tab-pane fade active show" id="features-tab-1">
                            <img src="assets/img/tabs-1.jpg" alt="" class="img-fluid">
                        </div><!-- End Tab Content Item -->

                        <div class="tab-pane fade" id="features-tab-2">
                            <img src="assets/img/tabs-2.jpg" alt="" class="img-fluid">
                        </div><!-- End Tab Content Item -->

                        <div class="tab-pane fade" id="features-tab-3">
                            <img src="assets/img/tabs-3.jpg" alt="" class="img-fluid">
                        </div><!-- End Tab Content Item -->
                    </div>

                </div>

            </div>

        </div>

    </section><!-- /Features Section -->

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min2.js"></script>
    <script src="assets/vendor/php-email-form/validate2.js"></script>
    <script src="assets/vendor/aos/aos2.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min2.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main2.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>



@endsection
