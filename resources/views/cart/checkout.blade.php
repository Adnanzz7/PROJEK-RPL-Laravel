@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<style>
    body {
        background-image: url('storage/bg.jpg');
        background-size: cover;
        background-repeat: repeat;
        background-position: center;
    }

    .qr-code {
        width: 200px;
        height: auto;
        margin: 20px auto;
        display: block;
        border: 4px solid #4CAF50;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
        100% {
            transform: scale(1);
        }
    }

    .container {
        margin-top: 50px;
    }

    .card {
        border-radius: 15px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        padding: 25px;
        background-color: #ffffff;
        border: none;
        position: relative;
    }

    .table th, .table td {
        vertical-align: middle;
    }

    .btn-secondary, .btn-danger {
        padding: 10px 20px;
        font-size: 1rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        margin-left: 10px;
    }

    .btn-secondary {
        background-color: #4CAF50;
        color: white;
        box-shadow: 0 4px 10px rgba(76, 175, 80, 0.4);
    }

    .btn-secondary:hover {
        background-color: #45a049;
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(76, 175, 80, 0.6);
    }

    .btn-danger {
        background-color: #f44336;
        color: white;
        box-shadow: 0 4px 10px rgba(244, 67, 54, 0.4);
    }

    .btn-danger:hover {
        background-color: #e53935;
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(244, 67, 54, 0.6);
    }

    h2, h6 {
        font-family: 'Roboto', sans-serif;
        color: #333;
    }

    .total {
        color: #4CAF50;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .btn-container {
        position: absolute;
        width: 100%;
        bottom: 20px;
        right: 20px;
        display: flex;
        justify-content: flex-end;
    }
</style>

<div class="container">
    <h2 class="text-center mb-4">Checkout</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Detail Pembelian</h5><br>
            <div class="details">
                <p>Atas Nama: <strong>{{ Auth::user()->name }}</strong></p>
                <p>ID Pelanggan: <strong>{{ Auth::user()->id }}</strong></p>
                <p>ID Pesanan: <strong>{{ $order['id'] ?? 'N/A' }}</strong></p>
            </div>
            <table class="table table-bordered table-striped text-center">
                <thead class="thead-light">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>Rp. {{ number_format($item['price'], 2, ',', '.') }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>Rp. {{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-right mt-3">
                <h6>Total Semua: <span class="total">Rp. {{ number_format($totalHarga, 2, ',', '.') }}</span></h6>
            </div>

            <div class="mt-4 text-center">
                <h6 class="text-center">QR Code Pembayaran</h6>
                <img src="{{ asset('storage/QR2.jpeg') }}" alt="QR Code" class="qr-code">
            </div>

            <div class="btn-container">
                <!-- Tombol Batal -->
                <form action="{{ route('cart.cancel') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan?')">
                        Batal
                    </button>
                </form>

                <!-- Tombol Selesai -->
                <form action="{{ route('cart.success', ['orderId' => $order['id']]) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-secondary" onclick="return confirm('Apakah pembayaran sudah dilakukan?')">
                        Selesai
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<br><br><br>
@endsection