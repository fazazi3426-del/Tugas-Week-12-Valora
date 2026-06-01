<?php
session_start();
// Keamanan: Tendang ke login jika belum ada sesi
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
include 'config.php';

// Menarik ID dari URL (contoh: edit.php?id=1)
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM layanan WHERE id='$id'");
$data = mysqli_fetch_array($query);

// Jika tombol Update ditekan
if (isset($_POST['update'])) {
    $nama = $_POST['nama_layanan'];
    $kategori = $_POST['kategori'];
    $status = $_POST['status'];

    mysqli_query($conn, "UPDATE layanan SET nama_layanan='$nama', kategori='$kategori', status='$status' WHERE id='$id'");
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Layanan - VALORA Campus Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Pengaturan Dasar identik dengan create.php */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background-color: #fafafa; color: #262626; }

        .navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #dbdbdb;
            padding: 15px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        }
        .navbar img { max-height: 40px; }
        .navbar-title { font-weight: 600; color: #737373; font-size: 0.95rem; }

        .container { max-width: 650px; margin: 50px auto; padding: 0 20px; }
        .card {
            background: #ffffff;
            border: 1px solid #dbdbdb;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        }
        
        .card-header { margin-bottom: 30px; border-bottom: 1px solid #f0f0f0; padding-bottom: 20px; }
        .card-header h2 { color: #1565c0; /* Warna biru untuk membedakan mode Edit */ font-size: 1.6rem; font-weight: 700; margin-bottom: 5px; }
        .card-header p { color: #737373; font-size: 0.95rem; }

        .form-group { margin-bottom: 25px; }
        .form-group label { display: block; margin-bottom: 10px; font-weight: 600; font-size: 0.95rem; color: #444; }
        .form-group input, .form-group select {
            width: 100%;
            padding: 14px 16px;
            border: 1.5px solid #e1e5ee;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
            background-color: #fcfcfc;
            transition: all 0.3s ease;
        }
        .form-group input:focus, .form-group select:focus {
            border-color: #1565c0;
            background-color: #fff;
            outline: none;
            box-shadow: 0 0 0 4px rgba(21, 101, 192, 0.15);
        }

        .btn-group { display: flex; gap: 15px; margin-top: 35px; }
        .btn-submit {
            flex: 1;
            padding: 14px;
            background: linear-gradient(to right, #1976d2, #1565c0); /* Warna biru untuk Update */
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            font-family: 'Poppins', sans-serif;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(21, 101, 192, 0.25); }
        
        .btn-cancel {
            flex: 1;
            padding: 14px;
            background-color: #ffffff;
            color: #555;
            border: 2px solid #e1e5ee;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-cancel:hover { background-color: #f9f9f9; border-color: #d1d5db; color: #333; }

        @media (max-width: 600px) {
            .navbar { padding: 15px 20px; }
            .card { padding: 25px; }
            .btn-group { flex-direction: column-reverse; }
        }
    </style>
</head>
<body>

    <div class="navbar">
        <img src="Gambar/Logo.png" alt="VALORA Logo">
        <div class="navbar-title">Panel Admin</div>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Edit Data Layanan</h2>
                <p>Perbarui informasi layanan pada ID #<?php echo $data['id']; ?></p>
            </div>

            <form method="POST" action="">
                <div class="form-group">
                    <label>Nama Layanan</label>
                    <input type="text" name="nama_layanan" value="<?php echo htmlspecialchars($data['nama_layanan']); ?>" required autocomplete="off">
                </div>
                
                <div class="form-group">
                    <label>Kategori Kebutuhan</label>
                    <input type="text" name="kategori" value="<?php echo htmlspecialchars($data['kategori']); ?>" required autocomplete="off">
                </div>
                
                <div class="form-group">
                    <label>Status Operasional</label>
                    <select name="status" required>
                        <option value="Tersedia" <?php if($data['status'] == 'Tersedia') echo 'selected'; ?>>🟢 Tersedia / Aktif</option>
                        <option value="Penuh" <?php if($data['status'] == 'Penuh') echo 'selected'; ?>>🟡 Penuh / Sedang Digunakan</option>
                        <option value="Tutup" <?php if($data['status'] == 'Tutup') echo 'selected'; ?>>🔴 Tutup / Maintenance</option>
                    </select>
                </div>
                
                <div class="btn-group">
                    <a href="index.php" class="btn-cancel">Batal</a>
                    <button type="submit" name="update" class="btn-submit">Update Data</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>