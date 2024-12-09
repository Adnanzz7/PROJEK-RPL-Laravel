<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('{{ asset('storage/bg.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }

        .register-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 10px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            overflow-y: auto; /* Menambahkan scroll jika konten terlalu tinggi */
        }

        .logo-container {
            width: 150px;
            height: 150px;
            margin: 0 auto 1rem;
            border-radius: 50%;
            justify-content: center;
        }

        .logo-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .register-container h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #333;
        }

        .register-container p {
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 1.5rem;
        }

        label {
            font-size: 0.9rem;
            font-weight: 500;
            color: #555;
            margin-bottom: 0.5rem;
            display: block;
        }

        input, select {
            width: 100%;
            padding: 0.8rem;
            font-size: 0.9rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            margin-bottom: 1rem;
        }

        input:focus, select:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 4px rgba(79, 70, 229, 0.4);
        }

        .form-group .error {
            font-size: 0.8rem;
            color: #e53e3e;
            margin-top: -0.5rem;
            margin-bottom: 1rem;
        }

        .btn {
            width: 100%;
            background: #4f46e5;
            color: #fff;
            padding: 0.8rem;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }

        .btn:hover {
            background: #4338ca;
            transform: scale(1.03);
        }

        .btn:active {
            transform: scale(0.98);
        }

        .footer {
            text-align: center;
            margin-top: 1rem;
        }

        .footer a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 500;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="logo-container">
            <img src="{{ asset('storage/logo.png') }}" alt="Logo">
        </div>
        <h2>Create an Account</h2>
        <p>Please register to create a new account</p>
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" value="{{ old('name') }}" required>
                @if ($errors->has('name'))
                    <span class="error">{{ $errors->first('name') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required>
                @if ($errors->has('email'))
                    <span class="error">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="foto">Photo</label>
                <input type="file" id="foto" name="foto" accept="image/*" required>
                @if ($errors->has('foto'))
                    <span class="error">{{ $errors->first('foto') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div style="position: relative;">
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    <span class="toggle-password" onclick="showPassword('password')" style="position: absolute; right: 10px; top: 40%; transform: translateY(-50%); cursor: pointer;"><i class="bi bi-eye"></i></span>
                </div>
                @if ($errors->has('password'))
                    <span class="error">{{ $errors->first('password') }}</span>
                @endif
            </div>
            
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <div style="position: relative;">
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required>
                    <span class="toggle-password" onclick="showPassword('password_confirmation')" style="position: absolute; right: 10px; top: 40%; transform: translateY(-50%); cursor: pointer;"><i class="bi bi-eye"></i></span>
                </div>
                @if ($errors->has('password_confirmation'))
                    <span class="error">{{ $errors->first('password_confirmation') }}</span>
                @endif
            </div>
            
            <script>
                function showPassword(fieldId) {
                    const field = document.getElementById(fieldId);
                    field.type = "text"; // Mengubah tipe menjadi teks agar terlihat
                    setTimeout(() => {
                        field.type = "password"; // Kembali menjadi password setelah 2 detik
                    }, 1500);
                }
            </script>
            
            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select Role</option>
                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                    <option value="supplier" {{ old('role') === 'supplier' ? 'selected' : '' }}>Supplier</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @if ($errors->has('role'))
                    <span class="error">{{ $errors->first('role') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="kode_pendaftaran">Registration Code</label>
                <input type="text" id="kode_pendaftaran" name="kode_pendaftaran" placeholder="Enter registration code" required>
                @if ($errors->has('kode_pendaftaran'))
                    <span class="error">{{ $errors->first('kode_pendaftaran') }}</span>
                @endif
            </div>

            <button type="submit" class="btn">Register</button>
        </form>

        <div class="footer">
            <p>Already have an account? <a href="{{ route('login') }}">Log in</a></p>
        </div>
    </div>
</body>
</html>
