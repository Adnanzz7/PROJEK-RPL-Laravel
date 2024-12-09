@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" href="{{ asset('path/to/your/styles.css') }}">
</head>
<body>
<div class="container container-form">
    <h1>Tambah Barang</h1>
    <form action="{{ route('barangs.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
        @csrf
        <div class="mb-4">
            <label for="nama_barang" class="form-label">Nama Barang</label>
            <input type="text" name="nama_barang" id="nama_barang" class="form-control input-field" value="{{ old('nama_barang') }}" required>
        </div>
        <div class="mb-4">
            <label for="harga_barang" class="form-label">Harga Barang</label>
            <input type="number" name="harga_barang" id="harga_barang" class="form-control input-field" value="{{ old('harga_barang') }}" required oninput="updateHarga()">
            <small class="form-text text-muted">Belum termasuk pajak sebesar Rp. 1000</small>
        </div>
        <div class="mb-4">
            <label for="harga_dengan_pajak" class="form-label">Harga Setelah Pajak</label>
            <input type="text" id="harga_dengan_pajak" class="form-control input-field" readonly value="{{ old('harga_barang') }}">
        </div>
        <div class="mb-4">
            <label for="jumlah_barang" class="form-label">Jumlah Barang</label>
            <input type="number" name="jumlah_barang" id="jumlah_barang" class="form-control input-field" value="{{ old('jumlah_barang') }}" required>
        </div>
        <div class="mb-4">
            <label for="foto_barang" class="form-label">Foto Barang</label>
            <input type="file" name="foto_barang" id="foto_barang" class="form-control" required>
        </div>
        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary" onclick="history.back()">Kembali</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
</body>
<script>
    function updateHarga() {
        var hargaBarang = document.getElementById('harga_barang').value;
        var pajak = 1000;  // Pajak yang ingin ditambahkan
        var hargaDenganPajak = parseFloat(hargaBarang) + pajak;

        // Menampilkan harga setelah pajak
        document.getElementById('harga_dengan_pajak').value = hargaDenganPajak;
    }

    function validateForm() {
        var hargaBarang = parseFloat(document.getElementById('harga_barang').value);
        var jumlahBarang = parseInt(document.getElementById('jumlah_barang').value);

        // Validasi harga barang tidak boleh kurang dari 0
        if (hargaBarang < 0) {
            alert("Harga barang tidak boleh kurang dari 0");
            return false;
        }

        // Validasi jumlah barang tidak boleh kurang dari 1
        if (jumlahBarang < 1) {
            alert("Jumlah barang tidak boleh kurang dari 1");
            return false;
        }

        return true;
    }
</script>

<style>
/* Khusus untuk halaman ini */
body {
    background-image: url('{{ asset('storage/bg.jpg') }}');
    background-size: cover;
    background-repeat: repeat;
    background-position: center;
    height: 100vh;  /* Pastikan gambar meng-cover seluruh layar */
    margin: 0; /* Hilangkan margin untuk body */
}

.container-form {
    position: relative; /* Agar dapat menggunakan z-index */
    z-index: 2; /* Pastikan container tetap di atas background */
    max-width: 700px;
    background: #ffffff; /* Tetap putih */
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.container-form:hover {
    box-shadow: 0 12px 36px rgba(0, 0, 0, 0.15);
}

/* Judul Halaman */
.container-form h1 {
    text-align: center;
    font-size: 2.2rem;
    color: #333;
    margin-bottom: 30px;
    font-weight: 700;
    letter-spacing: 1px;
}

/* Form Styles */
.container-form form .mb-4 {
    margin-bottom: 25px;
}

.container-form label {
    font-weight: bold;
    color: #555;
    margin-bottom: 8px;
    display: block;
}

.container-form input[type="text"],
.container-form input[type="number"],
.container-form input[type="file"],
.container-form textarea {
    width: 100%;
    padding: 14px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f9f9f9;
    font-size: 15px;
    transition: all 0.3s ease;
}

.container-form input:focus {
    border-color: #007bff;
    background-color: #fff;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
    outline: none;
}

/* Tooltip or Helper Text */
.container-form .form-text {
    color: #6c757d;
    font-size: 13px;
    margin-top: 5px;
}

/* Button Styles */
.container-form .btn-primary {
    background: linear-gradient(45deg, #007bff, #0056b3);
    color: white;
    border: none;
    padding: 12px 25px;
    font-size: 16px;
    border-radius: 30px;
    cursor: pointer;
    font-weight: bold;
    letter-spacing: 1px;
    transition: all 0.3s ease;
}

.container-form .btn-primary:hover {
    background: linear-gradient(45deg, #0056b3, #003d80);
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}

.container-form .btn-primary:active {
    transform: translateY(0);
    box-shadow: none;
}

/* Button Kembali */
.container-form .btn-secondary {
    background-color: #6c757d;
    color: white;
    border-radius: 30px;
    padding: 12px 25px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.container-form .btn-secondary:hover {
    background-color: #5a6268;
    transform: translateY(-2px);
}

/* Custom File Input */
.container-form input[type="file"] {
    background: #ffffff;
    border: 2px dashed #ddd;
    cursor: pointer;
    padding: 15px;
    text-align: center;
    transition: all 0.3s ease;
}

.container-form input[type="file"]:hover {
    border-color: #007bff;
    background: #f1f1f1;
}

/* Responsive Design */
@media (max-width: 768px) {
    .container-form {
        padding: 20px;
    }

    .container-form h1 {
        font-size: 1.8rem;
    }

    .container-form .btn-primary,
    .container-form .btn-secondary {
        font-size: 14px;
        padding: 10px 20px;
    }
}

</style>
@endsection