<?php
session_start();
require_once "../Service/PhotoService.php";
require_once "../Service/OfferPostService.php";
require_once "../Service/UserService.php";
require_once "../Service/ClothesService.php";
$photoService = new PhotoService();
$offerPostService = new OfferPostService();
$userService = new UserService();
$clothesService = new ClothesService();
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!isset($_SESSION['nik'])) {
            throw new Exception("Anda belum login. Silakan login terlebih dahulu.");
        }
        $judul = trim($_POST["judul"]);
        $deskripsi = trim($_POST["deskripsi"]);
        $nik = $_SESSION['nik'];
        $alamat = $userService->getUserAddressByNik($nik);
        if (!isset($_FILES["file"]) || $_FILES["file"]["error"] != UPLOAD_ERR_OK) {
            throw new Exception("Gagal mengupload foto. Silakan coba lagi.");
        }
        $file = $photoService->upload($_FILES["file"], 'penawaran');
        if ($file === null) {
            throw new Exception("Gagal menyimpan foto. Silakan coba lagi.");
        }
        $jenis = $_POST["jenis"] ?? [];
        $ukuran = $_POST["ukuran"] ?? [];
        $jumlah = $_POST["jumlah"] ?? [];
        if (empty($jenis) || empty($ukuran) || empty($jumlah)) {
            throw new Exception("Data baju tidak lengkap. Harap isi semua kolom.");
        }
        $offering_id = $offerPostService->createOfferingPost($judul, $deskripsi, $alamat, $file, $nik);
        if ($offering_id === null) {
            throw new Exception("Gagal membuat postingan. Silakan coba lagi.");
        }
        if (!$clothesService->insertAllClothes($offering_id, $jenis, $ukuran, $jumlah)) {
            throw new Exception("Gagal memasukkan daftar pakaian. Silakan coba lagi.");
        }
        header("Location: home.php");
        exit;
    }
}catch (Exception $e){
        $error = $e->getMessage();
}?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Penawaran Donasi</title>
    <link href="/bootstrap/css/bootstrap.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5 col-md-12">
    <h2 class="text-center">Buat Postingan Penawaran Baju</h2>
    <form method="POST" id="offerForm" class="col-md-12" enctype="multipart/form-data">
        <?php if(isset($error)):?>
            <div class="alert alert-danger mt-3 text-center col-md-12"><?php echo $error?></div>
        <?php endif;?>
        <div class="mt-3">
            <label for="judul" class="form-label">Judul Penawaran</label>
            <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan judul penawaran" required>
        </div>
        <div class="mt-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" placeholder="Masukkan deskripsi penawaran"></textarea>
        </div>
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
            <button type="submit" class="btn btn-primary md-3">Kirim Penawaran</button>
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
