@extends('layouts.app')

@section('title', 'Profile')

@push('styles')
<link href="{{ asset('css/custom-style.css') }}" rel="stylesheet">
@endpush

@section('content')
<body>
<div class="container-form">
    <h1>Profile</h1>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Profile</h4>
                </div>
                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <label for="name" class="form-label"><i class="bi bi-person-fill me-2"></i>Nama</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="email" class="form-label"><i class="bi bi-envelope-fill me-2"></i>Email</label>
                            <input type="email" id="email" class="form-control input-readonly" value="{{ $user->email }}" disabled>
                            <input type="hidden" name="email" value="{{ $user->email }}">
                        </div>
                        
                        <div class="mb-4">
                            <label for="role" class="form-label"><i class="bi bi-shield-lock-fill me-2"></i>Role</label>
                            <input type="text" id="role" class="form-control input-readonly" value="{{ $user->role }}" disabled>
                            <input type="hidden" name="role"  value="{{ $user->role }}">
                        </div>
                        <div class="mb-4">
                            <label for="foto" class="form-label"><i class="bi bi-camera-fill me-2"></i>Photo</label>
                            <div class="d-flex align-items-center">
                                @if($user->foto)
                                    <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover; margin-right: 15px;">
                                @else
                                    <span class="badge bg-secondary">Tidak ada foto</span>
                                @endif
                                <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                            </div>
                        </div>
                        
                        <h4 class="mt-4 text-primary">Ubah Password</h4>
                        <hr>
                        <div class="mb-3">
                            <label for="current_password" class="form-label"><i class="bi bi-key-fill me-2"></i>Password Lama</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label"><i class="bi bi-key-fill me-2"></i>Password Baru</label>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password">
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label"><i class="bi bi-key-fill me-2"></i>Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <button type="submit" name="action" value="update_password" class="btn btn-outline-primary btn-sm">Ubah Password</button>
                        </div>
                        <div class="text-start mt-3">
                            <a href="{{ route('barangs.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                            <button type="submit" name="action" value="update_profile" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
@endsection
<style>
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

.container-form {
    max-width: 700px;
    margin: 50px auto;
    border-radius: 12px;
    background: #fff;
    padding: 30px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.container-form:hover {
    box-shadow: 0 12px 36px rgba(0, 0, 0, 0.15);
}

/* Add some padding and make the form content responsive */
.container-form h1 {
    text-align: center;
    font-size: 2.2rem;
    color: #333;
    margin-bottom: 30px;
    font-weight: 700;
    letter-spacing: 1px;
}

/* Style for form fields */
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
.container-form input[type="email"],
.container-form input[type="password"],
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

/* Button styles */
.btn-primary {
    background: linear-gradient(45deg, #007bff, #0056b3);
    color: white;
    border: none;
    padding: 12px 25px;
    font-size: 16px;
    border-radius: 30px;
    font-weight: bold;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: linear-gradient(45deg, #0056b3, #003d80);
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}

.input-readonly {
    background-color: #f1f1f1;
    color: #6c757d;
    border: 1px solid #ddd;
    cursor: not-allowed;
}

.input-readonly:focus {
    background-color: #f1f1f1;
    color: #6c757d;
    border-color: #ddd;
    box-shadow: none;
}

/* Small button style */
.btn-sm {
    padding: 8px 16px;
    font-size: 14px;
    border-radius: 20px;
}

/* Back button style */
.btn-secondary {
    background-color: #6c757d;
    color: white;
    border-radius: 20px;
    padding: 10px 20px;
    font-size: 14px;
    transition: background 0.3s ease;
}

.btn-secondary:hover {
    background-color: #5a6268;
}

/* Responsive design */
@media (max-width: 768px) {
    .container-form {
        padding: 20px;
    }

    .container-form h1 {
        font-size: 1.8rem;
    }

    .btn-primary,
    .btn-secondary {
        font-size: 14px;
        padding: 10px 20px;
    }
}

</style>