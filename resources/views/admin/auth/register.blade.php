<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Register</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <!-- Tambahkan font Google -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-illustration">
            <img src="{{ asset('images/logobesar.png') }}" alt="Student Illustration">
        </div>
        <div class="login-form">
            <h2>Sistem Informasi Memancing</h2>
            <p>Silahkan Daftar Untuk Menikmati Memancing dengan pengalaman yang lebih seru!</p>
            <form action="{{ route('register.process') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" name="name" placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password_confirmation" placeholder="Confirm your password" required>
                </div>
                @if ($errors->any())
                    <span class="error">{{ $errors->first() }}</span>
                @endif
                <button type="submit" class="login-btn">Daftar</button>
            </form>
            <div class="login-options">
                <p class="signup-option">Sudah Punya Akun? <a href="/login">Masuk Sekarang</a></p>
            </div>
        </div>
    </div>
</body>
</html>
