<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Sistem Manajemen Prestasi Siswa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #5DADE2 0%, #48C9B0 50%, #5DADE2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .register-container {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 520px;
            padding: 40px 40px;
            animation: slideIn 0.5s ease-out;
            max-height: 95vh;
            overflow-y: auto;
        }

        /* Custom Scrollbar for container */
        .register-container::-webkit-scrollbar { width: 8px; }
        .register-container::-webkit-scrollbar-track { background: transparent; }
        .register-container::-webkit-scrollbar-thumb { background: #48C9B0; border-radius: 4px; }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #0F7860; font-size: 28px; margin-bottom: 8px; font-weight: 700; }
        .header p { color: #5DADE2; font-size: 13px; line-height: 1.6; margin: 0; }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; color: #0F7860; font-weight: 600; margin-bottom: 8px; font-size: 13px; }
        .form-control {
            width: 100%; padding: 12px 15px; border: 2px solid #D0F0ED; border-radius: 10px;
            font-size: 14px; font-family: inherit; transition: all 0.3s ease; background: #F0F9F8;
        }
        .form-control:focus { outline: none; border-color: #48C9B0; background: #fff; box-shadow: 0 0 0 3px rgba(72, 201, 176, 0.15); }
        .form-control::placeholder { color: #A8D8CC; }

        .password-wrapper { position: relative; }
        .password-toggle { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #48C9B0; font-size: 18px; background: none; border: none; padding: 5px; }
        .password-toggle:hover { color: #0F7860; }
        .password-wrapper .form-control { padding-right: 45px; }

        select.form-control { cursor: pointer; appearance: none; background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2348C9B0' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e"); background-repeat: no-repeat; background-position: right 10px center; background-size: 20px; padding-right: 35px; }

        /* Profile Upload Styles */
        .profile-upload-container { display: flex; flex-direction: column; align-items: center; gap: 10px; margin-bottom: 10px; }
        .profile-preview { width: 90px; height: 90px; border-radius: 50%; background: #E8F8F5; border: 3px solid #48C9B0; display: flex; align-items: center; justify-content: center; overflow: hidden; color: #48C9B0; font-size: 35px; box-shadow: 0 5px 15px rgba(72, 201, 176, 0.2); }
        .profile-preview img { width: 100%; height: 100%; object-fit: cover; display: none; }
        .btn-upload { background: #F0F9F8; color: #0F7860; border: 2px solid #D0F0ED; padding: 6px 15px; border-radius: 20px; font-size: 11px; font-weight: 700; cursor: pointer; transition: 0.3s; }
        .btn-upload:hover { background: #48C9B0; color: white; border-color: #48C9B0; }

        .alert { padding: 15px; border-radius: 10px; margin-bottom: 20px; font-size: 13px; line-height: 1.5; }
        .alert-danger { background-color: #FADBD8; border-left: 4px solid #E74C3C; color: #C0392B; }
        .alert-danger ul { margin: 5px 0 0 20px; padding: 0; }
        .alert-danger li { margin-bottom: 5px; }

        .btn-register { width: 100%; padding: 14px; background: linear-gradient(135deg, #5DADE2 0%, #48C9B0 100%); color: white; border: none; border-radius: 10px; font-size: 15px; font-weight: 700; cursor: pointer; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 10px; box-shadow: 0 4px 15px rgba(72, 201, 176, 0.3); }
        .btn-register:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(72, 201, 176, 0.4); }

        .footer-text { text-align: center; margin-top: 25px; color: #7f8c8d; font-size: 13px; }
        .footer-text a { color: #48C9B0; text-decoration: none; font-weight: 600; transition: color 0.3s; }
        .footer-text a:hover { color: #0F7860; text-decoration: underline; }

        .username-guide, .role-info { background: #E8F8F5; border-left: 4px solid #48C9B0; padding: 10px; border-radius: 6px; font-size: 12px; color: #0F7860; margin-top: 6px; line-height: 1.5; }
        .error-message { color: #E74C3C; font-size: 11px; margin-top: 5px; display: block; }
        .form-control.is-invalid { border-color: #E74C3C; background-color: #FADBD8; }
        
        .dynamic-section { background: #f8fafc; border: 1px dashed #A8D8CC; padding: 15px; border-radius: 10px; margin-top: 10px; display: none; animation: fadeIn 0.3s; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body>

    <div class="register-container">
        <div class="header">
            <h1>🎓 Daftar Akun</h1>
            <p>Sistem Manajemen Prestasi Siswa</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" id="registerForm" enctype="multipart/form-data">
            @csrf

            <!-- Foto Profil -->
            <div class="form-group">
                <div class="profile-upload-container">
                    <div class="profile-preview" id="profilePreview">
                        <i class="fas fa-user" id="profileIcon"></i>
                        <img id="profileImage" src="" alt="Preview">
                    </div>
                    <input type="file" id="foto" name="foto" accept="image/*" onchange="previewImage(this)" class="form-control" style="display: none;">
                    <button type="button" class="btn-upload" onclick="document.getElementById('foto').click()">
                        <i class="fas fa-camera"></i> Unggah Foto (Wajib)
                    </button>
                </div>
            </div>

            <!-- Nama Lengkap -->
            <div class="form-group">
                <label for="nama">👤 Nama Lengkap</label>
                <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Contoh: Kharina Mahveen" value="{{ old('nama') }}" required>
                @error('nama') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">📧 Email <span style="color: #A8D8CC; font-size: 11px;"></span></label>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Contoh: user@sekolah.com" value="{{ old('email') }}">
                @error('email') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <!-- Jenis Pengguna -->
            <div class="form-group">
                <label for="role_category">🎯 Jenis Pengguna</label>
                <select id="role_category" name="role_category" class="form-control @error('role_category') is-invalid @enderror" required onchange="updateDynamicFields()">
                    <option value="">-- Pilih Jenis Pengguna --</option>
                    <option value="siswa" @selected(old('role_category') === 'siswa')>👨‍🎓 Siswa</option>
                    <option value="pegawai" @selected(old('role_category') === 'pegawai')>👨‍🏫 Pegawai / Guru</option>
                </select>
                @error('role_category') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <!-- DYNAMIC FIELDS: SISWA -->
            <div class="dynamic-section" id="siswaSection">
                <div class="form-group">
                    <label for="nisn">📌 NISN</label>
                    <input type="text" id="nisn" name="nisn" class="form-control" placeholder="Masukkan NISN (Cth: 001234567)" value="{{ old('nisn') }}">
                    <span style="font-size: 11px; color: #64748b; margin-top: 4px; display: block;">*Akan digunakan sebagai Username login</span>
                </div>
                <div class="form-group">
                    <label for="kelas">🏫 Kelas</label>
                    <input type="text" id="kelas" name="kelas" class="form-control" placeholder="Contoh: XI TSM 1" value="{{ old('kelas') }}">
                </div>
            </div>

            <!-- DYNAMIC FIELDS: PEGAWAI / GURU -->
            <div class="dynamic-section" id="pegawaiSection">
                <div class="form-group">
                    <label for="nip">📌 NIP</label>
                    <input type="text" id="nip" name="nip" class="form-control" placeholder="Masukkan NIP" value="{{ old('nip') }}">
                    <span style="font-size: 11px; color: #64748b; margin-top: 4px; display: block;">*Akan digunakan sebagai Username login</span>
                </div>
            </div>

            <!-- Password dengan Toggle Show/Hide -->
            <div class="form-group" style="margin-top: 15px;">
                <label for="password">🔐 Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('password')"><i class="fas fa-eye"></i></button>
                </div>
                @error('password') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="form-group">
                <label for="password_confirmation">✓ Konfirmasi Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Ulangi password" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')"><i class="fas fa-eye"></i></button>
                </div>
                @error('password_confirmation') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn-register">✓ DAFTAR SEKARANG</button>

            <div class="footer-text">
                Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
            </div>
        </form>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const button = event.target.closest('.password-toggle');
            const icon = button.querySelector('i');
            if (field.type === 'password') { field.type = 'text'; icon.classList.replace('fa-eye', 'fa-eye-slash'); }
            else { field.type = 'password'; icon.classList.replace('fa-eye-slash', 'fa-eye'); }
        }

        function previewImage(input) {
            const icon = document.getElementById('profileIcon');
            const img = document.getElementById('profileImage');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    img.style.display = 'block';
                    icon.style.display = 'none';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function updateDynamicFields() {
            const role = document.getElementById('role_category').value;
            document.getElementById('siswaSection').style.display = (role === 'siswa') ? 'block' : 'none';
            document.getElementById('pegawaiSection').style.display = (role === 'pegawai') ? 'block' : 'none';
        }

        window.addEventListener('load', function() {
            updateDynamicFields();
        });
    </script>
</body>
</html>
