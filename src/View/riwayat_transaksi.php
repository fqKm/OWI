<?php
require_once "../Service/TransactionService.php";
require_once "../Service/UserService.php";
$transactionService = new TransactionService();
$userService = new UserService();
$nik = $userService->getNikBySession();
$penerimaan = $transactionService->getRequestTransaction($nik);
$donasi = $transactionService->getDonateTransaction($nik);
?>

<html>
<head>
    <title>Riwayat Transaksi</title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Transaksi</title>
    <style>
        .table-container {
            display: none;
        }
        .table-container.active {
            display: block;
        }
    </style>
</head>

<body>
<?php include "navbar.php" ?>
<div class="container mt-5">
    <h2 class="text-center mb-4">Daftar Transaksi</h2>
    
    <!-- Tombol Switch -->
    <div class="text-center mb-3">
        <button class="btn btn-primary" id="toggleTableBtn">Riwayat Donasi</button>
    </div>

    <!-- Tabel 1 -->
    <div id="table1" class="table-container active">
        <h3 class="text-center">Riwayat Donasi</h3>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID Transaksi</th>
                    <th>Nama Penerima</th>
                    <th>ID Postingan</th>
                    <th>Nomor Resi</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($donasi) {
                    foreach ($donasi as $donasi) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($donasi['id_transaksi']) . "</td>";
                        echo "<td>" . htmlspecialchars($donasi['nama_penerima']) . "</td>";
                        echo "<td>" . htmlspecialchars($donasi['id_postingan']) . "</td>";
                        echo "<td>" . htmlspecialchars($donasi['nomor_resi']) . "</td>";
                        echo "<td>" . htmlspecialchars($donasi['waktu_transaksi']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>Tidak ada transaksi tersedia.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Tabel 2 -->
    <div id="table2" class="table-container">
        <h3 class="text-center">Riwayat penerimaan</h3>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID Transaksi</th>
                    <th>Nama Pengirim</th>
                    <th>ID Postingan</th>
                    <th>Nomor Resi</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Anda bisa mengganti data ini sesuai kebutuhan, misalnya menampilkan data lain atau data yang berbeda
                if ($penerimaan) {
                    foreach ($penerimaan as $penerimaan) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($penerimaan['id_transaksi']) . "</td>";
                        echo "<td>" . htmlspecialchars($penerimaan['nama_donatur']) . "</td>";
                        echo "<td>" . htmlspecialchars($penerimaan['id_postingan']) . "</td>";
                        echo "<td>" . htmlspecialchars($penerimaan['nomor_resi']) . "</td>";
                        echo "<td>" . htmlspecialchars($penerimaan['waktu_transaksi']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>Tidak ada transaksi tersedia.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    const toggleButton = document.getElementById('toggleTableBtn');
    const table1 = document.getElementById('table1');
    const table2 = document.getElementById('table2');
    let isTable1Active = true;

    toggleButton.addEventListener('click', () => {
        if (isTable1Active) {
            table1.classList.remove('active');
            table2.classList.add('active');
            toggleButton.textContent = 'Tampilkan Tabel 1';
        } else {
            table2.classList.remove('active');
            table1.classList.add('active');
            toggleButton.textContent = 'Tampilkan Tabel 2';
        }
        isTable1Active = !isTable1Active;
    });
</script>

</body>
</html>