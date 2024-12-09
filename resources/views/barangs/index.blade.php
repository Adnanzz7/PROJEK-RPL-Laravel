@extends('layouts.app')

@section('title', 'Daftar Barang')

@section('content')
<head>
    <!-- Menambahkan Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="public/favicon.ico" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<style>
    /* Gaya tetap sama seperti sebelumnya */
    body {
        font-family: 'Arial', sans-serif;
        background-image: url('storage/bg.jpg');
        background-size: cover;
        background-repeat: repeat;
        background-position: center;
        height: 100vh;
        margin: 0;
        padding: 0;
    }

    .page-title {
        text-align: center;
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }

    .items-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
        padding: 20px;
    }

    .item-card {
        background-color: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .item-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .item-image {
        display: flex;
        justify-content: center;
        margin-bottom: 15px;
    }

    .item-image img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 8px;
    }

    .no-image {
        color: #bbb;
        font-style: italic;
    }

    .item-name {
        font-size: 1.2rem;
        font-weight: bold;
        text-align: center;
        color: #333;
        margin-bottom: 5px;
    }

    .item-price {
        text-align: center;
        font-size: 1rem;
        color: #e91e63;
        margin-bottom: 10px;
    }

    .item-quantity {
        text-align: center;
        font-size: 0.9rem;
        color: #757575;
        margin-bottom: 10px;
    }

    .item-sender {
        text-align: center;
        font-size: 0.9rem;
        color: #888;
        margin-bottom: 15px;
    }

    .item-actions {
        display: flex;
        justify-content: center;
        gap: 10px;
        flex-direction: column;
        align-items: center;
    }

    .btn {
        display: inline-block;
        padding: 8px 15px;
        border-radius: 4px;
        font-size: 0.9rem;
        cursor: pointer;
        text-align: center;
    }

    .add-item-btn {
    text-align: center;
    margin: 20px 0; /* Memberi jarak ke atas dan bawah */
}

.add-item-btn a {
    text-decoration: none;
    color: white;
    background: linear-gradient(45deg, #ff5722, #ff9800); /* Gradien warna menarik */
    padding: 15px 30px; /* Padding lebih besar untuk tombol besar */
    border-radius: 30px; /* Membuat tombol lebih membulat */
    font-weight: bold;
    font-size: 18px; /* Ukuran font lebih besar */
    font-family: 'Roboto', sans-serif; /* Font modern */
    text-align: center;
    letter-spacing: 1.5px; /* Memberi jarak antar huruf */
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2); /* Efek bayangan */
    transition: all 0.3s ease-in-out; /* Animasi saat hover */
}

