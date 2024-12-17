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
$penawaran = $offerPostService->getOfferPostDetailsById($_GET["id"]);
$pakaian = $clothesService->getAllClothes($_GET["id"]);
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!isset($_SESSION['nik'])) {
            throw new Exception("Anda belum login. Silakan login terlebih dahulu.");
        }
        $judul = trim($_POST["judul"]);
        $deskripsi = trim($_POST["deskripsi"]);
        $nik = $_SESSION['nik'];
        $alamat = $userService->getUserAddressByNik($nik);
        $foto = $_FILES["file"] ?? null;
        if ($foto && $_FILES["file"]["error"] == UPLOAD_ERR_OK) {
            $file = $photoService->upload($foto, 'penawaran');
            if ($file === null) {
                throw new Exception("Gagal menyimpan foto. Silakan coba lagi.");
            }
        } else {
            $file = $penawaran["foto"];
        }
        $id_pakaian = $_POST["id"] ?? [];
        $jenis = $_POST["jenis"] ?? [];
        $ukuran = $_POST["ukuran"] ?? [];
        $jumlah = $_POST["jumlah"] ?? [];
        if (empty($jenis) || empty($ukuran) || empty($jumlah)) {
            throw new Exception("Data baju tidak lengkap. Harap isi semua kolom.");
        }
        $successUpdatePost =$offerPostService->updateOfferingPost($penawaran['id'], $judul, $deskripsi, $alamat, $file);
        if (!$successUpdatePost) {
            throw new Exception("Gagal memperbarui postingan. Silakan coba lagi.");
        }
        $successUpdateClothes = $clothesService->updateClothes($penawaran['id'], $id_pakaian, $jenis, $ukuran, $jumlah);
        if (!$successUpdatePost) {
            throw new Exception("Gagal memperbarui daftar pakaian. Silakan coba lagi.");
        }
        header("Location: home.php");
        exit;
    }
} catch (Exception $e) {
    $error = $e->getMessage();
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Penawaran Donasi</title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
</head>
<body>
<?php include "navbar.php" ?>
<div class="container mt-5 col-md-12">
    <h2 class="text-center">Edit Postingan Penawaran Baju</h2>
    <form method="POST" id="offerForm" class="col-md-12" enctype="multipart/form-data">
        <?php if(isset($error)):?>
            <div class="alert alert-danger mt-3 text-center col-md-12"><?php echo $error?></div>
        <?php endif;?>
        <div class="mt-3">
            <label for="judul" class="form-label">Judul Penawaran</label>
            <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan judul penawaran" value="<?php echo $penawaran['judul']; ?>" required>
        </div>
        <div class="mt-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" placeholder="Masukkan deskripsi penawaran"><?php echo $penawaran['deskripsi'];?></textarea>
        </div>
        <div class="mt-3">
            <label for="file" class="form-label"> Foto </label>
            <input class="form-control-file" type="file" id="file" name="file">
        </div>
        <div id="clothesList" class="mt-5">
            <h5>Daftar Baju</h5>
            <?php foreach ($pakaian as $clothes): ?>
                <div class="clothes-item mb-3">
                    <div class="row g-3">
                        <div class="col-md-1">
                            <input type="number" class="form-control" name="id[]" value="<?php echo $clothes['id'];?>" readonly>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="jenis[]" value="<?php echo $clothes['jenis']; ?>" placeholder="Jenis Baju" required>
                        </div>
                        <div class="col-md-3">
                            <select class="custom-select my-1 mr-sm-2" name="ukuran[]">
                                <option value="XS" <?php echo ($clothes['ukuran'] == 'XS') ? 'selected' : ''; ?>>XS</option>
                                <option value="S" <?php echo ($clothes['ukuran'] == 'S') ? 'selected' : ''; ?>>S</option>
                                <option value="M" <?php echo ($clothes['ukuran'] == 'M') ? 'selected' : ''; ?>>M</option>
                                <option value="L" <?php echo ($clothes['ukuran'] == 'L') ? 'selected' : ''; ?>>L</option>
                                <option value="XL" <?php echo ($clothes['ukuran'] == 'XL') ? 'selected' : ''; ?>>XL</option>
                                <option value="XXL" <?php echo ($clothes['ukuran'] == 'XXL') ? 'selected' : ''; ?>>XXL</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="number" class="form-control" name="jumlah[]" value="<?php echo $clothes['jumlah']; ?>" placeholder="Jumlah Baju" required>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="d-flex justify-content-around mt-3">
            <button type="submit" class="btn btn-primary md-3">Update Penawaran</button>
        </div>
    </form>
</div>

<script src="/bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>
