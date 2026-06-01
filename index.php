<?php
session_start();
// Jika belum login, kembalikan ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
include 'config.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - VALORA Campus Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Pengaturan Dasar */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background-color: #fafafa; color: #262626; }

        /* Navbar / Header Atas */
        .navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #dbdbdb;
            padding: 15px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        }
        .navbar-brand { display: flex; align-items: center; gap: 15px; }
        .navbar img { max-height: 40px; }
        .navbar-user { font-size: 0.95rem; color: #555; display: flex; align-items: center; gap: 20px; }
        
        .btn-logout {
            padding: 8px 16px;
            background-color: #fff0f0;
            color: #d32f2f;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s;
        }
        .btn-logout:hover { background-color: #ffebee; }

        /* Area Utama Dashboard */
        .container { max-width: 1000px; margin: 40px auto; padding: 0 20px; }
        
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 25px;
        }
        .dashboard-header h2 { color: #262626; font-size: 1.8rem; font-weight: 700; }
        .dashboard-header p { color: #737373; font-size: 0.95rem; margin-top: 5px; }

        .btn-tambah {
            padding: 12px 20px;
            background: linear-gradient(to right, #4CAF50, #388E3C);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            box-shadow: 0 4px 10px rgba(76, 175, 80, 0.2);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-tambah:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(76, 175, 80, 0.3); }

        /* Desain Tabel Modern */
        .table-container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.04);
            overflow: hidden; /* Memastikan sudut melengkung menutupi tabel */
            border: 1px solid #eee;
        }
        table { width: 100%; border-collapse: collapse; }
        thead { background-color: #f4f9f4; }
        th {
            padding: 18px 20px;
            text-align: left;
            font-size: 0.85rem;
            font-weight: 600;
            color: #3b823e;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        td {
            padding: 16px 20px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.95rem;
            color: #444;
            vertical-align: middle;
        }
        tr:last-child td { border-bottom: none; }
        tr:hover { background-color: #fafbfc; }

        /* Desain Status Badge (Pill) */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
        }
        .status-tersedia { background-color: #e8f5e9; color: #2e7d32; }
        .status-penuh { background-color: #fff8e1; color: #f57f17; }
        .status-tutup { background-color: #ffebee; color: #c62828; }

        /* Tombol Aksi (Edit & Delete) */
        .action-btns { display: flex; gap: 10px; }
        .btn-sm {
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .btn-edit { background-color: #e3f2fd; color: #1565c0; }
        .btn-edit:hover { background-color: #bbdefb; }
        
        .btn-delete { background-color: #ffebee; color: #c62828; }
        .btn-delete:hover { background-color: #ffcdd2; }

        /* Responsif HP */
        @media (max-width: 768px) {
            .navbar { padding: 15px 20px; flex-direction: column; gap: 15px; }
            .dashboard-header { flex-direction: column; align-items: flex-start; gap: 20px; }
            .table-container { overflow-x: auto; } /* Tabel bisa digeser ke kanan-kiri di HP */
            th, td { white-space: nowrap; }
        }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="navbar-brand">
            <img src="Gambar/Logo.png" alt="VALORA Logo">
        </div>
        <div class="navbar-user">
            Halo, <strong><?php echo $_SESSION['username']; ?></strong>!
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
    </div>

    <div class="container">
        
        <div class="dashboard-header">
            <div>
                <h2>Manajemen Layanan</h2>
                <p>Kelola semua data layanan yang beroperasi di ekosistem VALORA.</p>
            </div>
            <a href="create.php" class="btn-tambah">+ Tambah Layanan</a>
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th width="35%">Nama Layanan</th>
                        <th width="20%">Kategori</th>
                        <th width="20%">Status</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Mengambil data dari database, diurutkan dari ID terbaru (opsional tapi bagus)
                    $data = mysqli_query($conn, "SELECT * FROM layanan ORDER BY id DESC");
                    
                    // Mengecek apakah tabel kosong
                    if (mysqli_num_rows($data) == 0) {
                        echo "<tr><td colspan='5' style='text-align:center; padding:30px; color:#999;'>Belum ada layanan yang ditambahkan.</td></tr>";
                    } else {
                        while ($row = mysqli_fetch_array($data)) {
                            echo "<tr>";
                            echo "<td>#" . $row['id'] . "</td>";
                            echo "<td><strong>" . htmlspecialchars($row['nama_layanan']) . "</strong></td>";
                            echo "<td>" . htmlspecialchars($row['kategori']) . "</td>";
                            
                            // Logika untuk mewarnai Status Badge sesuai isinya
                            $status_class = "";
                            if ($row['status'] == "Tersedia") {
                                $status_class = "status-tersedia";
                            } elseif ($row['status'] == "Penuh") {
                                $status_class = "status-penuh";
                            } else {
                                $status_class = "status-tutup";
                            }
                            
                            echo "<td><span class='status-badge $status_class'>" . $row['status'] . "</span></td>";
                            
                            echo "<td class='action-btns'>
                                    <a href='edit.php?id=" . $row['id'] . "' class='btn-sm btn-edit'>Edit</a>
                                    <a href='delete.php?id=" . $row['id'] . "' class='btn-sm btn-delete' onclick='return confirm(\"Apakah Anda yakin ingin mencabut layanan ini dari sistem?\")'>Hapus</a>
                                  </td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>