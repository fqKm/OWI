<?php
require_once "../Service/RequestPostService.php";
require_once "../Service/UserService.php";
require_once "../Service/AddressService.php";

$requestService = new RequestPostService();
$userService = new UserService();
$addressService = new AddressService();
$detail_post_permintaan = $requestService->getRequestPostDetailsById((int)$_GET["id"]);
$alamat = "RT/RW : ".$detail_post_permintaan['rt']."/ ".$detail_post_permintaan['rw'].", ".$detail_post_permintaan['dusun'].", ".$detail_post_permintaan['desa'].", ".$detail_post_permintaan['kecamatan'].", ".$detail_post_permintaan['kota'].", ".$detail_post_permintaan['kode_pos'];
?>

<html>
<head>
    <title> DETAIL <?php echo $detail_post_permintaan['judul']?></title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
</head>
<body>
<?php include "navbar.php" ?>
<div class="container mt-5">
    <div class="text-center mt-5">
        <h1>Detail Penawaran</h1>
    </div>
    <div class="card mb-3">
        <img class="card-img-top" src="<?php echo $detail_post_permintaan['foto']?>" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title"><?php echo $detail_post_permintaan['judul'] ?></h5>
            <h5><?php echo $detail_post_permintaan['organisasi']?></h5>
            <a href="profile.php?id=<?php echo $detail_post_permintaan['nik']?>" class="card-text"> <?php echo  $detail_post_permintaan['nama_depan']." ".$detail_post_permintaan['nama_belakang']?></a>
            <p class="card-text"><?php echo $detail_post_permintaan['deskripsi']?>.</p>
            <h5> Alamat :</h5>
            <p class="card-text">Jalan : <?php echo  $detail_post_permintaan['jalan'] ?></p>
            <p class="card-text"> <?php echo $alamat?> </p>
        </div>
        <div class="card-footer text-muted">
            <?php echo $detail_post_permintaan['dibuat_pada']?>
        </div>
    </div>
    <div class="text-center mt-4">
        <a href="transaksi_donasi.php?id_posting=<?php echo (Int)$detail_post_permintaan['id']; ?>&nik_penerima=<?php echo (Int)$detail_post_permintaan['nik'];?>" class="btn btn-primary">
            Donasikan baju anda
        </a>
    </div>
</div>
</body>
</html>