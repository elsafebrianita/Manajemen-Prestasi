<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPRES - SMK Negeri 1 Talamau</title>
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            /* Warna Sesuai Identitas Sekolah */
            --teal-dark: #0f766e;
            --teal-main: #14b8a6;
            --teal-light: #5eead4;
            --sky-blue: #7dd3fc;
            --bg-light: #e0f7fa;
            --white: #ffffff;
            --dark: #0f172a;
            --gray-text: #475569;
            --gray-bg: #f8fafc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--white);
            color: var(--dark);
            overflow-x: hidden;
        }

        /* Reusable Components */
        .section-padding { padding: 100px 5%; }
        .section-header { text-align: center; margin-bottom: 60px; }
        .section-title { font-size: 36px; font-weight: 800; color: var(--teal-dark); margin-bottom: 15px; position: relative; display: inline-block; }
        .section-title::after { content: ''; position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 60px; height: 4px; background: var(--teal-main); border-radius: 2px; }
        .section-subtitle { font-size: 16px; color: var(--gray-text); max-width: 600px; margin: 20px auto 0; line-height: 1.6; }

        /* Top Bar — Fixed di paling atas */
        .top-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: var(--teal-dark);
            color: white;
            padding: 10px 5%;
            font-size: 13px;
            display: flex;
            justify-content: flex-end;
            gap: 25px;
            font-weight: 500;
            z-index: 1001;
        }
        .top-bar i { color: var(--teal-light); margin-right: 5px; }

        /* Navbar Glassmorphism — Fixed tepat di bawah top bar */
        .navbar {
            position: fixed;
            top: 40px; /* Tinggi top bar */
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            padding: 15px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
            z-index: 1000;
            border-bottom: 1px solid rgba(255,255,255,0.3);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
        }

        .navbar-brand img {
            height: 50px;
            width: auto;
            object-fit: contain;
        }

        .brand-text { display: flex; flex-direction: column; }
        .brand-text .title { font-size: 24px; font-weight: 800; color: var(--teal-dark); line-height: 1.1; letter-spacing: 0.5px; }
        .brand-text .subtitle { font-size: 12px; font-weight: 600; color: var(--teal-main); letter-spacing: 1px; text-transform: uppercase; }

        .nav-links { display: flex; align-items: center; gap: 35px; }
        .nav-links a.menu-item {
            text-decoration: none; color: var(--dark); font-weight: 600; font-size: 15px;
            transition: color 0.3s ease; position: relative;
        }
        .nav-links a.menu-item:hover { color: var(--teal-main); }
        .nav-links a.menu-item::after {
            content: ''; position: absolute; width: 0; height: 3px; bottom: -8px; left: 0;
            background: linear-gradient(90deg, var(--teal-main), var(--sky-blue)); transition: width 0.3s ease; border-radius: 3px;
        }
        .nav-links a.menu-item:hover::after { width: 100%; }

        .btn-login {
            background: linear-gradient(135deg, var(--teal-main), var(--teal-dark));
            color: var(--white) !important; padding: 12px 28px; border-radius: 50px;
            font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 8px;
            box-shadow: 0 10px 20px rgba(20, 184, 166, 0.3); transition: all 0.3s ease;
            position: relative; overflow: hidden;
        }
        .btn-login:hover { transform: translateY(-3px); box-shadow: 0 15px 25px rgba(20, 184, 166, 0.4); }
        /* Glow Effect on Hover */
        .btn-login::before {
            content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.5s ease;
        }
        .btn-login:hover::before { left: 100%; }

        /* Hero Section (50/50 Split) */
        .hero {
            position: relative;
            min-height: 100vh;
            padding: 120px 5% 50px;
            background: linear-gradient(135deg, var(--bg-light) 0%, var(--white) 100%);
            display: flex;
            align-items: center;
            overflow: hidden;
        }
        /* Background decorative circles */
        .hero::before {
            content: ''; position: absolute; top: -100px; right: -100px; width: 500px; height: 500px;
            background: var(--sky-blue); border-radius: 50%; filter: blur(100px); opacity: 0.3; z-index: 0;
        }
        .hero::after {
            content: ''; position: absolute; bottom: -100px; left: -100px; width: 400px; height: 400px;
            background: var(--teal-main); border-radius: 50%; filter: blur(100px); opacity: 0.2; z-index: 0;
        }

        .hero-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 50px;
            width: 100%;
            max-width: 1300px;
            margin: 0 auto;
            z-index: 1;
        }

        .hero-content {
            flex: 1;
            max-width: 600px;
            animation: fadeInLeft 1s ease forwards;
        }

        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--white); color: var(--teal-dark);
            padding: 8px 18px; border-radius: 30px; font-size: 14px; font-weight: 600;
            margin-bottom: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: 1px solid var(--bg-light);
        }
        .hero-badge i { color: #f59e0b; }

        .hero-content h1 {
            font-size: 52px; font-weight: 800; color: var(--dark); line-height: 1.2; margin-bottom: 20px;
        }
        .hero-content h1 span {
            background: linear-gradient(135deg, var(--teal-dark), var(--teal-main));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }

        .hero-content p {
            font-size: 18px; color: var(--gray-text); line-height: 1.6; margin-bottom: 40px;
        }

        .hero-buttons { display: flex; gap: 20px; }
        .btn-primary-hero {
            background: var(--teal-dark); color: var(--white); padding: 16px 32px; border-radius: 30px;
            font-size: 16px; font-weight: 600; text-decoration: none; box-shadow: 0 10px 25px rgba(15, 118, 110, 0.3);
            transition: all 0.3s ease;
        }
        .btn-primary-hero:hover { background: var(--teal-main); transform: translateY(-3px); }
        .btn-outline-hero {
            background: var(--white); color: var(--teal-dark); padding: 16px 32px; border-radius: 30px;
            font-size: 16px; font-weight: 600; text-decoration: none; border: 2px solid var(--teal-dark);
            transition: all 0.3s ease; display: flex; align-items: center; gap: 10px;
        }
        .btn-outline-hero:hover { background: var(--bg-light); transform: translateY(-3px); }

        .hero-image {
            flex: 1;
            position: relative;
            animation: fadeInRight 1s ease forwards;
        }
        .hero-image img {
            width: 100%; border-radius: 30px; box-shadow: 0 20px 50px rgba(0,0,0,0.1);
            animation: floating 6s ease-in-out infinite;
        }
        .floating-card {
            position: absolute; bottom: -20px; left: -30px; background: var(--white); padding: 20px;
            border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 15px;
            animation: floating 5s ease-in-out infinite reverse;
        }
        .floating-card .icon {
            width: 50px; height: 50px; background: var(--bg-light); border-radius: 50%;
            display: flex; align-items: center; justify-content: center; color: var(--teal-main); font-size: 24px;
        }

        /* Stats Section */
        .stats {
            background: var(--teal-dark);
            padding: 60px 5%;
            color: var(--white);
            position: relative;
            z-index: 10;
            margin-top: -50px; /* Overlap hero */
            border-radius: 40px 40px 0 0;
            box-shadow: 0 -10px 30px rgba(0,0,0,0.1);
        }
        .stats-grid {
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px; max-width: 1200px; margin: 0 auto; text-align: center;
        }
        .stat-item { padding: 20px; }
        .stat-icon { font-size: 40px; color: var(--teal-light); margin-bottom: 15px; }
        .stat-number { font-size: 48px; font-weight: 800; margin-bottom: 5px; }
        .stat-label { font-size: 16px; font-weight: 500; color: var(--bg-light); text-transform: uppercase; letter-spacing: 1px; }

        /* Keunggulan Sistem */
        .features { background: var(--gray-bg); }
        .features-grid {
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px; max-width: 1200px; margin: 0 auto;
        }
        .feature-card {
            background: var(--white); padding: 40px 30px; border-radius: 24px; text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02); transition: all 0.4s ease; border: 1px solid rgba(0,0,0,0.02);
        }
        .feature-card:hover { transform: translateY(-15px); box-shadow: 0 20px 40px rgba(20, 184, 166, 0.1); border-color: var(--teal-light); }
        .feature-icon {
            width: 80px; height: 80px; background: var(--bg-light); color: var(--teal-main); font-size: 32px;
            display: flex; align-items: center; justify-content: center; border-radius: 50%; margin: 0 auto 25px; transition: all 0.4s ease;
        }
        .feature-card:hover .feature-icon { background: var(--teal-main); color: var(--white); }
        .feature-card h3 { font-size: 20px; font-weight: 700; color: var(--dark); margin-bottom: 15px; }
        .feature-card p { color: var(--gray-text); font-size: 15px; line-height: 1.6; }

        /* Pengumuman Sekolah */
        .pengumuman { background: var(--bg-light); position: relative; overflow: hidden; }
        .pengumuman-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; max-width: 1200px; margin: 0 auto; z-index: 2; position: relative;}
        .pengumuman-card {
            background: var(--white); border-left: 5px solid var(--teal-main); border-radius: 12px; padding: 25px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.03); transition: all 0.3s ease; position: relative;
        }
        .pengumuman-card:hover { transform: translateX(10px); box-shadow: 0 15px 30px rgba(20, 184, 166, 0.1); }
        .pengumuman-date {
            display: inline-block; background: var(--teal-light); color: var(--teal-dark); padding: 5px 12px;
            border-radius: 6px; font-size: 12px; font-weight: 700; margin-bottom: 15px;
        }
        .pengumuman-title { font-size: 18px; font-weight: 700; color: var(--dark); margin-bottom: 10px; }
        .pengumuman-desc { color: var(--gray-text); font-size: 14px; line-height: 1.6; }
        .pengumuman-icon { position: absolute; top: 20px; right: 20px; font-size: 40px; color: var(--gray-bg); opacity: 0.5; }

        /* Publikasi Prestasi (FITUR UTAMA) */
        .prestasi { background: var(--white); }
        .prestasi-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 35px; max-width: 1200px; margin: 0 auto;
        }
        .prestasi-card {
            background: var(--white); border-radius: 24px; overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); transition: all 0.4s ease; position: relative; border: 1px solid #f1f5f9;
        }
        .prestasi-card:hover { transform: translateY(-15px); box-shadow: 0 25px 50px rgba(15, 118, 110, 0.15); }
        
        .prestasi-img-container { position: relative; overflow: hidden; height: 220px; }
        .prestasi-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
        .prestasi-card:hover .prestasi-img { transform: scale(1.1); }
        
        /* Badges 1, 2, 3 */
        .badge-juara {
            position: absolute; top: 20px; right: 20px; padding: 8px 16px; border-radius: 30px;
            font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 8px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2); z-index: 2;
        }
        .juara-1 { background: linear-gradient(135deg, #FFD700, #F59E0B); color: #fff; }
        .juara-2 { background: linear-gradient(135deg, #E2E8F0, #94A3B8); color: #0F172A; }
        .juara-3 { background: linear-gradient(135deg, #FDBA74, #B45309); color: #fff; }
        .juara-other { background: linear-gradient(135deg, var(--teal-main), var(--teal-dark)); color: #fff; }

        .prestasi-content { padding: 30px; }
        .kategori-badge {
            display: inline-block; background: var(--bg-light); color: var(--teal-dark);
            padding: 5px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 15px;
        }
        .prestasi-title { font-size: 20px; font-weight: 700; color: var(--dark); margin-bottom: 15px; line-height: 1.4; }
        
        .prestasi-student {
            display: flex; align-items: center; gap: 15px; margin-top: 20px; padding-top: 20px; border-top: 1px solid #f1f5f9;
        }
        .student-avatar {
            width: 45px; height: 45px; border-radius: 50%; background: linear-gradient(135deg, var(--teal-light), var(--teal-main));
            display: flex; align-items: center; justify-content: center; color: var(--white); font-weight: 700; font-size: 18px;
            box-shadow: 0 4px 10px rgba(20, 184, 166, 0.3);
        }
        .student-info { display: flex; flex-direction: column; }
        .student-name { font-size: 16px; font-weight: 600; color: var(--dark); }
        .student-kelas { font-size: 13px; color: var(--gray-text); }

        /* Gallery Section */
        .gallery { background: var(--gray-bg); }
        .gallery-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; max-width: 1200px; margin: 0 auto;
        }
        .gallery-item {
            border-radius: 20px; overflow: hidden; height: 250px; position: relative; cursor: pointer;
        }
        .gallery-item img {
            width: 100%; height: 100%; object-fit: cover; transition: all 0.5s ease;
        }
        .gallery-overlay {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(to top, rgba(15, 118, 110, 0.8), transparent);
            display: flex; align-items: flex-end; padding: 20px; opacity: 0; transition: opacity 0.3s ease;
        }
        .gallery-item:hover img { transform: scale(1.1); }
        .gallery-item:hover .gallery-overlay { opacity: 1; }
        .gallery-text { color: var(--white); font-weight: 600; font-size: 18px; transform: translateY(20px); transition: transform 0.3s ease; }
        .gallery-item:hover .gallery-text { transform: translateY(0); }

        /* Footer */
        .footer { background: var(--dark); color: var(--white); padding: 80px 5% 30px; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1.5fr; gap: 50px; max-width: 1200px; margin: 0 auto 50px; }
        
        .footer-brand h2 { font-size: 28px; font-weight: 800; margin-bottom: 20px; color: var(--teal-light); }
        .footer-brand p { color: #94a3b8; font-size: 15px; line-height: 1.8; margin-bottom: 25px; max-width: 400px; }
        
        .social-links { display: flex; gap: 15px; }
        .social-links a {
            width: 45px; height: 45px; background: rgba(255,255,255,0.05); border-radius: 50%;
            display: flex; align-items: center; justify-content: center; color: var(--white);
            font-size: 18px; transition: all 0.3s ease;
        }
        .social-links a:hover { background: var(--teal-main); transform: translateY(-5px); box-shadow: 0 10px 20px rgba(20, 184, 166, 0.3); }
        
        .footer-title { font-size: 20px; font-weight: 700; margin-bottom: 25px; color: var(--white); }
        .footer-links li { list-style: none; margin-bottom: 15px; }
        .footer-links a { color: #94a3b8; text-decoration: none; transition: color 0.3s ease; }
        .footer-links a:hover { color: var(--teal-light); padding-left: 5px; }
        
        .footer-contact li { display: flex; gap: 15px; margin-bottom: 20px; color: #94a3b8; font-size: 15px; line-height: 1.6; }
        .footer-contact i { color: var(--teal-main); font-size: 20px; margin-top: 2px; }
        
        .footer-bottom { text-align: center; padding-top: 30px; border-top: 1px solid rgba(255,255,255,0.1); color: #64748b; font-size: 14px; }

        /* Keyframes */
        @keyframes fadeInLeft { from { opacity: 0; transform: translateX(-50px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes fadeInRight { from { opacity: 0; transform: translateX(50px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes floating { 0% { transform: translateY(0); } 50% { transform: translateY(-15px); } 100% { transform: translateY(0); } }

        /* Prestasi Carousel Section */
        .prestasi-carousel { background: linear-gradient(135deg, var(--bg-light) 0%, var(--white) 100%); }
        .carousel-container {
            display: flex; gap: 25px; overflow-x: auto; padding-bottom: 15px; scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch; scrollbar-width: thin; scrollbar-color: var(--teal-light) var(--gray-bg);
        }
        .carousel-container::-webkit-scrollbar { height: 8px; }
        .carousel-container::-webkit-scrollbar-track { background: var(--gray-bg); border-radius: 10px; }
        .carousel-container::-webkit-scrollbar-thumb { background: var(--teal-light); border-radius: 10px; }
        .carousel-container::-webkit-scrollbar-thumb:hover { background: var(--teal-main); }
        .carousel-item {
            flex: 0 0 400px; background: var(--white); border-radius: 20px; overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); transition: all 0.4s ease; border: 1px solid #f1f5f9;
        }
        .carousel-item:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(15, 118, 110, 0.15); }
        .carousel-img { width: 100%; height: 200px; object-fit: cover; }
        .carousel-content { padding: 25px; }
        .carousel-category { display: inline-block; background: var(--bg-light); color: var(--teal-dark); padding: 5px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 12px; }
        .carousel-title { font-size: 18px; font-weight: 700; color: var(--dark); margin-bottom: 12px; line-height: 1.4; }
        .carousel-berita { color: var(--gray-text); font-size: 14px; line-height: 1.6; margin-bottom: 15px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .carousel-student { display: flex; align-items: center; gap: 12px; padding-top: 15px; border-top: 1px solid #f1f5f9; }
        .carousel-avatar { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--teal-light), var(--teal-main)); display: flex; align-items: center; justify-content: center; color: var(--white); font-weight: 700; font-size: 16px; }
        .carousel-student-info { display: flex; flex-direction: column; }
        .carousel-student-name { font-size: 14px; font-weight: 600; color: var(--dark); }
        .carousel-student-kelas { font-size: 12px; color: var(--gray-text); }

        /* Scroll to Top Button */
        #scrollTopBtn {
            position: fixed; bottom: 30px; right: 30px; width: 50px; height: 50px;
            background: linear-gradient(135deg, var(--teal-main), var(--teal-dark)); color: var(--white);
            border: none; border-radius: 50%; cursor: pointer; display: none; align-items: center; justify-content: center;
            font-size: 20px; box-shadow: 0 10px 25px rgba(20, 184, 166, 0.4); transition: all 0.3s ease; z-index: 999;
        }
        #scrollTopBtn:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(20, 184, 166, 0.6); }
        #scrollTopBtn.show { display: flex; }

        /* Responsive */
        @media (max-width: 1024px) {
            .hero-container { flex-direction: column; text-align: center; padding-top: 50px; }
            .hero-content h1 { font-size: 40px; }
            .hero-buttons { justify-content: center; }
            .floating-card { display: none; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .features-grid { grid-template-columns: repeat(2, 1fr); }
            .footer-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .nav-links a.menu-item { display: none; }
            .stats-grid { grid-template-columns: 1fr; }
            .features-grid { grid-template-columns: 1fr; }
            .gallery-grid { grid-template-columns: 1fr; }
        }

        /* ==========================================================================
           CSS TAMBAHAN: SAMBUTAN KEPSEK & TABS FILTER PRESTASI & DETAIL MODAL
           ========================================================================== */
        .sambutan-section {
            background: linear-gradient(135deg, #ffffff 0%, var(--bg-light) 100%);
            position: relative;
            overflow: hidden;
        }
        .sambutan-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 60px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .sambutan-image-wrapper {
            flex: 0 0 380px;
            position: relative;
            z-index: 2;
        }
        .sambutan-image-wrapper img {
            width: 100%;
            border-radius: 30px;
            box-shadow: 0 20px 40px rgba(15, 118, 110, 0.15);
            border: 5px solid var(--white);
            transition: all 0.4s ease;
        }
        .sambutan-image-wrapper img:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px rgba(15, 118, 110, 0.25);
        }
        .sambutan-image-wrapper::before {
            content: '';
            position: absolute;
            top: -15px;
            left: -15px;
            width: 120px;
            height: 120px;
            border-top: 5px solid var(--teal-main);
            border-left: 5px solid var(--teal-main);
            border-radius: 30px 0 0 0;
            z-index: -1;
        }
        .sambutan-content {
            flex: 1;
        }
        .sambutan-content h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--teal-main);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }
        .sambutan-content h2 {
            font-size: 38px;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 25px;
            line-height: 1.2;
        }
        .sambutan-text {
            color: var(--gray-text);
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 30px;
        }
        .sambutan-text p {
            margin-bottom: 15px;
        }
        .sambutan-quote {
            background: rgba(20, 184, 166, 0.05);
            border-left: 4px solid var(--teal-main);
            padding: 15px 25px;
            font-style: italic;
            border-radius: 0 16px 16px 0;
            margin-bottom: 25px;
            color: var(--teal-dark);
            font-weight: 500;
        }
        .sambutan-signature {
            display: flex;
            flex-direction: column;
        }
        .sambutan-name {
            font-size: 20px;
            font-weight: 800;
            color: var(--teal-dark);
        }
        .sambutan-role {
            font-size: 14px;
            color: var(--gray-text);
            font-weight: 600;
        }

        /* Tabs Filter Prestasi */
        .prestasi-tabs-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 50px;
        }
        .prestasi-tab-btn {
            background: var(--white);
            border: 2px solid #e2e8f0;
            color: var(--gray-text);
            padding: 12px 30px;
            border-radius: 50px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.02);
        }
        .prestasi-tab-btn:hover {
            border-color: var(--teal-main);
            color: var(--teal-main);
            transform: translateY(-2px);
        }
        .prestasi-tab-btn.active {
            background: var(--teal-dark);
            border-color: var(--teal-dark);
            color: var(--white);
            box-shadow: 0 10px 20px rgba(15, 118, 110, 0.3);
        }

        /* Redesign Kartu Prestasi Berdasarkan Gambar User */
        .prestasi-header {
            text-align: center;
            margin-bottom: 40px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }
        .prestasi-section-title {
            font-size: 36px;
            font-weight: 800;
            color: var(--teal-dark);
            position: relative;
            display: inline-block;
            padding-bottom: 15px;
            margin-bottom: 10px;
        }
        .prestasi-section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: var(--teal-main);
            border-radius: 2px;
        }
        .prestasi-section-subtitle {
            font-size: 16px;
            color: var(--gray-text);
            max-width: 650px;
            margin: 15px auto 0;
            line-height: 1.7;
        }

        .prestasi-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            max-width: 1200px;
            margin: 0 auto;
            justify-items: center;
        }

        .prestasi-card {
            background: var(--white);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.4s ease;
            border: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
            cursor: pointer;
            width: 100%;
            max-width: 360px;
        }
        @media (max-width: 1024px) {
            .prestasi-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 768px) {
            .prestasi-grid {
                grid-template-columns: 1fr;
            }
        }
        .prestasi-card.hidden {
            display: none !important;
        }
        .prestasi-img-container {
            position: relative;
            height: 220px;
            overflow: hidden;
            background: #0f172a;
        }
        .prestasi-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .prestasi-card:hover .prestasi-img {
            transform: scale(1.08);
        }

        /* Fallback Banner Congratulations */
        .fallback-banner {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #0b534c 0%, #0f766e 50%, #14b8a6 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px;
            color: var(--white);
            font-family: 'Poppins', sans-serif;
            position: relative;
        }
        .fallback-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, rgba(255,255,255,0.05) 0%, transparent 70%);
            pointer-events: none;
        }
        .fallback-header {
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            padding-bottom: 8px;
        }
        .fallback-logo {
            height: 24px !important;
            width: auto !important;
            object-fit: contain;
        }
        .fallback-school-name {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 1px;
            color: #ffffff;
            text-transform: uppercase;
        }
        .fallback-body {
            text-align: center;
            margin: 10px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex-grow: 1;
        }
        .fallback-congratulations {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 2px;
            color: var(--teal-light);
            text-transform: uppercase;
            margin-bottom: 2px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        .fallback-subtitle {
            font-size: 8px;
            font-weight: 600;
            letter-spacing: 1px;
            color: #e2e8f0;
            text-transform: uppercase;
            margin-bottom: 8px;
        }
        .fallback-student-name {
            font-size: 13px;
            font-weight: 800;
            color: #ffffff;
            margin: 0 0 4px 0;
            line-height: 1.2;
            max-width: 90%;
            word-wrap: break-word;
        }
        .fallback-achievement {
            font-size: 9px;
            color: var(--teal-light);
            font-weight: 600;
            margin: 0;
            line-height: 1.2;
        }
        .fallback-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 6px;
            text-align: center;
        }
        .fallback-footer span {
            font-size: 8px;
            font-weight: 600;
            color: rgba(255,255,255,0.5);
            letter-spacing: 0.5px;
        }

        /* Date Badge Model 09 MAR (Teal background) */
        .prestasi-date-badge {
            position: absolute;
            bottom: 0;
            right: 0;
            background: var(--teal-dark);
            color: var(--white);
            padding: 8px 15px;
            text-align: center;
            min-width: 70px;
            box-shadow: 0 4px 10px rgba(15, 118, 110, 0.3);
            z-index: 5;
        }
        .prestasi-date-badge .month {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: block;
        }
        .prestasi-date-badge .day {
            font-size: 26px;
            font-weight: 800;
            line-height: 1;
            display: block;
            margin-top: 2px;
        }

        .prestasi-content {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }
        .prestasi-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--teal-dark);
            line-height: 1.4;
            margin-bottom: 20px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 40px; /* konsisten 2 baris */
        }
        
        /* View Details Button Model */
        .btn-view-details {
            align-self: flex-start;
            background: transparent;
            border: 2px solid var(--teal-dark);
            color: var(--teal-dark);
            padding: 8px 20px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: auto;
        }
        .btn-view-details:hover {
            background: var(--teal-dark);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 5px 12px rgba(15, 118, 110, 0.3);
        }

        /* Button Lihat Lebih Banyak Penayangan */
        .prestasi-more-container {
            display: flex;
            justify-content: center;
            margin-top: 50px;
            width: 100%;
        }
        .btn-more-prestasi {
            background: var(--teal-dark);
            color: var(--white);
            padding: 14px 35px;
            border-radius: 50px;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(15, 118, 110, 0.25);
        }
        .btn-more-prestasi:hover {
            background: var(--teal-main);
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(20, 184, 166, 0.4);
        }

        /* Formal Announcement Card in Modal */
        .modal-announcement {
            background: linear-gradient(145deg, #f0fdfa 0%, #e6faf8 100%);
            border: 1px solid rgba(20, 184, 166, 0.25);
            border-radius: 16px;
            padding: 28px 24px;
            margin-bottom: 22px;
            position: relative;
            overflow: hidden;
        }
        .modal-announcement::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(to bottom, var(--teal-light), var(--teal-dark));
            border-radius: 16px 0 0 16px;
        }
        .modal-announcement-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(20, 184, 166, 0.2);
        }
        .modal-announcement-logo {
            width: 36px;
            height: 36px;
            background: var(--teal-dark);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
            flex-shrink: 0;
        }
        .modal-announcement-school {
            font-size: 11px;
            font-weight: 800;
            color: var(--teal-dark);
            letter-spacing: 1px;
            text-transform: uppercase;
            line-height: 1.3;
        }
        .modal-announcement-school span {
            display: block;
            font-weight: 500;
            font-size: 10px;
            color: var(--gray-text);
            letter-spacing: 0;
            text-transform: none;
        }
        .modal-announcement-body {
            font-size: 14px;
            line-height: 1.85;
            color: #1e3a3a;
            font-weight: 500;
            letter-spacing: 0.1px;
        }
        .modal-announcement-body .highlight-name {
            font-weight: 800;
            color: var(--teal-dark);
            font-size: 15px;
        }
        .modal-announcement-body .highlight-award {
            font-weight: 800;
            color: #b45309;
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            padding: 1px 8px;
            border-radius: 4px;
            font-size: 14px;
        }
        .modal-announcement-body .highlight-bold {
            font-weight: 700;
            color: var(--dark);
        }
        .modal-announcement-footer {
            margin-top: 14px;
            padding-top: 12px;
            border-top: 1px dashed rgba(20, 184, 166, 0.25);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .modal-announcement-footer .ann-badge {
            background: var(--teal-dark);
            color: white;
            font-size: 10px;
            font-weight: 800;
            padding: 3px 10px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .modal-announcement-footer .ann-date {
            font-size: 12px;
            color: var(--gray-text);
            font-weight: 600;
        }

        /* Gallery More Button */
        .gallery-more-container {
            display: flex;
            justify-content: center;
            margin-top: 50px;
            width: 100%;
        }

        /* Glassmorphic Modal Detail Prestasi */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .modal-overlay.open {
            opacity: 1;
            pointer-events: auto;
        }
        .modal-container {
            background: var(--white);
            width: 90%;
            max-width: 800px;
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            position: relative;
            transform: scale(0.9);
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .modal-overlay.open .modal-container {
            transform: scale(1);
        }
        .modal-close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(15, 23, 42, 0.05);
            border: none;
            color: var(--dark);
            font-size: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            z-index: 10;
        }
        .modal-close-btn:hover {
            background: #ef4444;
            color: var(--white);
            transform: rotate(90deg);
        }
        .modal-body {
            display: grid;
            grid-template-columns: 1.2fr 1.8fr;
            min-height: 450px;
        }
        .modal-img-column {
            background: #0f172a;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            min-height: 300px;
        }
        .modal-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .modal-info-column {
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: #ffffff;
            max-height: 600px;
            overflow-y: auto;
        }
        .modal-student-profile {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            background: var(--bg-light);
            padding: 15px;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
        }
        .modal-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--teal-light), var(--teal-main));
            color: var(--white);
            font-size: 22px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(20, 184, 166, 0.2);
        }
        .modal-student-name {
            font-size: 16px;
            font-weight: 800;
            color: var(--dark);
        }
        .modal-student-class {
            font-size: 13px;
            color: var(--gray-text);
            font-weight: 600;
        }
        .modal-achievement-title {
            font-size: 22px;
            font-weight: 800;
            color: var(--teal-dark);
            line-height: 1.3;
            margin-bottom: 20px;
        }
        .modal-details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .modal-details-table tr {
            border-bottom: 1px solid #f1f5f9;
        }
        .modal-details-table td {
            padding: 12px 0;
            font-size: 14px;
        }
        .modal-details-table td.label-td {
            font-weight: 700;
            color: var(--gray-text);
            width: 120px;
        }
        .modal-details-table td.val-td {
            color: var(--dark);
            font-weight: 600;
        }
        .modal-badge-tingkat {
            display: inline-block;
            background: var(--sky-blue);
            color: var(--teal-dark);
            padding: 4px 12px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
        }
        .modal-footer {
            margin-top: 30px;
            display: flex;
            gap: 15px;
        }
        .btn-modal-certificate {
            background: var(--teal-dark);
            color: var(--white);
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        .btn-modal-certificate:hover {
            background: var(--teal-main);
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(15, 118, 110, 0.3);
        }

        /* Responsive Styles */
        @media (max-width: 991px) {
            .sambutan-container {
                flex-direction: column;
                text-align: center;
            }
            .sambutan-image-wrapper {
                flex: 0 0 auto;
                width: 280px;
            }
            .sambutan-image-wrapper::before {
                display: none;
            }
            .sambutan-content h2 {
                font-size: 30px;
            }
            .sambutan-quote {
                border-left: none;
                border-top: 4px solid var(--teal-main);
                border-radius: 16px;
            }
        }
        @media (max-width: 768px) {
            .modal-body {
                grid-template-columns: 1fr;
            }
            .modal-info-column {
                padding: 30px;
            }
            .prestasi-tabs-container {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>

    <!-- Top Bar -->
    <div class="top-bar">
        <span><i class="fa-solid fa-phone"></i> 08380798</span>
        <span><i class="fa-solid fa-location-dot"></i> Jl. Sianok Talu, Sinuruik, Kec. Talamau, Kab. Pasaman Barat, Sumbar, 26361</span>
    </div>

    <!-- Navbar -->
    <nav class="navbar">
        <a href="/" class="navbar-brand">
            <img src="{{ asset('LogoSekolah.png') }}" alt="Logo SMK N 1 Talamau">
            <div class="brand-text">
                <span class="title">SIMPRES</span>
                <span class="subtitle">SMK N 1 Talamau</span>
            </div>
        </a>
        <div class="nav-links">
            <a href="#" class="menu-item">Beranda</a>
            <a href="#pengumuman" class="menu-item">Pengumuman</a>
            <a href="#prestasi" class="menu-item">Publikasi Prestasi</a>
            <a href="#galeri" class="menu-item">Galeri</a>
            <a href="{{ url('/register') }}" class="menu-item" style="color: var(--teal-main); font-weight: 700;">
                📝 Daftar
            </a>
            <a href="{{ url('/login') }}" class="btn-login">
                Login <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-badge">
                    <i class="fa-solid fa-award"></i> Akreditasi A & Unggul
                </div>
                <h1>Sistem Informasi Manajemen <br><span>Prestasi Siswa</span></h1>
                <p>Platform resmi SMK Negeri 1 Talamau untuk mendata, memantau, dan mempublikasikan prestasi siswa. Mendukung transparansi akademik dan apresiasi terbaik bagi generasi penerus bangsa.</p>
                <div class="hero-buttons">
                    <a href="#prestasi" class="btn-primary-hero">Lihat Prestasi</a>
                    <a href="{{ url('/login') }}" class="btn-outline-hero"><i class="fa-solid fa-lock"></i> Login</a>
                </div>
            </div>
            <div class="hero-image">
                <!-- Foto ilustrasi sekolah/siswa modern -->
                <img src="{{ asset('Foto SMK_Halaman Utama.jpeg') }}" alt="SMK Negeri 1 Talamau" style="width:100%; border-radius:30px; box-shadow: 0 20px 50px rgba(0,0,0,0.1);">
                
                <div class="floating-card">
                    <div class="icon"><i class="fa-solid fa-trophy"></i></div>
                    <div>
                        <h4 style="color: var(--dark); font-weight: 700;">Juara Nasional</h4>
                        <p style="color: var(--gray-text); font-size: 13px;">Tahun 2026</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistik Counter -->
    <section class="stats">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
                <div class="stat-number" data-target="{{ $stats['total_siswa'] ?? 0 }}">0</div>
                <div class="stat-label">Total Siswa</div>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fa-solid fa-medal"></i></div>
                <div class="stat-number" data-target="{{ $stats['total_prestasi'] ?? 0 }}">0</div>
                <div class="stat-label">Total Prestasi</div>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fa-solid fa-flag-checkered"></i></div>
                <div class="stat-number" data-target="{{ $stats['lomba_diikuti'] ?? 0 }}">0</div>
                <div class="stat-label">Lomba Diikuti</div>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fa-solid fa-user-graduate"></i></div>
                <div class="stat-number" data-target="{{ $stats['siswa_berprestasi'] ?? 0 }}">0</div>
                <div class="stat-label">Siswa Berprestasi</div>
            </div>
        </div>
    </section>

    <!-- Sambutan Kepala Sekolah -->
    <section id="sambutan" class="sambutan-section section-padding">
        <div class="sambutan-container">
            <div class="sambutan-image-wrapper">
                <img src="{{ asset('susi_erawati.jpeg') }}" alt="Susi Erawati S.Pd - Kepala Sekolah SMK Negeri 1 Talamau">
            </div>
            <div class="sambutan-content">
                <h3>Kata Sambutan</h3>
                <h2>Kepala Sekolah SMK N 1 Talamau</h2>
                <div class="sambutan-quote">
                    "Tiada hari tanpa prestasi, tiada prestasi tanpa disiplin dan kerja keras. Bersama kita wujudkan generasi yang unggul, berkarakter, dan berdaya saing global."
                </div>
                <div class="sambutan-text">
                    <p>Selamat datang di platform SIMPRES (Sistem Informasi Manajemen Prestasi) SMK Negeri 1 Talamau. Kami sangat bangga mempersembahkan wadah digital ini untuk mencatat, mengapresiasi, dan mempublikasikan seluruh pencapaian luar biasa dari putra-putri terbaik kami.</p>
                    <p>Prestasi bukan hanya sebuah tujuan akhir, melainkan sebuah proses konsisten dari disiplin belajar, pembentukan karakter, dan bimbingan guru yang tulus. Melalui sistem ini, kami berharap dapat memicu semangat kompetitif yang sehat dan memberikan apresiasi setinggi-tingginya bagi siswa yang telah mengharumkan nama sekolah baik di tingkat regional, nasional, maupun internasional.</p>
                </div>
                <div class="sambutan-signature">
                    <span class="sambutan-name">Susi Erawati S.Pd</span>
                    <span class="sambutan-role">Kepala Sekolah SMK Negeri 1 Talamau</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Papan Pengumuman -->
    <section id="pengumuman" class="pengumuman section-padding">
        <div class="section-header">
            <h2 class="section-title">Papan Pengumuman</h2>
            <p class="section-subtitle">Informasi terbaru seputar kegiatan akademik, non-akademik, dan jadwal perlombaan yang akan datang.</p>
        </div>

        <div class="pengumuman-grid">
            <!-- Pengumuman 1 -->
            <div class="pengumuman-card">
                <i class="fa-solid fa-bullhorn pengumuman-icon"></i>
                <span class="pengumuman-date">15 Mei 2026</span>
                <h3 class="pengumuman-title">Olimpiade Sains Nasional Tingkat Kabupaten</h3>
                <p class="pengumuman-desc">Pendaftaran seleksi OSN tingkat kabupaten telah dibuka. Bagi siswa yang berminat mengikuti seleksi di bidang Matematika, Fisika, dan Informatika harap mendaftar ke guru pembina masing-masing paling lambat 20 Mei 2026.</p>
            </div>

            <!-- Pengumuman 2 -->
            <div class="pengumuman-card">
                <i class="fa-solid fa-trophy pengumuman-icon"></i>
                <span class="pengumuman-date">10 Mei 2026</span>
                <h3 class="pengumuman-title">Porseni (Pekan Olahraga dan Seni) Sekolah</h3>
                <p class="pengumuman-desc">Persiapkan kelas kalian! Porseni tahunan SMK N 1 Talamau akan dilaksanakan setelah ujian semester selesai. Cabang yang diperlombakan meliputi Voli, Futsal, Tari Tradisional, dan Vokal Solo.</p>
            </div>

            <!-- Pengumuman 3 -->
            <div class="pengumuman-card">
                <i class="fa-solid fa-file-circle-check pengumuman-icon"></i>
                <span class="pengumuman-date">01 Mei 2026</span>
                <h3 class="pengumuman-title">Validasi Data Prestasi Semester Ganjil</h3>
                <p class="pengumuman-desc">Diberitahukan kepada seluruh siswa untuk segera melaporkan sertifikat penghargaan terbaru kepada guru pembina. Data prestasi yang masuk akan diverifikasi untuk perhitungan capaian poin Key Performance Indicator (KPI).</p>
            </div>
        </div>
    </section>



    <!-- Publikasi Prestasi -->
    <section id="prestasi" class="prestasi section-padding">
        <div class="prestasi-header">
            <h2 class="prestasi-section-title">Prestasi</h2>
            <p class="prestasi-section-subtitle">Daftar kebanggaan SMK Negeri 1 Talamau yang telah mengukir sejarah di berbagai tingkatan perlombaan. Setiap pencapaian adalah bukti nyata semangat, kerja keras, dan dedikasi siswa-siswi terbaik kami.</p>
        </div>

        <!-- Tabs Filter -->
        <div class="prestasi-tabs-container">
            <button class="prestasi-tab-btn active" data-filter="internasional">🌎 Internasional</button>
            <button class="prestasi-tab-btn" data-filter="nasional">🇮🇩 Nasional</button>
            <button class="prestasi-tab-btn" data-filter="regional">🏔️ Regional</button>
        </div>

        <div class="prestasi-grid">
            @forelse($prestasis as $prestasi)
                @php
                    $dateObj = \Carbon\Carbon::parse($prestasi->tanggal_capaian);
                    $day = $dateObj->format('d');
                    $month = strtoupper($dateObj->translatedFormat('M'));
                    
                    $tingkatLower = strtolower($prestasi->tingkat);
                    if ($tingkatLower === 'internasional') {
                        $categoryTab = 'internasional';
                    } elseif ($tingkatLower === 'nasional') {
                        $categoryTab = 'nasional';
                    } else {
                        $categoryTab = 'regional';
                    }

                    $isImage = false;
                    if (!empty($prestasi->sertifikat)) {
                        $ext = strtolower(pathinfo($prestasi->sertifikat, PATHINFO_EXTENSION));
                        $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'webp']);
                    }
                @endphp

                <div class="prestasi-card" 
                     data-category="{{ $categoryTab }}"
                     data-nama-siswa="{{ $prestasi->siswa->nama ?? 'Siswa' }}"
                     data-kelas-siswa="{{ $prestasi->siswa->kelas ?? 'Siswa Berprestasi' }}"
                     data-nama-prestasi="{{ $prestasi->nama_prestasi }}"
                     data-tingkat="{{ $prestasi->tingkat }}"
                     data-juara="{{ $prestasi->juara }}"
                     data-tanggal="{{ \Carbon\Carbon::parse($prestasi->tanggal_capaian)->translatedFormat('d F Y') }}"
                     data-lokasi="{{ !empty($prestasi->lokasi) ? $prestasi->lokasi : 'SMK Negeri 1 Talamau' }}"
                     data-sertifikat="{{ !empty($prestasi->sertifikat) ? asset('uploads/sertifikat/' . $prestasi->sertifikat) : '' }}"
                     data-is-image="{{ $isImage ? 'true' : 'false' }}">
                    
                    <div class="prestasi-img-container">
                        <!-- Date Badge Model 09 MAR -->
                        <div class="prestasi-date-badge">
                            <span class="month">{{ $month }}</span>
                            <span class="day">{{ $day }}</span>
                        </div>

                        @if($isImage)
                            <img src="{{ asset('uploads/sertifikat/' . $prestasi->sertifikat) }}" alt="Prestasi" class="prestasi-img">
                        @else
                            <div class="prestasi-img fallback-banner">
                                <div class="fallback-header">
                                    <img src="{{ asset('LogoSekolah.png') }}" class="fallback-logo" alt="Logo">
                                    <span class="fallback-school-name">SMK NEGERI 1 TALAMAU</span>
                                </div>
                                <div class="fallback-body">
                                    <span class="fallback-congratulations">SELAMAT & SUKSES</span>
                                    <span class="fallback-subtitle">ATAS PRESTASI MEMBANGGAKAN</span>
                                    <h4 class="fallback-student-name">{{ $prestasi->siswa->nama ?? 'Siswa' }}</h4>
                                    <p class="fallback-achievement">{{ $prestasi->juara }} - {{ $prestasi->tingkat }}</p>
                                </div>
                                <div class="fallback-footer">
                                    <span>SIMPRES - SMK N 1 TALAMAU</span>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="prestasi-content">
                        <h3 class="prestasi-title">{{ $prestasi->siswa->nama ?? 'Siswa' }}, Siswa {{ $prestasi->siswa->kelas ?? '' }} - {{ $prestasi->nama_prestasi }}</h3>
                        <button class="btn-view-details">View Details</button>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px; background: var(--gray-bg); border-radius: 24px;">
                    <i class="fa-solid fa-box-open" style="font-size: 60px; color: var(--sky-blue); margin-bottom: 20px;"></i>
                    <h3 style="font-size: 24px; color: var(--dark);">Belum Ada Data</h3>
                    <p style="color: var(--gray-text);">Publikasi prestasi akan segera diperbarui oleh pihak sekolah.</p>
                </div>
            @endforelse
        </div>

        <!-- Button Lihat Lebih Banyak Penayangan -->
        <div class="prestasi-more-container">
            <button class="btn-more-prestasi">Lihat Lebih Banyak Penayangan ❯</button>
        </div>
    </section>

    <!-- Galeri Sekolah -->
    <section id="galeri" class="gallery section-padding">
        <div class="section-header">
            <h2 class="section-title">Galeri Kegiatan</h2>
            <p class="section-subtitle">Potret aktivitas dan semangat belajar siswa-siswi di lingkungan SMK Negeri 1 Talamau.</p>
        </div>

        <div class="gallery-grid">
            <!-- Galeri Item 1 -->
            <div class="gallery-item">
                <img src="{{ asset('Kegiatan 1.jpeg') }}" alt="Kegiatan 1">
                <div class="gallery-overlay"><div class="gallery-text">Peringatan Hari Jadi Sumatera Barat</div></div>
            </div>
            <!-- Galeri Item 2 -->
            <div class="gallery-item">
                <img src="{{ asset('Kegiatan 2.jpeg') }}" alt="Kegiatan 2">
                <div class="gallery-overlay"><div class="gallery-text">Lomba Nyanyi</div></div>
            </div>
            <!-- Galeri Item 3 -->
            <div class="gallery-item">
                <img src="{{ asset('Kegiatan 3.jpeg') }}" alt="Kegiatan 3">
                <div class="gallery-overlay"><div class="gallery-text">Olahraga</div></div>
            </div>
            <!-- Galeri Item 4 -->
            <div class="gallery-item">
                <img src="{{ asset('kegiatan_apresiasi.jpg') }}" alt="Hadiah Juara Apresiasi SMK">
                <div class="gallery-overlay"><div class="gallery-text">Hadiah Juara Apresiasi SMK</div></div>
            </div>
            <!-- Galeri Item 5 -->
            <div class="gallery-item">
                <img src="{{ asset('kegiatan_ukk.png') }}" alt="Ujian UKK">
                <div class="gallery-overlay"><div class="gallery-text">Ujian UKK</div></div>
            </div>
            <!-- Galeri Item 6 -->
            <div class="gallery-item">
                <img src="{{ asset('kegiatan_tsm.jpg') }}" alt="Kegiatan Jurusan TSM">
                <div class="gallery-overlay"><div class="gallery-text">Kegiatan Jurusan TSM</div></div>
            </div>
        </div>

        <!-- Button Lihat Lebih Banyak Penayangan Galeri -->
        <div class="gallery-more-container">
            <button class="btn-more-prestasi btn-more-gallery" id="btnMoreGallery">
                <i class="fa-solid fa-images"></i> Lihat Lebih Banyak Penayangan ❯
            </button>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-grid">
            <div class="footer-brand">
                <h2>SIMPRES</h2>
                <p>Sistem Informasi Manajemen Prestasi & Bakat Siswa SMK Negeri 1 Talamau. Menjadi wadah digital resmi untuk mendata dan mengapresiasi generasi bangsa berprestasi tinggi.</p>
                <div class="social-links">
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
            </div>

            <div>
                <h3 class="footer-title">Tautan Cepat</h3>
                <ul class="footer-links">
                    <li><a href="#">Beranda</a></li>
                    <li><a href="#prestasi">Publikasi Prestasi</a></li>
                    <li><a href="/login">Portal Admin & Siswa</a></li>
                </ul>
            </div>

            <div>
                <h3 class="footer-title">Alamat & Kontak</h3>
                <ul class="footer-contact">
                    <li><i class="fa-solid fa-location-dot"></i> <span>Jl. Sianok Talu, Sinuruik, Kec. Talamau, Kab. Pasaman Barat, Sumbar, 26361</span></li>
                    <li><i class="fa-solid fa-envelope"></i> <span>info@smkn1talamau.sch.id</span></li>
                    <li><i class="fa-solid fa-phone"></i> <span>08380798</span></li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} SMK Negeri 1 Talamau. Dibuat untuk Sistem Manajemen Prestasi (SIMPRES).</p>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <button id="scrollTopBtn" title="Scroll ke atas">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    <!-- Modal Pop-up Detail Prestasi -->
    <div class="modal-overlay" id="prestasiModal">
        <div class="modal-container">
            <button class="modal-close-btn" id="modalCloseBtn">&times;</button>
            <div class="modal-body">
                <div class="modal-img-column" id="modalImgCol">
                    <img src="" alt="Sertifikat Prestasi" class="modal-img" id="modalSertifikatImg">
                    <div id="modalNoImgPlaceholder" style="display: none; color: white; text-align: center; padding: 30px;">
                        <i class="fa-solid fa-trophy" style="font-size: 80px; margin-bottom: 15px; color: #f59e0b;"></i>
                        <h3 style="font-size: 20px; font-weight: 700;">Dokumen Sertifikat</h3>
                        <p style="font-size: 13px; opacity: 0.8; line-height: 1.4;">Sertifikat fisik belum diunggah oleh siswa.</p>
                    </div>
                </div>
                <div class="modal-info-column">
                    <div>
                        <!-- Profil Siswa -->
                        <div class="modal-student-profile">
                            <div class="modal-avatar" id="modalAvatar">S</div>
                            <div>
                                <h4 class="modal-student-name" id="modalStudentName">Nama Siswa</h4>
                                <p class="modal-student-class" id="modalStudentClass">Kelas / Jurusan</p>
                            </div>
                        </div>

                        <!-- Pengumuman Resmi Formal (SATU tampilan, tidak duplikat) -->
                        <div class="modal-announcement" id="modalAnnouncement">
                            <div class="modal-announcement-header">
                                <div class="modal-announcement-logo">
                                    <i class="fa-solid fa-award"></i>
                                </div>
                                <div class="modal-announcement-school">
                                    PENGUMUMAN RESMI
                                    <span>SMK Negeri 1 Talamau · SIMPRES</span>
                                </div>
                            </div>
                            <p class="modal-announcement-body" id="modalAnnouncementBody">
                                <!-- Diisi oleh JavaScript -->
                            </p>
                            <div class="modal-announcement-footer">
                                <span class="ann-badge" id="modalAnnTingkat">Nasional</span>
                                <span class="ann-date" id="modalAnnDate">—</span>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden fields untuk JS (tidak ditampilkan) -->
                    <span id="modalTingkat" style="display:none"></span>
                    <span id="modalJuara" style="display:none"></span>
                    <span id="modalTanggal" style="display:none"></span>
                    <span id="modalLokasi" style="display:none"></span>

                    <div class="modal-footer">
                        <a href="" target="_blank" class="btn-modal-certificate" id="modalCertLink" style="display: none;">
                            <i class="fa-solid fa-file-arrow-down"></i> Lihat/Unduh Sertifikat
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script for Counter Animation & Tabs / Modal -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const counters = document.querySelectorAll('.stat-number');
            const speed = 100; // The lower the slower

            const animateCounters = () => {
                counters.forEach(counter => {
                    const updateCount = () => {
                        const target = +counter.getAttribute('data-target');
                        const count = +counter.innerText;
                        const inc = target / speed;

                        if (count < target) {
                            counter.innerText = Math.ceil(count + inc);
                            setTimeout(updateCount, 20);
                        } else {
                            counter.innerText = target + "+";
                        }
                    };
                    updateCount();
                });
            };

            // Trigger animation when stats section is visible
            const statsSection = document.querySelector('.stats');
            let animated = false;

            window.addEventListener('scroll', () => {
                const statsSectionTop = statsSection.getBoundingClientRect().top;
                const screenPos = window.innerHeight;

                if(statsSectionTop < screenPos && !animated) {
                    animateCounters();
                    animated = true;
                }

                // Show/Hide Scroll to Top Button
                const scrollTopBtn = document.getElementById('scrollTopBtn');
                if (window.scrollY > 300) {
                    scrollTopBtn.classList.add('show');
                } else {
                    scrollTopBtn.classList.remove('show');
                }
            });

            // Scroll to Top Button Click Handler
            const scrollTopBtn = document.getElementById('scrollTopBtn');
            scrollTopBtn.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            // --- TABS & MODAL POP-UP PRESTASI ---
            const tabButtons = document.querySelectorAll('.prestasi-tab-btn');
            const prestasiCards = document.querySelectorAll('.prestasi-card');
            
            // Function to filter cards by tab
            const filterPrestasi = (category) => {
                let hasVisibleCards = false;
                prestasiCards.forEach(card => {
                    if (card.getAttribute('data-category') === category) {
                        card.classList.remove('hidden');
                        hasVisibleCards = true;
                    } else {
                        card.classList.add('hidden');
                    }
                });

                // Handle empty state if no achievements found for this tab
                const grid = document.querySelector('.prestasi-grid');
                let emptyMsg = document.getElementById('tabEmptyMsg');
                
                if (!hasVisibleCards) {
                    if (!emptyMsg) {
                        emptyMsg = document.createElement('div');
                        emptyMsg.id = 'tabEmptyMsg';
                        emptyMsg.style.gridColumn = '1 / -1';
                        emptyMsg.style.textAlign = 'center';
                        emptyMsg.style.padding = '60px';
                        emptyMsg.style.background = 'var(--gray-bg)';
                        emptyMsg.style.borderRadius = '24px';
                        emptyMsg.innerHTML = `
                            <i class="fa-solid fa-box-open" style="font-size: 60px; color: var(--sky-blue); margin-bottom: 20px;"></i>
                            <h3 style="font-size: 24px; color: var(--dark);">Belum Ada Data</h3>
                            <p style="color: var(--gray-text);">Belum ada publikasi prestasi untuk tingkat ini.</p>
                        `;
                        grid.appendChild(emptyMsg);
                    } else {
                        emptyMsg.style.display = 'block';
                    }
                } else {
                    if (emptyMsg) {
                        emptyMsg.style.display = 'none';
                    }
                }
            };

            // Set default active tab filter on load
            const activeTab = document.querySelector('.prestasi-tab-btn.active');
            if (activeTab) {
                filterPrestasi(activeTab.getAttribute('data-filter'));
            }

            // Tab click events
            tabButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    tabButtons.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    filterPrestasi(btn.getAttribute('data-filter'));
                });
            });

            // Modal Handlers
            const modal = document.getElementById('prestasiModal');
            const closeBtn = document.getElementById('modalCloseBtn');

            const openModal = (card) => {
                const name = card.getAttribute('data-nama-siswa');
                const kelas = card.getAttribute('data-kelas-siswa');
                const title = card.getAttribute('data-nama-prestasi');
                const tingkat = card.getAttribute('data-tingkat');
                const juara = card.getAttribute('data-juara');
                const tanggal = card.getAttribute('data-tanggal');
                const lokasi = card.getAttribute('data-lokasi');
                const sertifikat = card.getAttribute('data-sertifikat');
                const isImage = card.getAttribute('data-is-image') === 'true';

                // Populate student profile
                document.getElementById('modalStudentName').innerText = name;
                document.getElementById('modalStudentClass').innerText = kelas;
                document.getElementById('modalAvatar').innerText = name ? name.charAt(0).toUpperCase() : 'S';

                // Populate hidden spans (used for cert link etc)
                document.getElementById('modalTingkat').innerText = tingkat;
                document.getElementById('modalJuara').innerText = juara;
                document.getElementById('modalTanggal').innerText = tanggal;
                document.getElementById('modalLokasi').innerText = lokasi;

                // Build ONE elegant formal announcement
                const kelasText = kelas || 'Siswa Berprestasi';
                const satuanTingkat = tingkat ? 'Tingkat <span class="highlight-bold">' + tingkat + '</span>' : '';
                const infoLokasi = (lokasi && lokasi !== 'SMK Negeri 1 Talamau') ? lokasi : '';
                const lokasiText = infoLokasi
                    ? ' yang diselenggarakan di <span class="highlight-bold">' + infoLokasi + '</span>'
                    : '';
                const tanggalText = tanggal
                    ? ' pada tanggal <span class="highlight-bold">' + tanggal + '</span>'
                    : '';

                const announcementHTML =
                    `Dengan penuh kebanggaan dan rasa syukur, kami menyampaikan bahwa ` +
                    `<span class="highlight-name">${name}</span>, ` +
                    `siswa <span class="highlight-bold">${kelasText}</span> SMK Negeri 1 Talamau, ` +
                    `telah berhasil meraih ` +
                    `<span class="highlight-award">🏆 ${juara}</span> ` +
                    `pada ajang <span class="highlight-bold">${title}</span> ` +
                    `${satuanTingkat}${lokasiText}${tanggalText}. ` +
                    `Semoga prestasi ini menjadi inspirasi bagi seluruh keluarga besar SMK Negeri 1 Talamau.`;

                document.getElementById('modalAnnouncementBody').innerHTML = announcementHTML;

                // Badge tingkat & tanggal di footer announcement
                document.getElementById('modalAnnTingkat').innerText = tingkat || 'Prestasi';
                document.getElementById('modalAnnDate').innerText = tanggal ? '📅 ' + tanggal : '';

                // Handle Image or Placeholder
                const certImg = document.getElementById('modalSertifikatImg');
                const placeholder = document.getElementById('modalNoImgPlaceholder');
                const certLinkBtn = document.getElementById('modalCertLink');

                if (sertifikat && isImage) {
                    certImg.src = sertifikat;
                    certImg.style.display = 'block';
                    placeholder.style.display = 'none';
                    certLinkBtn.href = sertifikat;
                    certLinkBtn.style.display = 'inline-flex';
                } else {
                    certImg.style.display = 'none';
                    placeholder.style.display = 'block';
                    certLinkBtn.style.display = 'none';
                }

                // Show modal
                modal.classList.add('open');
                document.body.style.overflow = 'hidden'; // Disable page scroll
            };

            const closeModal = () => {
                modal.classList.remove('open');
                document.body.style.overflow = 'auto'; // Enable page scroll
            };

            // Event Listeners for Open Modal
            prestasiCards.forEach(card => {
                card.addEventListener('click', (e) => {
                    openModal(card);
                });
                
                const btn = card.querySelector('.btn-view-details');
                if (btn) {
                    btn.addEventListener('click', (e) => {
                        e.stopPropagation(); // Prevent trigger card click twice
                        openModal(card);
                    });
                }
            });

            // Close events
            closeBtn.addEventListener('click', closeModal);
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closeModal();
                }
            });
            window.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && modal.classList.contains('open')) {
                    closeModal();
                }
            });

            // "Lihat Lebih Banyak Penayangan" - Prestasi section
            const btnMore = document.querySelector('.btn-more-prestasi:not(.btn-more-gallery)');
            if (btnMore) {
                btnMore.addEventListener('click', () => {
                    document.getElementById('prestasi').scrollIntoView({ behavior: 'smooth' });
                });
            }

            // "Lihat Lebih Banyak Penayangan" - Gallery section
            const btnMoreGallery = document.getElementById('btnMoreGallery');
            if (btnMoreGallery) {
                btnMoreGallery.addEventListener('click', () => {
                    // Scroll smoothly to galeri section top for full view
                    document.getElementById('galeri').scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            }
        });
    </script>

</body>
</html>
