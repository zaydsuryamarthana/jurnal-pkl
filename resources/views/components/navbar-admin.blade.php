<nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav" style="background-color: #fff;">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#page-top">Jurnal Magang</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi-list"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto my-3 my-lg-0 mx-auto">
                <li class="nav-item"><a class="nav-link me-lg-3" href="{{ route('indexAdmin') }}">Beranda</a></li>
                <li class="nav-item"><a class="nav-link me-lg-3" href="{{ route('allAbsen') }}">Data Presensi</a></li>
                <li class="nav-item"><a class="nav-link me-lg-3" href="{{ route('allLaporan') }}">Data Laporan</a></li>
                <li class="nav-item"><a class="nav-link me-lg-3" href="{{ route('allSchedule') }}">Data Jadwal</a></li>
                <li class="nav-item"><a class="nav-link me-lg-3" href="{{ route('allPkl') }}">Data PKL</a></li>
            </ul>
            <ul class="navbar-nav">
                <div class="dropdown">
                    <a class="btn btn-primary rounded-pill px-3 mb-2 mb-lg-0 dropdown-toggle" href="#"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i>
                        <span class="small">&nbsp;{{ Auth::user()->nama }}</span>
                    </a>
                    <ul class="dropdown-menu animated--fade-in" style="width: 100%;">
                        <li>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button class="dropdown-item pb-3" role="button" type="submit"><i
                                        class="bi bi-box-arrow-left"></i>&nbsp;&nbsp;Log Out</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </ul>
        </div>
    </div>
</nav>
