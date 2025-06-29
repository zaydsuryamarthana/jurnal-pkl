 <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav" style="background-color: #fff;">
     <div class="container">
         <a class="navbar-brand fw-bold" href="#page-top">Jurnal Magang</a>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
             aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
             <i class="bi-list"></i>
         </button>
         <div class="collapse navbar-collapse" id="navbarResponsive">
             @guest
                 <ul class="navbar-nav ms-auto my-3 my-lg-0 mx-auto">
                     <li class="nav-item"><a class="nav-link me-lg-3" href="index.php">Beranda</a></li>
                     <li class="nav-item"><a class="nav-link me-lg-3" href="#">Programs</a></li>
                     <li class="nav-item"><a class="nav-link me-lg-3" href="#">FAQ</a></li>
                 </ul>
                 <ul class="navbar-nav">
                     <div class="dropdown">
                         <a class="btn btn-primary rounded-pill px-4 mb-2 mb-lg-0" href="{{ route('login') }}"
                             role="button">
                             <span class="small">Login</span>
                         </a>
                         <a class="btn btn border-primary rounded-pill px-4 mb-2 mb-lg-0" href="{{ route('signup') }}"
                             role="button">
                             <span class="small" style="color:#0D6EFD;">Signup</span>
                         </a>
                     </div>
                 </ul>
             @endguest
             @auth
                 <ul class="navbar-nav ms-auto my-3 my-lg-0 mx-auto">
                     @if (auth()->user()->verification)
                         <li class="nav-item"><a class="nav-link me-lg-3" href="/beranda">Beranda</a></li>
                         <li class="nav-item"><a class="nav-link me-lg-3" href="/absen">Presensi</a></li>
                         <li class="nav-item"><a class="nav-link me-lg-3" href="/laporan">Laporan</a></li>
                         <li class="nav-item"><a class="nav-link me-lg-3" href="/jadwal">Jadwal</a></li>
                     @else
                     @endif
                 </ul>

                 <ul class="navbar-nav">
                     <div class="dropdown">
                         <a class="btn btn-primary rounded-pill px-3 mb-2 mb-lg-0 dropdown-toggle" href="#"
                             role="button" data-bs-toggle="dropdown" aria-expanded="false">
                             <i class="bi bi-person-circle"></i>
                             <span class="small">&nbsp;{{ Auth::user()->nama }}</span>
                         </a>
                         <ul class="dropdown-menu animated--fade-in" style="width: 100%;">
                             @if (auth()->user()->verification)
                                 <li><a class="dropdown-item" href="{{ route('indexProfil') }}">
                                         <i class="bi bi-person"></i>&nbsp;&nbsp;Profil
                                     </a>
                                 </li>
                                 <div class="position-relative ">
                                     <hr class="text-secondary">
                                     <div class="divider-content-center">
                                     </div>
                                 </div>
                                 <li>
                                     <form action="{{ route('logout') }}" method="post">
                                         @csrf
                                         <button class="dropdown-item pb-3" role="button" type="submit"><i
                                                 class="bi bi-box-arrow-left"></i>&nbsp;&nbsp;Log Out</button>
                                     </form>
                                 </li>
                             @else
                                 <li>
                                     <form action="{{ route('logout') }}" method="post">
                                         @csrf
                                         <button class="dropdown-item pb-3" role="button" type="submit"><i
                                                 class="bi bi-box-arrow-left"></i>&nbsp;&nbsp;Log Out</button>
                                     </form>
                                 </li>
                             @endif
                         </ul>
                     </div>
                 </ul>
             @endauth

         </div>
     </div>
 </nav>
