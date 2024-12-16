<?php
require_once "../Service/OfferPostService.php";
require_once "../Service/AddressService.php";
require_once "../Service/UserService.php";
require_once "../Service/ClothesService.php";

$offerService = new OfferPostService();
$clothesService = new ClothesService();
$userService = new UserService();
$addressService = new AddressService();
$detail_post_penawaran = $offerService->getOfferPostDetailsById((int)$_GET["id"]);
$detail_user = $userService->getUserByNik($detail_post_penawaran["nik_pembuat"]);
$detail_alamat = $addressService->getAddressById($detail_post_penawaran["id_alamat"]);
$detail_pakaian = $clothesService->getAllClothes((int)$_GET["id"]);
$alamat = "RT/RW : ".$detail_alamat['rt']."/ ".$detail_alamat['rw'].", ".$detail_alamat['dusun'].", ".$detail_alamat['desa'].", ".$detail_alamat['kecamatan'].", ".$detail_alamat['kota'].", ".$detail_alamat['kode_pos'];
?>
<html>
<head>
    <title> DETAIL <?php echo $detail_post_penawaran['judul']?></title>
    <link href="/bootstrap/css/bootstrap.css" rel="stylesheet">
</head>
<body>
<?php include "navbar.php" ?>
<div class="container mt-5">
    <div class="text-center mt-5">
        <h1>Detail Penawaran</h1>
    </div>
    <div class="card mb-3">
        <img class="card-img-top size" src="<?php echo $detail_post_penawaran['foto']?>" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title"><?php echo $detail_post_penawaran['judul'] ?></h5>
            <a href="profile.php?id=<?php echo $detail_user['nik']?>" class="card-text"> <?php echo  $detail_user['nama_depan']." ".$detail_user['nama_belakang']?></a>
            <p class="card-text"><?php echo $detail_post_penawaran['deskripsi']?>.</p>
            <h5> Alamat :</h5>
            <p class="card-text">Jalan : <?php echo  $detail_alamat['jalan'] ?></p>
            <p class="card-text"> <?php echo $alamat?> </p>
        </div>
        <div class="card-footer text-muted">
            <?php echo $detail_post_penawaran['dibuat_pada']?>
        </div>
    </div>
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col"> Id </th>
            <th scope="col"> Jenis Pakaian </th>
            <th scope="col"> Ukuran </th>
            <th scope="col"> Jumlah </th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        foreach($detail_pakaian as $pakaian):?>
            <tr>
                <th scope="row"><?php echo $i ?></th>
                <th scope="row"> <?php echo $pakaian['jenis']?></th>
                <th scope="row"> <?php echo $pakaian['ukuran']?></th>
                <th scope="row"> <?php echo $pakaian['jumlah']?></th>
            </tr>
            <?php $i++;
        endforeach;?>
        </tbody>
    </table>
</div>
</body>
</html>