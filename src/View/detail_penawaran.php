<?php
require_once "../Service/OfferPostService.php";
require_once "../Service/AddressService.php";
require_once "../Service/UserService.php";
require_once "../Service/ClothesService.php";
require_once "../Service/TransactionService.php";

$offerService = new OfferPostService();
$clothesService = new ClothesService();
$userService = new UserService();
$addressService = new AddressService();
$transactionServive = new TransactionService();
$detail_post_penawaran = $offerService->getOfferPostDetailsById((int)$_GET["id"]);
$detail_user = $userService->getUserByNik($detail_post_penawaran["nik_pembuat"]);
$detail_alamat = $addressService->getAddressById($detail_post_penawaran["id_alamat"]);
$detail_pakaian = $clothesService->getAllClothes((int)$_GET["id"]);
$alamat = "RT/RW : ".$detail_alamat['rt']."/ ".$detail_alamat['rw'].", ".$detail_alamat['dusun'].", ".$detail_alamat['desa'].", ".$detail_alamat['kecamatan'].", ".$detail_alamat['kota'].", ".$detail_alamat['kode_pos'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Cek apakah session dan variabel yang diperlukan tersedia
    if (!isset($_SESSION['nik'])) {
            
        // Ambil data dari session dan variabel
        $nik_penerima = $userService->getNikBySession();
        $id_post = $detail_post_penawaran['id'];
        $nik_donatur = $detail_post_penawaran['nik_pembuat'];
        $alamat = $userService->getUserAddressByNik($nik_penerima);
        $no_resi = str_pad(rand(1000000000000000, 9999999999999999), 16, "0", STR_PAD_LEFT);
        $tipe_transaksi = "penerimaan";
    
        // Eksekusi transaksi
        $transaksi = $transactionServive->createTransaction($id_post, $nik_penerima, $nik_donatur, $no_resi, $tipe_transaksi);
    
        if ($transaksi === null) {
            die("Gagal menginput pakaian. Silakan coba lagi.");
        }
    
        // Redirect ke halaman riwayat transaksi
        header("Location: riwayat_transaksi.php");
        exit;
        } else {
        die("Data tidak lengkap. Pastikan semua session dan variabel tersedia.");
    }
} 
?>
<html>
<head>
    <title> DETAIL <?php echo $detail_post_penawaran['judul']?></title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
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
            <a href="profile2.php?nik_user=<?php echo (Int)$detail_post_penawaran['nik_pembuat']?>" class="card-text"> <?php echo  $detail_user['nama_depan']." ".$detail_user['nama_belakang']?></a>
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
    <!-- Form untuk mengirim transaksi -->
    <form method="POST">
        <div class="col-md-12 text-center mt-3">
            <button type="submit" class="btn btn-primary col-md-6">Terima Penawaran Baju</button>
        </div>
    </form>
    </div>
</div>
</body>
</html>