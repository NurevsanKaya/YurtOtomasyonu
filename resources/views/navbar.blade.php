<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-xl position-relative d-flex align-items-center justify-content-between">


        <a href="index.html" class="logo d-flex align-items-center">

            <h1 class="sitename">GülNur.</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ url('/') }}" class="active">ANASAYFA</a></li>
                <li><a href="{{ url('/about') }}">HAKKIMIZDA</a></li>

                <li><a href="{{ url('/gallery') }}">GALERİ</a></li>

                <li class="dropdown"><a href="{{ url('/room') }}"><span>ODALAR</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        <li><a href="{{ url('/oneroom') }}">TEK KİŞİLİK</a></li>

                        <li><a href="{{ url('/tworoom') }}">İKİ KİŞİLİK</a></li>
                        <li><a href="{{ url('/threeroom') }}">ÜÇ KİŞİLİK</a></li>
                        <li><a href="{{ url('/fourroom') }}">DÖRT KİŞİLİK</a></li>
                    </ul>
                </li>
                <li><a href="{{ url('/contact') }}">İLETİŞİM</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
        <a href="{{ route('login') }}" class="btn-getstarted">Giriş Yap</a>
    </div>
</header>
