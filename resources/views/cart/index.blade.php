@extends('layouts.app')

@section('title', 'Keranjang')

@section('content')
<style>
    body {
        background-image: url('storage/bg.jpg');
        background-size: cover;
        background-repeat: repeat;
        background-position: center;
    }

    /* Gaya untuk tabel keranjang */
    .cart-container {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }

    .cart-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 1rem;
        text-align: left;
    }

    .cart-table th, .cart-table td {
        padding: 15px;
        border-bottom: 1px solid #ddd;
    }

    .cart-table th {
        background: linear-gradient(90deg, #4c6ef5, #3b82f6);
        color: white;
        text-align: center;
        font-weight: bold;
    }

    .cart-table tr:hover {
        background-color: #f1f1f1;
    }

    .cart-table td {
        text-align: center;
        vertical-align: middle;
    }

    /* Tombol di tabel */
    .btn {
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 0.9rem;
        text-transform: uppercase;
        font-weight: bold;
    }

    .btn-primary {
        background: #007bff;
        color: white;
        transition: background 0.3s ease;
    }

    .btn-primary:hover {
        background: #0056b3;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
        transition: background 0.3s ease;
    }

    .btn-danger:hover {
        background: #c82333;
    }

    .btn-checkout {
        background: #28a745;
        color: white;
        padding: 12px 20px;
        font-size: 1.1rem;
        font-weight: bold;
        border-radius: 5px;
        transition: background 0.3s ease, transform 0.3s ease;
    }

    .btn-checkout:hover {
        background: #218838;
        transform: translateY(-2px);
    }

    /* Pesan kosong */
    .empty-cart {
        text-align: center;
        font-size: 1.2rem;
        font-weight: bold;
        color: #6c757d;
        margin-top: 20px;
    }

    /* Responsif */
    @media (max-width: 768px) {
        .cart-table th, .cart-table td {
            font-size: 0.9rem;
            padding: 10px;
        }

        .btn-checkout {
            font-size: 0.9rem;
            padding: 10px 15px;
        }
    }
</style>

<div class="container">
    <div class="cart-container">
        <h2 class="text-center text-gray-800 font-bold text-2xl mb-4">Keranjang Belanja</h2>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if (count($cartItems) > 0)
                    @foreach ($cartItems as $id => $item)
                    <tr>
                        <td>{{ $item['name'] ?? 'Nama Tidak Tersedia' }}</td>
                        <td>Rp. {{ number_format($item['price'] ?? 0, 2, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('cart.update', $id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <input type="number" 
                                    name="quantity" 
                                    value="{{ $item['quantity'] }}" 
                                    min="1" 
                                    max="{{ $item['initial_stock'] ?? $item['quantity'] }}" 
                                    class="w-16 text-center border rounded">
                                <button type="submit" class="btn btn-primary">Ubah</button>
                            </form>
                        </td>
                        <td>Rp. {{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('cart.remove') }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $id }}">
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="empty-cart">Keranjang Anda kosong. Silakan tambahkan barang.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        @if (count($cartItems) > 0)
        <div class="flex justify-between items-center mt-4">
            <span class="text-gray-700 font-bold text-xl">Total Harga: Rp. {{ number_format($total, 2, ',', '.') }}</span>
            <a href="{{ route('cart.checkout') }}" class="btn btn-checkout">Checkout</a>
        </div>
        @endif

        <div class="flex justify-between items-center mt-4">
            <a href="{{ route('barangs.index') }}" class="btn btn-primary">Lanjut Belanja</a>
            <a href="{{ route('cart.clear') }}" class="btn btn-danger">Bersihkan Keranjang</a>
        </div>
    </div>
</div>

@if (session('warning'))
<div class="alert alert-warning mt-3">
    {{ session('warning') }}
</div>
@endif
@endsection