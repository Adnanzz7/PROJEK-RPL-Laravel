@extends('layouts.app')

@section('title', 'Pembayaran Berhasil')

@section('content')
<style>
    body {
        background-image: url('storage/bg.jpg');
        background-size: cover;
        background-repeat: repeat;
        background-position: center;
    }

    .container {
        margin-top: 50px;
    }

    .card {
        border-radius: 15px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        padding: 20px;
        background-color: #ffffff;
        border: none;
        position: relative;
    }

    .btn {
        border-radius: 8px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.4);
    }

    .btn-primary:hover {
        background-color: #0056b3;
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(0, 123, 255, 0.6);
    }

    .btn-success {
        background-color: #28a745;
        color: white;
        box-shadow: 0 4px 10px rgba(40, 167, 69, 0.4);
    }

    .btn-success:hover {
        background-color: #218838;
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(40, 167, 69, 0.6);
    }

    .text-center h2 {
        font-family: 'Roboto', sans-serif;
        color: #333;
    }

    .details {
        font-size: 1rem;
        color: #555;
    }

    .total {
        font-size: 1.2rem;
        font-weight: bold;
        color: #28a745;
    }

    .btn-container {
        position: absolute;
        bottom: 20px;
        right: 20px;
        display: flex;
        gap: 10px;
    }

    .btn-container form {
        margin: 0;
    }
</style>

<div class="container">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-center mb-4">Detail Pembayaran</h5>
            
            <div class="details">
                <p>Atas Nama: <strong>{{ Auth::user()->name }}</strong></p>
                <p>ID Pelanggan: <strong>{{ Auth::user()->id }}</strong></p>
                <p>ID Pesanan: <strong>{{ $order['id'] ?? 'N/A' }}</strong></p>
            </div>

            <div class="mt-3">
                <p><strong>Detail Pesanan:</strong></p>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(empty($cartItems))
                        <p>Item pesanan tidak ditemukan.</p>
                    @else
                        @foreach ($cartItems as $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>Rp. {{ number_format($item['price'], 2, ',', '.') }}</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>Rp. {{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                
                <h6 class="text-right">Total Semua: <b>Rp. {{ number_format($totalHarga, 2, ',', '.') }}</b></h6>

            <!-- Tombol di bagian kanan bawah -->
            <div class="btn-container">
                <!-- Tombol Download PDF -->
                <a href="{{ route('cart.downloadPdf', ['id' => $cart->id ?? 0]) }}" class="btn btn-primary">Download PDF</a>
                
                <!-- Tombol Selesai -->
                <form action="{{ route('cart.selesai') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success" onclick="return confirm('Apakah sudah Anda tunjukkan ke petugas?')">Selesai</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<br><br><br>
@endsection