<?php
require_once "../Service/RequestPostService.php";
require_once "../Service/UserService.php";
require_once "../Service/AddressService.php";

$requestService = new RequestPostService();
$userService = new UserService();
$addressService = new AddressService();
$detail_post_permintaan = $requestService->getRequestPostDetailsById((int)$_GET["id"]);
$detail_user = $userService->getUserByNik($detail_post_permintaan["nik_pembuat"]);
$detail_alamat = $addressService->getAddressById($detail_post_permintaan["id_alamat"]);;
$alamat = "RT/RW : ".$detail_alamat['rt']."/ ".$detail_alamat['rw'].", ".$detail_alamat['dusun'].", ".$detail_alamat['desa'].", ".$detail_alamat['kecamatan'].", ".$detail_alamat['kota'].", ".$detail_alamat['kode_pos'];
$postPermintaan = $requestService->getRequestPostDetailsById((int)$_GET["id"]);
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
            <a href="profile.php?id=<?php echo $detail_user['nik']?>" class="card-text"> <?php echo  $detail_user['nama_depan']." ".$detail_user['nama_belakang']?></a>
            <p class="card-text"><?php echo $detail_post_permintaan['deskripsi']?>.</p>
            <h5> Alamat :</h5>
            <p class="card-text">Jalan : <?php echo  $detail_alamat['jalan'] ?></p>
            <p class="card-text"> <?php echo $alamat?> </p>
        </div>
        <div class="card-footer text-muted">
            <?php echo $detail_post_permintaan['dibuat_pada']?>
        </div>
    </div>
    <div class="text-center mt-4">
        <a href="transaksi_donasi.php?id_posting=<?php echo (Int)$postPermintaan['id']; ?>&nik_penerima=<?php echo (Int)$postPermintaan['nik_pembuat'];?>" class="btn btn-primary">
            Donasikan baju anda
        </a>
    </div>
</div>
</body>
</html>