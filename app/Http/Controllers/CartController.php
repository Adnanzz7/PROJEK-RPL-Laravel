<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mpdf;

class CartController extends Controller
{
    public function add(Request $request)
    {
        // Validasi input untuk ID barang dan quantity
        $request->validate([
            'id' => 'required|exists:barangs,id', // Pastikan ID barang ada di database
            'quantity' => 'required|integer|min:1', // Pastikan quantity valid dan tidak kurang dari 1
        ]);
    
        // Ambil keranjang dari session, jika tidak ada, buat array kosong
        $cart = session()->get('cart', []);
    
        $id = $request->id; // ID barang yang ditambahkan
        $quantity = $request->quantity; // Jumlah barang yang dibeli
    
        // Cari barang berdasarkan ID
        $barang = Barang::findOrFail($id);
    
        // Validasi jika jumlah yang diminta lebih dari stok yang tersedia
        if ($barang->jumlah_barang < $quantity) {
            return redirect()->back()->with('error', 'Jumlah barang yang Anda pilih melebihi stok yang tersedia!');
        }
    
        // Tambahkan barang ke keranjang atau update jika sudah ada
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity; // Update jumlah barang di keranjang
        } else {
            $cart[$id] = [
                'name' => $barang->nama_barang,
                'price' => $barang->harga_barang,
                'quantity' => $quantity,
                'foto_barang' => $barang->foto_barang,
                'initial_stock' => $barang->jumlah_barang, // Menyimpan stok awal
            ];
        }
    
        // Kurangi jumlah barang di database sesuai dengan quantity yang ditambahkan
        $barang->jumlah_barang -= $quantity;
        $barang->save();
    
        // Simpan kembali keranjang ke session
        session()->put('cart', $cart);
    
        // Simpan jumlah total barang di keranjang
        $totalQuantity = array_sum(array_column($cart, 'quantity')); // Hitung jumlah total barang
        session()->put('cart.count', $totalQuantity);
    
