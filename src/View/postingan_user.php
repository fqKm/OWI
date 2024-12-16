<?php
require_once "../Service/OfferPostService.php";
require_once "../Service/RequestPostService.php";
session_start();
$nik = $_SESSION['nik'];
$offerPostService = new OfferPostService();
$requestPostService = new RequestPostService();
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_offer_id"])){
    $id = $_POST["delete_offer_id"];
    $offerPostService->deleteOfferingPost($id);
}
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_request_id"])){
    $id = $_POST["delete_request_id"];
    $requestPostService->deleteRequestPost($id);
}
$postPenawaran = $offerPostService->getOfferingPostByNik($nik);
$postPermintaan = $requestPostService->getRequestPostByNik($nik);
?>
<html>
<head>
    <title> Homepage </title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
</head>
<body>
<?php include "navbar.php" ?>
<div class="container mt-3 border-dark">
    <h1 class="text-center"> Penawaran yang Sedang Baru</h1>
    <?php foreach($postPenawaran as $penawaran):?>
        <a href="detail_penawaran.php?id=<?php echo (int)$penawaran['id']?>" class="text-decoration-none">
            <div class="card mb-3">
                <img src="<?php echo $penawaran['foto']?>" class="card-img-top" alt="Post Image">
                <div class="card-body">
                    <h5 class="card-title"> <?php echo $penawaran['judul']?></h5>
                    <p class="card-text"><small class="text-body-secondary">Created by : <?php echo $penawaran['nama_depan']." ".$penawaran['nama_belakang'] ?></small></p>
                    <p class="card-text"><small class="text-body-secondary">Created at : <?php echo $penawaran['dibuat_pada']?></small></p>
                </div>
            </div>
        </a>
        <div class="text-center mt-4">
            <a href="edit_penawaran.php?id=<?php echo (int)$penawaran['id']?>" class="btn btn-success"> Edit </a>
        </div>
        <div class="text-center mt-4">
            <form method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus postingan ini?');">
                <input type="hidden" name="delete_offer_id" value="<?php echo (int)$penawaran['id']; ?>">
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    <?php endforeach;?>

</div>

<div class="container mt-3">
    <h1 class="text-center"> Permintaan Donasi Baru</h1>
    <?php foreach($postPermintaan as $permintaan):?>
        <a href="detail_perminataan.php?id=<?php echo (int)$permintaan['id']?>" class="text-decoration-none">
            <div class="card mb-3">
                <img src="<?php echo $permintaan['foto']?>" class="card-img-top" alt="Post Image">
                <div class="card-body">
                    <h5 class="card-title"> <?php echo $permintaan['judul']?></h5>
                    <p class="card-text"><small class="text-body-secondary">Requested by : <?php echo $permintaan['organisasi']?></small></p>
                    <p class="card-text"><small class="text-body-secondary">Created at : <?php echo $permintaan['dibuat_pada']?></small></p>
                </div>
            </div>
        </a>
        <div class="text-center mt-4">
            <a href="edit_permintaan.php?id=<?php echo (int)$permintaan['id']?>" class="btn btn-success"> Edit </a>
        </div>
        <div class="text-center mt-4">
            <form method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus postingan ini?');">
                <input type="hidden" name="delete_request_id" value="<?php echo (int)$permintaan['id']; ?>">
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    <?php endforeach;?>
</div>
</body>
</html>