.add-item-btn a:hover {
    background: linear-gradient(45deg, #e64a19, #f57c00); /* Gradien lebih gelap saat hover */
    box-shadow: 0 12px 20px rgba(0, 0, 0, 0.3); /* Bayangan lebih besar saat hover */
    transform: translateY(-5px); /* Efek melayang */
    color: #fff; /* Memastikan warna font tetap kontras */
}

    .btn-add:hover {
        background-color: #f74f9c;
    }

    .btn-edit {
        background-color: #FFC107;
        color: white;
        text-decoration: none;
    }

    .btn-edit:hover {
        background-color: #ffb300;
    }

    .btn-delete {
        background-color: #dc3545;
        color: white;
        border: none;
    }

    .btn-delete:hover {
        background-color: #c82333;
    }

    .btn-buy {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 8px 15px;
        font-size: 0.9rem;
        cursor: pointer;
        border-radius: 4px;
    }

    .btn-buy:hover {
        background-color: #218838;
    }

    .buy-input {
        width: 80px;
        text-align: center;
        padding: 5px;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    .buy-form {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    /* Tombol keranjang - Pojok kanan bawah */
    .cart-btn {
        position: fixed;
        bottom: 20px; /* Lebih bawah sedikit */
        right: 20px; /* Di pojok kanan */
        z-index: 999;
        text-align: center;
    }

    .cart-btn a {
        text-decoration: none;
        color: white;
        background-color: #007bff;
        padding: 10px 20px;
        border-radius: 5px;
    }

    .cart-btn a:hover {
        background-color: #0056b3;
    }

    .cart-count {
        background-color: #ff4747;
        color: white;
        font-size: 1rem;
        padding: 5px 10px;
        border-radius: 50%;
        position: absolute;
        top: -5px;
        right: -5px;
        transform: translate(50%, -50%);
    }

    /* Notifikasi */
    .alert {
        margin-top: 20px;
        padding: 15px;
        border-radius: 5px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }

    /* Gaya untuk running text */
    .running-text {
    color: black;
    padding: 30px 0;
    text-align: center;
    font-size: 1.3rem;
    font-weight: bold;
    white-space: nowrap;
    width: 90%;
    overflow: hidden;
    position: relative;
    }

    .running-text span {
        position: relative;
        animation: scrollText 10s linear infinite;
    }

    /* Animasi untuk running text */
    @keyframes scrollText {
        0% {
            left: 100%;
        }
        100% {
            left: -70%;
        }
    }
</style>

<div class="running-text">
    <span>Jam Buka: 09:00 - Jam Tutup: 13:00</span>
</div>

<h1 class="page-title">Daftar Produk Kreatif dan Kewirausahaan</h1>

<!-- Menampilkan notifikasi jika ada pesan flash -->
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@auth
    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'supplier')
        <!-- Tombol tambah barang hanya untuk admin dan supplier -->
        <div class="add-item-btn">
            <a href="{{ route('barangs.create') }}" class="btn btn-add">Tambah Barang</a>
        </div>
    @endif
@endauth

<div class="items-container">
    @foreach ($barangs as $barang)
        <div class="item-card">
            <!-- Menambahkan gambar barang -->
            <div class="item-image">
                @if ($barang->foto_barang)
                    <div class="triangle-badge-container">
                        @if ($barang->jumlah_barang == 0)
                            <div class="triangle-badge bg-danger">
                                <span>Habis</span>
                            </div>
                        @else
                            <div class="triangle-badge bg-success">
                                <span>Tersedia</span>
                            </div>
                        @endif
                    </div>
                    <img src="{{ Storage::url('public/' . $barang->foto_barang) }}" alt="{{ $barang->nama_barang }}">
                @else
                    <span class="no-image">Tidak ada gambar</span>
                @endif
            </div>

            <!-- Konten Barang -->
            <h3 class="item-name">{{ $barang->nama_barang }}</h3>
            <p class="item-price">Rp.{{ number_format($barang->harga_barang, 2, ',', '.') }}</p>
            <p class="item-quantity">{{ $barang->jumlah_barang }} tersisa</p>

            <!-- Nama Pengirim -->
            <p class="item-sender">Pengirim: {{ $barang->user->name }}</p>

            <!-- Aksi Edit dan Hapus -->
            <div class="item-actions d-flex justify-content-start gap-2">
                @auth
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('barangs.show', $barang->id) }}" class="btn btn-info">Detail</a>
                    @endif
                @endauth

                @auth
                    @if (Auth::user()->role === 'admin' || (Auth::user()->role === 'supplier' && Auth::id() === $barang->user_id))
                        <a href="{{ route('barangs.edit', $barang->id) }}" class="btn btn-edit">Edit</a>
                        <form action="{{ route('barangs.destroy', $barang->id) }}" method="POST" class="delete-form d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete">Hapus</button>
                        </form>
                    @endif
                @endauth

                @auth
                    @if (Auth::user()->role === 'user')
                        <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="id" value="{{ $barang->id }}">
                            <input type="hidden" name="name" value="{{ $barang->nama_barang }}">
                            <input type="hidden" name="price" value="{{ $barang->harga_barang }}">
                            <input type="hidden" name="foto_barang" value="{{ $barang->foto_barang }}">
                            <div class="input-group" style="width: 150px;">
                                <input type="number" name="quantity" class="form-control" min="1" max="{{ $barang->jumlah_barang }}" placeholder="Jumlah" required>
                                <button type="submit" class="btn-buy btn btn-success">+</button>
                            </div>
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    @endforeach
</div>

@auth
    @if (Auth::user()->role === 'user')
        <div class="cart-btn">
            <a href="{{ route('cart.index') }}" class="cart-link">
                <i class="fas fa-shopping-cart"></i> {{-- Ikon keranjang --}}
                <span class="cart-count">{{ session('cart.count', 0) }}</span>
            </a>
        </div>
    @endif
@endauth


<!-- Tombol Tutorial -->
<div class="tutorial-btn">
    <a href="#" data-bs-toggle="modal" data-bs-target="#tutorialModal">Tutorial</a>
</div>

<!-- Modal untuk Tutorial -->
<div class="modal fade" id="tutorialModal" tabindex="-1" aria-labelledby="tutorialModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tutorialModalLabel">Panduan Penggunaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ol>
                    <li><strong>Register:</strong> Klik tombol <b>Register</b> untuk membuat akun, lalu pilih Role User.</li>
                    <li><strong>Login:</strong> Masuk menggunakan akun yang telah didaftarkan.</li>
                    <li><strong>Pilih Barang:</strong> Cari barang yang ingin Anda beli, isi jumlahnya, lalu klik tombol <b>+</b>.</li>
                    <li><strong>Keranjang:</strong> Klik tombol <b><i class="fas fa-shopping-cart"></i></b> di pojok kanan bawah untuk melihat barang yang telah Anda pilih.</li>
                    <li><strong>Checkout:</strong> Setelah memeriksa barang di keranjang, lanjutkan ke proses <b>Checkout</b>.</li>
                    <li><strong>Pembayaran:</strong> Gunakan <b>QR Code</b> yang diberikan untuk menyelesaikan pembayaran.</li>
                </ol>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
.tutorial-btn {
    position: absolute;
    top: 80px; /* Di bawah navbar */
    right: 20px; /* Posisi sisi kanan layar */
    z-index: 999;
    animation: fadeIn 1s ease-in-out;
}

