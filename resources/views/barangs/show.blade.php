@extends('layouts.app')

@section('title', 'Detail Barang')

@section('content')
<head>
    <!-- Menambahkan Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Menambahkan CSS Bootstrap untuk table -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <style>
html, body {
    height: 100%; /* Pastikan html dan body memiliki tinggi penuh */
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Poppins', sans-serif;
    background-image: url('{{ asset('storage/bg.jpg') }}');
    background-size: cover;  /* Membuat gambar memenuhi layar */
    background-position: center;  /* Memastikan gambar ditempatkan di tengah */
    background-repeat: repeat;  /* Tidak ada pengulangan gambar */
    min-height: 100vh;  /* Pastikan body memiliki tinggi minimal 100% dari tinggi layar */
    display: flex;
    flex-direction: column;
}

.page-title {
    text-align: center;
    font-size: 2rem;
    font-weight: 600;
    margin-bottom: 20px;
    color: #2c3e50;
}

.item-card {
    background-color: #ffffff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin: 20px auto;
    width: 80%;
    z-index: 1;  /* Pastikan elemen ini berada di atas gambar background */
}

.item-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 25px rgba(0, 0, 0, 0.15);
}


        .item-image {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .item-image img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 12px;
            border: 3px solid #e1e8ed;
        }

        .no-image {
            color: #7f8c8d;
            font-style: italic;
        }

        .item-name {
            font-size: 1.8rem;
            font-weight: bold;
            text-align: center;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
        }

        .table th, .table td {
            text-align: left;
            padding: 15px;
            vertical-align: middle;
            border: 1px solid #e1e8ed;
        }

        .table th {
            background-color: #f1f5f9;
            color: #34495e;
            font-weight: 600;
        }

        .table td {
            background-color: #ffffff;
            color: #2c3e50;
        }

        .table th i {
            margin-right: 10px;
            color: #3498db;
        }

        .highlight {
            font-weight: bold;
            color: #27ae60;
        }

    .back-btn {
    text-align: center;
    margin-top: 30px;
    z-index: 1; /* Pastikan tombol kembali tetap berada di atas background */
}

.btn-primary {
    background-color: #3498db;
    color: white;
    padding: 12px 25px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 1.1rem;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.btn-primary:hover {
    background-color: #1f78c1;
    transform: scale(1.05);
}
    </style>

    <div class="page-title">Detail Barang</div>

    <h3 class="item-name">Nama Pengirim: {{ $barang->user->name }}</h3>

    <div class="item-card">

        <div class="item-image">
            @if ($barang->foto_barang)
                <img src="{{ Storage::url('public/' . $barang->foto_barang) }}" alt="{{ $barang->nama_barang }}">
            @else
                <span class="no-image">Tidak ada gambar</span>
            @endif
        </div>

        <h2 class="item-name">{{ $barang->nama_barang }}</h2>

        <!-- Tabel untuk menampilkan informasi barang -->
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th><i class="bi bi-currency-dollar"></i> Harga per Satuan Awal</th>
                    <td>Rp.{{ number_format($barang->harga_barang - 1000, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <th><i class="bi bi-tag"></i> Harga per Satuan Jual</th>
                    <td>Rp.{{ number_format($barang->harga_barang, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <th><i class="bi bi-box"></i> Jumlah Barang Awal</th>
                    <td>{{ $barang->jumlah_barang_awal }}</td>
                </tr>
                <tr>
                    <th><i class="bi bi-cart-check"></i> Jumlah Barang Terjual</th>
                    <td>{{ $barang->jumlah_barang_awal - $jumlahBarangSisa }}</td>
                </tr>
                <tr>
                    <th><i class="bi bi-box-seam"></i> Jumlah Barang Sisa</th>
                    <td>{{ $jumlahBarangSisa }}</td>
                </tr>
                <tr>
                    <th><i class="bi bi-graph-up"></i> Total Harga Terjual</th>
                    <td>Rp.{{ number_format($totalHargaTerjual, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <th><i class="bi bi-wallet2"></i> Hasil Untuk Pengirim</th>
                    <td><span class="highlight">Rp.{{ number_format($totalHasilPengiriman, 2, ',', '.') }}</span></td>
                </tr>
                <tr>
                    <th><i class="bi bi-trophy"></i> Keuntungan PKK</th>
                    <td><span class="highlight">Rp.{{ number_format($keuntunganPKK, 2, ',', '.') }}</span></td>
                </tr>
            </tbody>
        </table>

    </div>

    <div class="back-btn">
        <a href="{{ route('barangs.index') }}" class="btn btn-primary">Kembali</a>
    </div>

    <br><br><br>
</body>

@endsection