        return redirect()->back()->with('success', 'Barang berhasil ditambahkan ke keranjang!');
    }
    
    public function index()
    {
        $cartItems = session()->get('cart', []); // Ambil keranjang dari session
        $total = 0;
    
        // Validasi dan hitung total harga setiap item di keranjang
        foreach ($cartItems as $id => $item) {
            // Pastikan item valid: array dan memiliki key yang diperlukan
            if (is_array($item) && isset($item['name'], $item['price'], $item['quantity'])) {
                // Ambil data barang dari database berdasarkan ID
                $barang = Barang::find($id);
                
                // Tambahkan stok barang ke data item
                $item['stok'] = $barang ? $barang->jumlah_barang : 0;
    
                // Hitung total harga
                $total += $item['price'] * $item['quantity'];
    
                // Simpan kembali data item yang valid
                $cartItems[$id] = $item;
            } else {
                // Jika item tidak valid, hapus dari keranjang
                unset($cartItems[$id]);
            }
        }
    
        // Simpan kembali keranjang yang sudah diperbaiki ke session
        session()->put('cart', $cartItems);
    
        // Tampilkan view dengan data keranjang yang valid
        return view('cart.index', compact('cartItems', 'total'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1', // Validasi jumlah harus minimal 1
        ]);
    
        $cart = session()->get('cart', []); // Ambil keranjang dari session
    
        if (!isset($cart[$id])) {
            return redirect()->back()->with('error', 'Barang tidak ditemukan di keranjang!');
        }
    
        $newQuantity = $request->quantity; // Jumlah barang baru
        $oldQuantity = $cart[$id]['quantity']; // Jumlah barang saat ini di keranjang
        $initialStock = $cart[$id]['initial_stock']; // Stok awal barang sebelum ditambahkan ke keranjang
    
        $barang = Barang::find($id);
        if (!$barang) {
            // Jika barang tidak ada di database, hapus dari keranjang
            unset($cart[$id]);
            session()->put('cart', $cart);
            return redirect()->back()->with('error', 'Barang ini telah dihapus dari database dan tidak tersedia lagi.');
        }
    
        $availableStock = $barang->jumlah_barang; // Stok tersisa di database
        $maxAvailableStock = $availableStock + $oldQuantity; // Total stok yang bisa digunakan
    
        if ($newQuantity > $maxAvailableStock) {
            return redirect()->back()->with('error', 'Jumlah barang tidak mencukupi stok yang tersedia!');
        }
    
        DB::beginTransaction();
        try {
            // Hitung selisih jumlah barang
            $quantityDifference = $newQuantity - $oldQuantity;
    
            // Update jumlah barang di keranjang
            $cart[$id]['quantity'] = $newQuantity;
    
            // Sesuaikan stok di database
            $barang->jumlah_barang -= $quantityDifference; // Jika quantityDifference negatif, stok akan bertambah
            $barang->save();
    
            // Simpan keranjang kembali ke session
            session()->put('cart', $cart);
    
            DB::commit();
            return redirect()->back()->with('success', 'Jumlah barang berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui barang. Silakan coba lagi.');
        }
    }
    
    public function remove(Request $request)
    {
        // Validasi input
        $request->validate([
            'id' => 'required|exists:barangs,id', // Pastikan ID barang valid
        ]);
    
        $cart = session()->get('cart', []); // Ambil keranjang dari session
        $id = $request->id; // ID barang yang ingin dihapus
    
        // Pastikan barang ada di keranjang
        if (isset($cart[$id])) {
            // Kembalikan stok barang ke database
            $barang = Barang::find($id);
            if ($barang) {
                $barang->jumlah_barang += $cart[$id]['quantity']; // Menambah stok sesuai jumlah di keranjang
                $barang->save();
            }
    
            // Hapus barang dari keranjang
            unset($cart[$id]);
    
            // Simpan kembali keranjang ke session
            session()->put('cart', $cart);
    
            // Perbarui jumlah barang di keranjang
            session()->put('cart.count', count($cart));
    
            return redirect()->route('cart.index')->with('success', 'Barang berhasil dihapus dari keranjang!');
        }
    
        return redirect()->route('cart.index')->with('error', 'Barang tidak ditemukan di keranjang!');
    }
    
    public function checkout()
    {
        // Ambil data keranjang dari session
        $cartItems = session()->get('cart', []); 
        $totalHarga = array_reduce($cartItems, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);
    
        // Validasi stok barang untuk setiap item di keranjang
        $errorMessages = [];
    
        foreach ($cartItems as $id => $item) {
            // Cari barang berdasarkan ID
            $barang = Barang::find($id);
    
            // Validasi jika barang tidak ditemukan
            if (!$barang) {
                return redirect()->route('cart.index')->with('error', 'Barang dengan ID ' . $id . ' tidak ditemukan.');
            }
    
            // Hanya cek apakah stok barang yang diminta masih cukup di keranjang
            if ($barang->jumlah_barang < ($item['initial_stock'] - $item['quantity'])) {
                $errorMessages[] = 'Stok barang ' . $item['name'] . ' hanya tersisa ' . $barang->jumlah_barang . '. Anda akan membeli dengan jumlah yang tersedia.';
            }
        }
    
        // Jika ada pesan peringatan (bukan error), tampilkan pesan tapi lanjutkan ke halaman checkout
        if (!empty($errorMessages)) {
            return redirect()->route('cart.index')->with('error', implode(' ', $errorMessages));
        }
    
        // Simulasi pembuatan ID order
        $order = [
            'id' => uniqid(),
        ];
    
        // Return ke halaman checkout
        return view('cart.checkout', compact('cartItems', 'totalHarga', 'order'));
    }

    public function completeCheckout(Request $request)
    {
        $cartItems = session()->get('cart', []);
        
        // Pastikan ada item dalam keranjang
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }
        
        // Proses setiap item dalam keranjang
        foreach ($cartItems as $id => $item) {
            $barang = Barang::find($id);
            
            // Periksa apakah stok cukup
            if ($barang && $barang->jumlah_barang >= $item['quantity']) {
                // Kurangi stok barang
                $barang->jumlah_barang -= $item['quantity'];
                $barang->save();
            } else {
                // Jika stok tidak mencukupi, beri pesan error
                return redirect()->route('cart.index')->with('error', 'Stok tidak mencukupi untuk barang ' . $item['name']);
            }
        }
    
        // Setelah checkout, kosongkan keranjang
        session()->forget('cart');
    
        // Redirect ke halaman barangs.index dengan pesan sukses
        return redirect()->route('barangs.index')->with('success', 'Pembelian berhasil!');
    }
    
    public function pembayaranBerhasil()
    {
        $cartItems = session()->get('cart', []);
        $totalHarga = array_reduce($cartItems, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);
    
        $order = [
            'id' => uniqid(),
            'user_id' => Auth::id(),
            'total' => $totalHarga,
            'items' => $cartItems, // Simpan data keranjang di dalam order
        ];
    
        session()->put('order', $order); // Simpan order ke sesi
        session()->forget('cart'); // Hapus data keranjang
    
        return view('cart.success', compact('order', 'cartItems', 'totalHarga'));
    }
    
    public function cancel()
    {
        // Ambil data keranjang dari session
        $cart = session()->get('cart');
    
        // Proses pembatalan dan mengembalikan stok barang
        foreach ($cart as $id => $details) {
            // Cari barang berdasarkan ID
            $barang = Barang::find($id);
    
            // Tambahkan kembali jumlah barang ke stok
            if ($barang) {
                $barang->jumlah_barang += $details['quantity'];  // Menambah stok sesuai jumlah yang dibeli
                $barang->save();
            }
        }
    
        // Kosongkan keranjang setelah pembatalan
        session()->forget('cart');
    
        // Redirect atau respons sesuai kebutuhan
        return redirect()->route('barangs.index')->with('status', 'Pesanan dibatalkan, stok barang telah diperbarui!');
    }
    public function selesai()
    {
        $cartItems = session()->get('cart', []); // Ambil data cart dari sesi
        
        foreach ($cartItems as $id => $item) {
            // Cari barang berdasarkan ID
            $barang = Barang::find($id);
            
            // Periksa apakah barang ditemukan
            if (!$barang) {
                return redirect()->route('cart.index')->with('error', 'Barang dengan ID ' . $id . ' tidak ditemukan.');
            }
    
            // Periksa apakah stok cukup
            if ($barang->jumlah_barang < $item['quantity']) {
                return redirect()->route('cart.index')->with('error', 'Stok tidak mencukupi untuk barang ' . $item['name']);
            }
    
            // Mengurangi jumlah stok barang
            $barang->jumlah_barang -= $item['quantity'];
            $barang->save();
        }
    
        // Hapus data keranjang dari sesi
        session()->forget('cart');
    
        // Berikan pesan sukses
        return redirect()->route('barangs.index')->with('status', 'Pembelian berhasil');
    }
    
    public function downloadPdf()
    {
        $order = session()->get('order'); // Ambil data order dari sesi
        $cartItems = $order['items'] ?? []; // Ambil data keranjang dari order
        $totalHarga = $order['total'] ?? 0;
    
        $user = Auth::user();
    
        // Load mPDF
        $mpdf = new \Mpdf\Mpdf();
    
        // Buat tampilan PDF
        $html = view('cart.pdf', compact('cartItems', 'totalHarga', 'user', 'order'))->render();
    
        // Masukkan HTML ke PDF
        $mpdf->WriteHTML($html);
    
        // Unduh PDF
        return $mpdf->Output('bukti-pembayaran.pdf', 'D');
    }

    public function clear()
    {
        // Ambil data keranjang dari session
        $cart = session()->get('cart', []);
    
        // Iterasi setiap item di keranjang
        foreach ($cart as $id => $item) {
            $barang = Barang::find($id); // Cari barang berdasarkan ID
            if ($barang) {
                $barang->jumlah_barang += $item['quantity']; // Tambahkan jumlah barang kembali ke stok
                $barang->save(); // Simpan perubahan ke database
            }
        }
    
        // Hapus keranjang dari session
        session()->forget('cart');
    
        return redirect()->back()->with('success', 'Keranjang telah dibersihkan, dan stok barang telah dikembalikan!');
    }

    public function success(Request $request, $orderId)
    {
    // Ambil data keranjang dari session
    $cartItems = session()->get('cart', []);
    
    // Validasi jika keranjang kosong
    if (empty($cartItems)) {
        return redirect()->route('cart.index')->with('error', 'Keranjang kosong, tidak ada barang untuk diproses.');
    }

    // Mengurangi stok barang
    foreach ($cartItems as $id => $item) {
        // Cari barang berdasarkan ID
        $barang = Barang::find($id);

        if (!$barang) {
            return redirect()->route('cart.index')->with('error', 'Barang dengan ID ' . $id . ' tidak ditemukan.');
        }

        // Validasi stok
        if ($barang->jumlah_barang < $item['quantity']) {
            return redirect()->route('cart.index')->with('error', 'Stok barang ' . $item['name'] . ' tidak mencukupi.');
        }

        // Kurangi stok barang
        $barang->jumlah_barang -= $item['quantity'];
        $barang->save();
    }

    // Hapus data keranjang dari session
    session()->forget('cart');

    // Redirect ke halaman barang.index dan beri pesan sukses
    return redirect()->route('barangs.index')->with('status', 'Pembelian berhasil. Keranjang telah dikosongkan.');
    }
}    