.tutorial-btn a {
    text-decoration: none;
    color: white;
    background: linear-gradient(45deg, #1e88e5, #6ab7ff); /* Warna gradien yang lebih mencolok */
    padding: 15px 25px; /* Ukuran padding lebih besar */
    border-radius: 30px; /* Membuat tombol lebih membulat */
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2); /* Efek bayangan lebih besar */
    transition: all 0.3s ease;
    font-weight: bold;
    font-size: 16px; /* Ukuran font lebih besar */
    font-family: 'Roboto', sans-serif; /* Font modern */
    text-align: center;
    letter-spacing: 1px; /* Memberi jarak antar huruf */
}

.tutorial-btn a:hover {
    background: linear-gradient(45deg, #1565c0, #4fc3f7); /* Gradien lebih gelap saat hover */
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3); /* Memperbesar bayangan saat hover */
    transform: translateY(-5px); /* Memberikan efek melayang lebih signifikan */
    color: #fff; /* Memastikan warna font tetap kontras */
}
.modal-content {
    border-radius: 20px; /* Membuat sudut modal lebih melengkung */
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3); /* Efek bayangan modal */
    overflow: hidden; /* Menjaga konten tetap rapi */
    animation: zoomIn 0.6s ease-in-out;
    background: linear-gradient(to bottom, #ffffff, #f9f9f9); /* Gradien latar modal */
    padding: 20px;
    font-family: 'Poppins', sans-serif; /* Font modern */
    color: #333; /* Warna teks */
}

.modal-header {
    background: linear-gradient(45deg, #1e88e5, #6ab7ff); /* Gradien warna header */
    color: white;
    text-align: center;
    padding: 20px;
    border-bottom: 3px solid #1565c0; /* Menambahkan batas */
    font-size: 20px;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 1.5px; /* Memberi jarak antar huruf */
}

.modal-title {
    font-family: 'Roboto Slab', serif; /* Memberikan kesan elegan */
}

.modal-body {
    font-size: 16px;
    color: #444;
    line-height: 1.8; /* Memberikan ruang antar baris */
    text-align: justify;
    margin: 15px 0;
    position: relative;
}

.modal-body ul {
    padding-left: 20px;
    margin-top: 10px;
}

.modal-body ul li {
    list-style: disc;
    margin-bottom: 10px;
}

.modal-body ul li::marker {
    color: #1e88e5; /* Warna ikon bullet */
    font-size: 1.3rem;
}

.modal-body strong {
    color: #1565c0; /* Warna teks yang ditebalkan */
}

.item-actions {
    display: flex;
    justify-content: flex-start;
    gap: 10px; /* Spasi antar tombol */
}

.item-actions .btn {
    padding: 8px 15px;
    font-size: 14px;
}

.item-actions .btn-buy {
    padding: 8px 12px;
    font-size: 16px;
}

.modal-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    border-top: 1px solid #ddd;
    background: #f1f5f9;
}

.modal-footer .btn {
    padding: 10px 20px;
    font-size: 15px;
    border-radius: 25px;
    font-family: 'Poppins', sans-serif;
    font-weight: bold;
    transition: all 0.3s ease;
    cursor: pointer;
    border: none;
}

.modal-footer .btn-close {
    background: linear-gradient(45deg, #ff5252, #ff1744); /* Gradien tombol tutup */
    color: white;
}

.modal-footer .btn-close:hover {
    background: linear-gradient(45deg, #d50000, #b71c1c);
    transform: translateY(-3px);
}

.modal-footer .btn-next {
    background: linear-gradient(45deg, #4caf50, #66bb6a); /* Gradien tombol selanjutnya */
    color: white;
}

.modal-footer .btn-next:hover {
    background: linear-gradient(45deg, #388e3c, #43a047);
    transform: translateY(-3px);
}

/* Animasi */
@keyframes zoomIn {
    from {
        transform: scale(0.8);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}

.item-image {
    position: relative;
    border-radius: 10px;
    overflow: hidden;
}

.triangle-badge-container {
    position: absolute;
    top: 0;
    left: 0;
    width: 0;
    height: 0;
    z-index: 10;
    overflow: visible;
}

.triangle-badge {
    position: absolute;
    top: 0;
    left: 0;
    width: 70px;
    height: 70px;
    background: transparent;
    clip-path: polygon(0 0, 100% 0, 0 100%);
    color: white;
    font-size: 10px;
    font-weight: bold;
    text-align: center;
    line-height: 40px;
    transform: translateX(-10px) translateY(-10px); /* Untuk menyesuaikan agar lebih keluar dari gambar */
}

.triangle-badge span {
    position: absolute;
    top: 28px; /* Posisi teks di segitiga */
    left: 3px;
    transform: rotate(-45deg); /* Memiringkan tulisan */
    transform-origin: top left; /* Titik rotasi di kiri atas */
    font-style: italic; /* Membuat teks miring */
    white-space: nowrap; /* Mencegah teks pecah ke baris baru */
}

.bg-danger {
    background-color: #dc3545;
}

.bg-success {
    background-color: #28a745;
}
</style>

@endsection
