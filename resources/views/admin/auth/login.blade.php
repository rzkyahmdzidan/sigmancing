<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <!-- Tambahkan font Google -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Kontainer Login -->
    <div class="login-container">
        <!-- Ilustrasi Logo -->
        <div class="login-illustration">
            <img src="{{ asset('images/logobesar.png') }}" alt="Student Illustration">
        </div>

        <!-- Form Login -->
        <div class="login-form">
            <h2>Sistem Informasi Memancing</h2>
            <p>Silahkan Masuk Untuk Menikmati Memancing dengan pengalaman yang lebih seru!</p>
            <form action="{{ route('login.process') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="email" name="email" placeholder="Enter your username/email" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>
                @if ($errors->has('email'))
                    <span class="error">{{ $errors->first('email') }}</span>
                @endif
                <button type="submit" class="login-btn">Masuk</button>
            </form>
            <div class="login-options">
                <p class="signup-option">Belum Punya Akun? <a href="/register">Daftar Sekarang</a></p>
            </div>
            <div class="login-options">
                <p class="signup-option"> <a href="/">Kembali Ke Beranda</p>
            </div>
        </div>
    </div>
</body>
</html>
