<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        }

        .login-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .logo-container {
        width: 150px;
        height: 150px;
        margin: 0 auto 1rem;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        }

        .logo-container img {
        width: 100%;
        height: 100%;
        object-fit: contain; /* Atur ke "contain" untuk memastikan tidak terpotong */
        }

        .login-container h2 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #333;
        }

        .login-container p {
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 2rem;
        }

        label {
            font-size: 0.9rem;
            font-weight: 500;
            color: #555;
            margin-bottom: 0.5rem;
            display: block;
        }

        input {
            width: 100%;
            padding: 0.8rem;
            font-size: 0.9rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s;
        }

        input:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 4px rgba(79, 70, 229, 0.4);
        }

        .form-group .error {
            font-size: 0.8rem;
            color: #e53e3e;
            margin-top: 0.3rem;
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

        .login-footer {
            text-align: center;
            margin-top: 1rem;
        }

        .login-footer a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 500;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-container">
            <img src="{{ asset('storage/logo.png') }}" alt="Logo">
        </div>
        <h2>Welcome Back</h2>
        <p>Please log in to your account</p>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    placeholder="Enter your email" 
                    required 
                    autofocus>
                @if ($errors->has('email'))
                    <span class="error">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div style="position: relative;">
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Enter your password" 
                        required>
                    <span 
                        class="toggle-password" 
                        onclick="showPassword('password')" 
                        style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"><i class="bi bi-eye"></i></span>
                </div>
                @if ($errors->has('password'))
                    <span class="error">{{ $errors->first('password') }}</span>
                @endif
            </div>
            
            <script>
                function showPassword(fieldId) {
                    const field = document.getElementById(fieldId);
                    field.type = "text"; // Menampilkan password
                    setTimeout(() => {
                        field.type = "password"; // Mengembalikan ke password setelah 2 detik
                    }, 1500);
                }
            </script>
            
            <br>

            <button type="submit" class="btn">Log in</button>
        </form>

        <div class="login-footer">
            <p>Don't have an account? <a href="{{ route('register') }}">Register</a></p>
            @if (Route::has('password.request'))
                <p><a href="{{ route('password.request') }}">Forgot your password?</a></p>
            @endif
        </div>
    </div>
</body>
</html>
