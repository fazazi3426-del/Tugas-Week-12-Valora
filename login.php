<?php
session_start();
include 'config.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Sesuai diagram alir: Cek di database
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    
    if (mysqli_num_rows($query) > 0) {
        $_SESSION['username'] = $username;
        // Sesuai diagram alir: Arahkan ke Dashboard
        header("Location: index.php");
    } else {
        $error = "Username atau password keliru. Silakan coba lagi.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - VALORA Campus Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Pengaturan Dasar */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fafafa; /* Warna abu-abu sangat terang khas IG */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Container Utama */
        .main-container {
            display: flex;
            max-width: 900px;
            width: 100%;
            align-items: center;
            gap: 40px;
            padding: 20px;
        }

        /* --- Sisi Kiri: Visual & Logo --- */
        .visual-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
        }

        .main-logo {
            width: 100%;
            max-width: 200px; /* Ukuran proporsional */
            height: auto;
            margin-bottom: 30px;
        }

        .hook-title {
            font-size: 2rem;
            font-weight: 600;
            color: #262626; /* Warna hitam soft */
            line-height: 1.3;
            margin-bottom: 15px;
        }

        .hook-title span {
            color: #3b823e; /* Aksen hijau VALORA */
            font-weight: 700;
        }

        .hook-subtitle {
            font-size: 1rem;
            font-weight: 400;
            color: #737373;
            line-height: 1.6;
            max-width: 320px;
        }

        /* --- Sisi Kanan: Area Form Login ala IG --- */
        .form-section {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .login-box {
            background-color: #ffffff;
            border: 1px solid #dbdbdb; /* Border tipis khas IG */
            border-radius: 2px;
            padding: 40px;
            width: 100%;
            max-width: 380px;
            text-align: center;
        }

        .login-header {
            font-size: 1.2rem;
            font-weight: 600;
            color: #262626;
            margin-bottom: 25px;
        }

        /* Desain Form Input Minimalis */
        .form-group {
            margin-bottom: 10px;
            position: relative;
        }

        .form-group input {
            width: 100%;
            background-color: #fafafa;
            border: 1px solid #dbdbdb;
            border-radius: 4px;
            padding: 12px 10px;
            font-size: 0.85rem;
            font-family: 'Poppins', sans-serif;
            color: #262626;
            transition: border-color 0.2s ease;
        }

        .form-group input:focus {
            border-color: #a8a8a8;
            outline: none;
            background-color: #ffffff;
        }

        /* Desain Tombol Interaktif */
        .btn-login {
            width: 100%;
            padding: 10px;
            background-color: #3b823e; /* Hijau VALORA */
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
            margin-top: 10px;
            font-family: 'Poppins', sans-serif;
        }

        .btn-login:hover {
            background-color: #2c632e;
        }

        /* Garis Pemisah (Divider) ala IG */
        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
        }

        .divider::before, .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background-color: #dbdbdb;
        }

        .divider span {
            padding: 0 15px;
            color: #737373;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* Pesan Error */
        .error-msg {
            color: #ed4956; /* Merah khas error IG */
            margin-bottom: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* Link Register */
        .register-box {
            margin-top: 15px;
        }

        .register-link {
            font-size: 0.9rem;
            color: #262626;
        }

        .register-link a {
            color: #3b823e; /* Hijau VALORA */
            text-decoration: none;
            font-weight: 600;
        }

        /* Responsif untuk Layar Kecil (HP) */
        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
                gap: 20px;
            }
            .visual-section {
                display: none; /* Menyembunyikan gambar di HP agar fokus ke form (seperti IG) */
            }
            .login-box {
                border: none; /* Hilangkan border di HP */
                background-color: transparent;
                padding: 20px;
            }
            body {
                background-color: #ffffff; /* Latar putih penuh di HP */
            }
        }
    </style>
</head>
<body>

    <div class="main-container">
        
        <div class="visual-section">
            <img src="Gambar/Logo.png" alt="VALORA Logo" class="main-logo">
            
            <h1 class="hook-title">Satu Gerbang.<br><span>Ribuan Solusi.</span></h1>
            <p class="hook-subtitle">Bergabunglah dan penuhi semua kebutuhan kampusmu dengan lebih cepat dan aman di satu ekosistem.</p>
        </div>

        <div class="form-section">
            <div class="login-box">
                <h2 class="login-header">Masuk ke Valora</h2>

                <?php if(isset($error)) echo "<div class='error-msg'>$error</div>"; ?>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <input type="text" id="username" name="username" placeholder="Username, email, atau nomor HP" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input type="password" id="password" name="password" placeholder="Password" required>
                    </div>
                    
                    <button type="submit" name="login" class="btn-login">Log in</button>
                </form>

                <div class="divider">
                    <span>ATAU</span>
                </div>

                <div class="register-box">
                    <p class="register-link">Belum punya akun? <a href="register.php">Buat akun baru</a></p>
                </div>
            </div>
        </div>

    </div>

</body>
</html>