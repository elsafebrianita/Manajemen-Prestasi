<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Manajemen Prestasi</title>
    <style>
        body {
            margin: 0;
            font-family: 'Inter', Arial, sans-serif;
            background: linear-gradient(135deg, #87ceeb, #5f9ea0); /* Match existing dashboard */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-card h2 {
            margin: 0 0 10px;
            color: #2c3e50;
            font-size: 28px;
        }

        .login-card p {
            color: #7f8c8d;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #34495e;
            font-weight: bold;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #bdc3c7;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: #3498db;
        }

        .btn-login {
            background: #3498db;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }

        .btn-login:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }

        .error-message {
            color: #e74c3c;
            background: #fadbd8;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: left;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            color: #3498db;
            text-decoration: none;
            font-size: 14px;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <h2>Selamat Datang</h2>
        <p>Silakan login untuk masuk ke sistem</p>

        @if(session('logout_success'))
            <div style="background:linear-gradient(135deg,#e0f2fe,#bae6fd); border:1px solid #7dd3fc; padding:18px 16px; border-radius:12px; margin-bottom:16px; color:#0369a1; font-size:13px; line-height:1.6; text-align:left; display:flex; gap:12px; align-items:flex-start;">
                <span style="font-size:22px; flex-shrink:0;">👋</span>
                <div>
                    <strong style="display:block; margin-bottom:4px;">Logout Berhasil!</strong>
                    {{ session('logout_success') }}
                </div>
            </div>
        @endif

        @if(session('success'))
            <div style="background:linear-gradient(135deg,#d1fae5,#a7f3d0); border:1px solid #6ee7b7; padding:18px 16px; border-radius:12px; margin-bottom:16px; color:#065f46; font-size:13px; line-height:1.6; text-align:left; display:flex; gap:12px; align-items:flex-start;">
                <span style="font-size:22px; flex-shrink:0;">✅</span>
                <div>
                    <strong style="display:block; margin-bottom:4px;">Pendaftaran Berhasil!</strong>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if($errors->any())
            <div style="background:#fef2f2; border:1px solid #fca5a5; padding:15px 16px; border-radius:12px; margin-bottom:16px; color:#991b1b; font-size:13px; text-align:left; display:flex; gap:12px; align-items:flex-start;">
                <span style="font-size:20px; flex-shrink:0;">⚠️</span>
                <div>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="username">Username / NISN</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username atau NISN" value="{{ old('username') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn-login">Login</button>
        </form>

        <div style="text-align: center; margin-top: 20px; font-size: 14px; color: #7f8c8d;">
            Belum punya akun? <a href="{{ url('/register') }}" style="color: #3498db; text-decoration: none; font-weight: bold;">Daftar di sini</a>
        </div>
        <a href="/" class="back-link">&larr; Kembali ke Halaman Utama</a>
    </div>

</body>
</html>
