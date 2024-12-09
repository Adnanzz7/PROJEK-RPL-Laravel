@extends('layouts.app')

@section('content')
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-gradient bg-primary text-white text-center py-4">
                        <h2 class="fw-bold">Edit Barang</h2>
                    </div>
                    <div class="card-body p-5">
                        <form action="{{ route('barangs.update', $barang) }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                            @csrf
                            @method('PUT')

                            <!-- Nama Barang -->
                            <div class="mb-4">
                                <label for="nama_barang" class="form-label fw-bold">Nama Barang</label>
                                <input type="text" name="nama_barang" id="nama_barang" class="form-control rounded-pill shadow-sm" value="{{ old('nama_barang', $barang->nama_barang) }}" required>
                            </div>

                            <!-- Harga Barang -->
                            <div class="mb-4">
                                <label for="harga_barang" class="form-label fw-bold">Harga Barang</label>
                                <input type="number" name="harga_barang" id="harga_barang" class="form-control rounded-pill shadow-sm" value="{{ old('harga_barang', $barang->harga_pokok + 1000) }}" required oninput="updateHarga()">
                                <small class="form-text text-muted">Harga sebelum pajak</small>
                            </div>

                            <!-- Harga Setelah Pajak -->
                            <div class="mb-4">
                                <label for="harga_dengan_pajak" class="form-label fw-bold">Harga Setelah Pajak</label>
                                <input type="text" id="harga_dengan_pajak" class="form-control rounded-pill shadow-sm bg-light text-dark" readonly value="{{ old('harga_dengan_pajak', $barang->harga_pokok + 2000) }}">
                                <small class="form-text text-muted">Harga setelah pajak (Rp. 1000)</small>
                            </div>

                            <!-- Jumlah Barang -->
                            <div class="mb-4">
                                <label for="jumlah_barang" class="form-label fw-bold">Jumlah Barang</label>
                                <input type="number" name="jumlah_barang" id="jumlah_barang" class="form-control rounded-pill shadow-sm" value="{{ old('jumlah_barang', $barang->jumlah_barang) }}" required>
                            </div>

                            <!-- Foto Barang -->
                            <div class="mb-4">
                                <label for="foto_barang" class="form-label fw-bold">Foto Barang</label>
                                <input type="file" name="foto_barang" id="foto_barang" class="form-control shadow-sm">
                                <div class="mt-3">
                                    <p class="mb-2 fw-bold">Foto Saat Ini:</p>
                                    <img src="{{ asset('storage/' . $barang->foto_barang) }}" alt="{{ $barang->nama_barang }}" class="img-thumbnail rounded shadow-lg" style="width: 150px;">
                                </div>
                            </div>

                            <!-- Tombol Kembali dan Update -->
                            <div class="d-flex justify-content-between mt-4">
                                <!-- Tombol Kembali -->
                                <a href="{{ route('barangs.index') }}" class="btn btn-secondary btn-lg rounded-pill shadow">
                                    <i class="bi bi-arrow-left-circle"></i> Kembali
                                </a>

                                <!-- Tombol Update -->
                                <button type="submit" class="btn btn-success btn-lg rounded-pill shadow">
                                    <i class="bi bi-save"></i> Update Barang
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
    <script>
    function updateHarga() {
        var hargaBarang = parseFloat(document.getElementById('harga_barang').value);
        var pajak = 1000;  // Pajak yang ingin ditambahkan
        var hargaDenganPajak = hargaBarang + pajak;

        // Menampilkan harga setelah pajak tanpa desimal
        document.getElementById('harga_dengan_pajak').value = hargaDenganPajak.toFixed(0); // Menghilangkan desimal
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
body {
    font-family: 'Poppins', sans-serif;
    background-image: url('{{ asset('storage/bg.jpg') }}');
    background-size: cover;  /* Membuat gambar memenuhi layar */
    background-position: center;  /* Memastikan gambar ditempatkan di tengah */
    min-height: 100vh;  /* Pastikan body memiliki tinggi minimal 100% dari tinggi layar */
    display: flex;
    flex-direction: column;
}

    .card-header {
        background: linear-gradient(45deg, #007bff, #6c757d);
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    .card {
        border-radius: 15px;
    }

    .form-control {
        border: 1px solid #ced4da;
        transition: box-shadow 0.3s ease-in-out;
    }

    .form-control:focus {
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.8);
        border-color: #007bff;
    }

    .btn {
        transition: all 0.3s ease-in-out;
    }

    .btn:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-lg {
        padding: 10px 25px;
        font-size: 1.2rem;
    }

    .d-flex {
        gap: 10px; /* Spasi antara tombol */
    }
    </style>
</body>
@endsection
