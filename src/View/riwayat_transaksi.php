<?php
require_once "../Service/TransactionService.php";
require_once "../Service/UserService.php";
$transactionService = new TransactionService();
$userService = new UserService();
$transaksi = $transactionService->getAllTransaction();

try{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!isset($_SESSION['nik'])) {
            throw new Exception("Anda belum login. Silakan login terlebih dahulu.");
        }
        $nik = $_SESSION['nik'];

    }
} catch (Exception $e) {
    $error = $e->getMessage();
}
?>

<html>
<head>
    <title> Riwayat Transaksi </title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
</head>
<body>
<?php include "navbar.php" ?>
<div class="container mt-3 border-dark">
    <h1 class="text-center"> Semua Permintaan yang Tersedia</h1>
    <?php foreach($transaksi as $transaksi):?>
        <a href="detail_perminataan.php?id=<?php echo $transaksi['id']?>" class="text-decoration-none">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"> <?php echo $transaksi['id_transaksi']?></h5>
                    <p class="card-text"><small class="text-body-secondary">Created by : <?php echo $permintaan['nama_donatur'] ?></small></p>
                    <p class="card-text"><small class="text-body-secondary">Created at : <?php echo $permintaan['nama_penerima']?></small></p>
                    <p class="card-text"><small class="text-body-secondary">Created at : <?php echo $permintaan['waktu_transaksi']?></small></p>
                    <p class="card-text"><small class="text-body-secondary">Created at : <?php echo $permintaan['tipe_transaksi']?></small></p>
                </div>
            </div>
        </a>
    <?php endforeach;?>
</div>
</body>