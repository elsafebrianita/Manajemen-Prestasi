<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Bobot KPI - SMK N 1 TALAMAU</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        :root {
            --primary-teal: #26817d;
            --bg-cyan: #e6f7f6;
            --text-dark: #0f172a;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-cyan);
            min-height: 100vh;
            padding: 60px 20px;
        }

        .container { max-width: 800px; margin: 0 auto; }

        .header-section { text-align: center; margin-bottom: 40px; }
        .header-section h1 { font-size: 32px; font-weight: 800; color: var(--text-dark); }
        .school-name { color: var(--primary-teal); font-weight: 800; }

        .card {
            background: white;
            padding: 40px;
            border-radius: 35px;
            box-shadow: 0 20px 50px rgba(38, 129, 125, 0.08);
            border: 1px solid rgba(38, 129, 125, 0.1);
        }

        .alert {
            padding: 15px 20px;
            border-radius: 15px;
            margin-bottom: 25px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .alert-success { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
        .alert-error { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

        .form-group { margin-bottom: 25px; }
        .form-group label {
            display: block;
            font-weight: 700;
            margin-bottom: 12px;
            color: #475569;
            font-size: 14px;
        }

        .input-group {
            display: flex;
            align-items: center;
            gap: 15px;
            background: #f8fafc;
            padding: 5px 15px;
            border-radius: 15px;
            border: 2px solid #f1f5f9;
            transition: 0.3s;
        }
        .input-group:focus-within { border-color: var(--primary-teal); background: white; }

        .indicator-code {
            background: var(--primary-teal);
            color: white;
            width: 40px; height: 40px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 10px; font-weight: 800;
        }

        input {
            flex: 1;
            padding: 12px 5px;
            border: none;
            background: transparent;
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
            outline: none;
        }

        .weight-info {
            font-size: 13px;
            color: #94a3b8;
            margin-top: 5px;
        }

        .btn-save {
            background: var(--primary-teal);
            color: white;
            border: none;
            width: 100%;
            padding: 20px;
            border-radius: 20px;
            font-weight: 800;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            box-shadow: 0 10px 20px rgba(38, 129, 125, 0.2);
        }
        .btn-save:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(38, 129, 125, 0.3); }

        .btn-back {
            display: block;
            text-align: center;
            margin-top: 25px;
            text-decoration: none;
            color: #94a3b8;
            font-weight: 700;
            transition: 0.3s;
        }
        .btn-back:hover { color: var(--primary-teal); }

        .total-box {
            background: var(--bg-cyan);
            padding: 20px;
            border-radius: 20px;
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .total-box span { font-weight: 800; color: var(--primary-teal); }
    </style>
</head>
<body>
    <div class="container">
        <header class="header-section">
            <span class="school-name">ADMIN PANEL</span>
            <h1>Manajemen Indikator & Bobot KPI</h1>
        </header>

        <div class="card">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <form action="/penilaian/settings/update" method="POST">
                @csrf
                
                @foreach($settings as $setting)
                <div class="form-group">
                    <label>{{ $setting->name }}</label>
                    <div class="input-group">
                        <div class="indicator-code">{{ $setting->code }}</div>
                        <input type="number" name="weights[{{ $setting->code }}]" value="{{ $setting->weight }}" step="0.01" min="0" max="1" required>
                        <i class="fas fa-percentage" style="color: #cbd5e1;"></i>
                    </div>
                    <p class="weight-info">Tentukan bobot pengaruh indikator ini (0.00 - 1.00).</p>
                </div>
                @endforeach

                <div class="total-box">
                    <div>
                        <i class="fas fa-calculator" style="color: var(--primary-teal); margin-right: 10px;"></i>
                        <strong>Total Akumulasi Bobot:</strong>
                    </div>
                    <span id="total-weight-display">1.00</span>
                </div>

                <p style="font-size: 12px; color: #ef4444; margin: 15px 0; text-align: center; font-weight: 600;">
                    <i class="fas fa-info-circle"></i> Pastikan total seluruh bobot adalah tepat 1.00 agar perhitungan akurat.
                </p>

                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Simpan Perubahan Bobot
                </button>

                <a href="/dashboard" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                </a>
            </form>
        </div>
    </div>

    <script>
        const inputs = document.querySelectorAll('input[type="number"]');
        const display = document.getElementById('total-weight-display');

        function calculateTotal() {
            let total = 0;
            inputs.forEach(input => {
                total += parseFloat(input.value) || 0;
            });
            display.textContent = total.toFixed(2);
            
            if (Math.abs(total - 1.0) > 0.0001) {
                display.style.color = '#ef4444';
            } else {
                display.style.color = '#26817d';
            }
        }

        inputs.forEach(input => {
            input.addEventListener('input', calculateTotal);
        });

        calculateTotal();
    </script>
</body>
</html>
