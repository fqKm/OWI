<?php
session_start();
require_once "../Service/PhotoService.php";
require_once "../Service/UserService.php";
require_once "../Service/ClothesService.php";
require_once "../Service/TransactionService.php";
require_once "../Service/RequestPostService.php";

$photoService = new PhotoService();
$userService = new UserService();
$clothesService = new ClothesService();
$transactionServive = new TransactionService();
$requestPostService = new RequestPostService();
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!isset($_SESSION['nik'])) {
            throw new Exception("Anda belum login. Silakan login terlebih dahulu.");
        }
        $nik_donatur = $_SESSION['nik'];
        $id_post = $_GET["id_posting"];
        $nik_penerima = $_GET["nik_penerima"];
        $alamat = $userService->getUserAddressByNik($nik_donatur);
        $no_resi = str_pad(rand(1000000000000000, 9999999999999999), 16, "0", STR_PAD_LEFT);
        $tipe_transaksi = "permintaan";
        if (!isset($_FILES["file"]) || $_FILES["file"]["error"] != UPLOAD_ERR_OK) {
            throw new Exception("Gagal mengupload foto. Silakan coba lagi.");
        }
        $file = $photoService->upload($_FILES["file"], 'donasi');
        if ($file === null) {
            throw new Exception("Gagal menyimpan foto. Silakan coba lagi.");
        }
        $jenis = $_POST["jenis"] ?? [];
        $ukuran = $_POST["ukuran"] ?? [];
        $jumlah = $_POST["jumlah"] ?? [];
        $transaksi = $transactionServive->createTransaction($id_post, $nik_penerima, $nik_donatur, $no_resi, $tipe_transaksi);
        if ($transaksi === null) {
            throw new Exception("Gagal membuat postingan. Silakan coba lagi.");
        }
        if (!$transactionServive->createTransaction($id_post, $nik_penerima, $nik_donatur, $no_resi, $tipe_transaksi)) {
            throw new Exception("Gagal memasukkan daftar pakaian. Silakan coba lagi.");
        }
        header("Location: riwayat_transaksi.php");
        exit;
    }
}catch (Exception $e){
        $error = $e->getMessage();
}?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Penawaran Donasi</title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
</head>
<body>
<?php include "navbar.php" ?>
<div class="container mt-5 col-md-12">
    <h2 class="text-center">Masukkan Baju yang ingin didonasikan</h2>
    <form method="POST" id="offerForm" class="col-md-12" enctype="multipart/form-data">
        <?php if(isset($error)):?>
            <div class="alert alert-danger mt-3 text-center col-md-12"><?php echo $error?></div>
        <?php endif;?>
        <div class="mt-3">
            <label for="file" class="form-label"> Foto </label>
            <input class="form-control-file" type="file" id="file" name="file">
        </div>
        <div id="clothesList" class="mt-5">
            <h5>Daftar Baju</h5>
            <div class="clothes-item mb-3">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="jenis[]" placeholder="Jenis Baju" required>
                    </div>
                    <div class="col-md-3">
                        <select class="custom-select my-1 mr-sm-2" name="ukuran[]">
                            <option selected>Ukuran</option>
                            <option value="XS">XS</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                            <option value="XXL">XXL</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" class="form-control" name="jumlah[]" placeholder="Jumlah Baju" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-item">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-around mt-3">
            <button type="button" class="btn btn-success md-3" id="addClothes">Tambah Baju</button>
            <button type="submit" class="btn btn-primary md-3">Input Donasi</button>
        </div>
    </form>
</div>
<script src="/bootstrap/js/bootstrap.bundle.js"></script>
<script>
    document.getElementById('addClothes').addEventListener('click', function () {
        const clothesList = document.getElementById('clothesList');
        const newClothes = `
            <div class="clothes-item mb-3">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="jenis[]" placeholder="Jenis Baju" required>
                    </div>
                    <div class="col-md-3">
                        <select class="custom-select my-1 mr-sm-2" id="ukuran[]">
                            <option selected>Ukuran</option>
                            <option value="XS">XS</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                            <option value="XXL">XXL</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" class="form-control" name="jumlah[]" placeholder="Jumlah Baju" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-item">Hapus</button>
                    </div>
                </div>
            </div>
    `;
        clothesList.insertAdjacentHTML('beforeend', newClothes);
        attachRemoveEvents();
    });
    function attachRemoveEvents() {
        const removeButtons = document.querySelectorAll('.remove-item');
        removeButtons.forEach(button => {
            button.addEventListener('click', function () {
                button.closest('.clothes-item').remove();
            });
        });
    }
    attachRemoveEvents();
</script>
</body>
</html>
