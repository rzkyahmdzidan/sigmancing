<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SigMancing</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-container {
            display: flex;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 850px;
            overflow: hidden;
        }

        .login-illustration {
            flex: 1;
            background-color: #f8fafc;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .login-illustration img {
            max-width: 100%;
            max-height: 300px;
        }

        .login-form {
            flex: 1;
            padding: 40px;
        }

        .login-form h2 {
            color: #1e293b;
            font-size: 24px;
            margin-bottom: 10px;
            text-align: center;
        }

        .login-form p {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 15px;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }

        .login-btn {
            background-color: #3b82f6;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 12px;
            width: 100%;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-btn:hover {
            background-color: #2563eb;
        }

        .login-options {
            margin-top: 20px;
            text-align: center;
        }

        .signup-option {
            font-size: 14px;
            color: #64748b;
        }

        .signup-option a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
        }

        .signup-option a:hover {
            text-decoration: underline;
        }

        .error {
            color: #ef4444;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                width: 90%;
                max-width: 500px;
            }

            .login-illustration {
                padding: 20px;
            }

            .login-form {
                padding: 25px;
            }
        }
    </style>
</head>
<body>
    <!-- Kontainer Login -->
    <div class="login-container">
        <!-- Ilustrasi Logo -->
        <div class="login-illustration">
            <img src="{{ asset('images/logobesar.png') }}" alt="SigMancing Logo">
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
                <p class="signup-option"><a href="/">Kembali Ke Beranda</a></p>
            </div>
        </div>
    </div>
</body>
</html>
