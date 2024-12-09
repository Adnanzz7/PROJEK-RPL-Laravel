<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PKK Market')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="public/favicon.ico" href="{{ asset('favicon.ico') }}" type="image/x-icon">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <!-- Brand Name -->
            <a class="navbar-brand" href="{{ route('barangs.index') }}">PKK Market</a>
            
            <!-- Navbar Toggler for Mobile View -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- Check if User is Logged In -->
                    @if (Auth::check())
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <!-- User's Name -->
                            {{ Auth::user()->name }}                            
                            <!-- Display Profile Photo -->
                        </a>                        
                        <!-- Dropdown Menu -->
                        <ul class="dropdown-menu dropdown-menu-end custom-dropdown" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="#">Role: {{ auth()->user()->role }}</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <!-- Logout -->
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @if (Auth::user()->foto)
                        <img src="{{ asset('storage/' . Auth::user()->foto) }}" 
                             alt="Profile Photo" 
                             class="rounded-circle me-2" 
                             style="width: 40px; height: 40px; object-fit: cover;">
                    @else
                        <!-- Default Photo if User Has No Photo -->
                        <img src="{{ asset('default-profile.png') }}" 
                             alt="Default Photo" 
                             class="rounded-circle me-2" 
                             style="width: 40px; height: 40px; object-fit: cover;">
                    @endif
                    @else
                    <!-- Guest Links -->
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="nav-link">Register</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>    
    <div class="container mt-4 flex-grow-1">
        @yield('content')
    </div>

<!-- Footer -->
<footer class="bg-dark text-light py-4 mt-auto">
    <div class="container text-center">
        <p class="mb-0">&copy; {{ date('Y') }} PKK Market. All rights reserved.</p>
        <h5>
            <!-- Contact Icon -->
            <a href="mailto:info@smkn8jakarta.sch.id" class="text-light mx-1" title="Contact">
                <i class="fas fa-envelope"></i>
            </a>
            <!-- Social Media Icons -->
            <a href="https://www.youtube.com/@Smkn8jkt" class="text-light mx-1" target="" title="YouTube">
                <i class="fab fa-youtube"></i>
            </a>
            <a href="https://www.facebook.com/smkn8jktofficial" class="text-light mx-1" target="" title="Facebook">
                <i class="fab fa-facebook"></i>
            </a>
            <a href="https://www.instagram.com/delapanjkt" class="text-light mx-1" target="" title="Instagram">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="https://x.com/smkn8jkt" class="text-light mx-1" target="" title="X (formerly Twitter)">
                <i class="fab fa-x-twitter"></i>
            </a>
            <a href="https://wa.me/6285930415248" class="text-light mx-1" target="" title="WhatsApp">
                <i class="fab fa-whatsapp"></i>
            </a>
        </h5>
    </div>
</footer>

    <style>
        body.bg-image {
        font-family: 'Poppins', sans-serif;
        background-image: url('{{ asset('storage/bg.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }
    /* Mengubah warna latar belakang dropdown menjadi warna Bootstrap */
    .custom-dropdown {
        background-color: var(--bs-dark) !important; /* Warna gelap dari Bootstrap */
        border: none;
    }

    /* Mengubah warna teks di dalam dropdown menjadi putih */
    .custom-dropdown .dropdown-item {
        color: var(--bs-light) !important; /* Warna terang dari Bootstrap */
    }

    /* Mengubah warna teks saat hover menjadi lebih terang */
    .custom-dropdown .dropdown-item:hover {
        background-color: var(--bs-secondary) !important; /* Warna sekunder dari Bootstrap */
        color: var(--bs-light) !important; /* Tetap putih saat hover */
    }

    /* Mengubah warna divider menjadi abu-abu */
    .custom-dropdown .dropdown-divider {
        border-color: var(--bs-gray-600) !important; /* Warna abu-abu gelap dari Bootstrap */
    }
/* Pastikan body dan html menggunakan flexbox untuk tata letak penuh */
html, body {
    height: 100%; /* Pastikan tinggi halaman mencakup seluruh layar */
    display: flex;
    flex-direction: column; /* Susun elemen dalam kolom */
    margin: 0;
    padding: 0;
}

/* Kontainer utama yang memuat konten */
.container {
    flex-grow: 1; /* Konten ini akan meluas untuk memenuhi ruang kosong */
}

/* Footer */
footer {
    background-color: #343a40;
    color: #ffffff;
    padding: 20px 0; /* Berikan padding untuk estetika */
    text-align: center;
    width: 100%; /* Pastikan footer mencakup seluruh lebar layar */
}

footer a {
    color: #ffffff;
    text-decoration: none;
}

footer a:hover {
    text-decoration: underline;
}

    </style>

    <!-- Add Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>