<?php
session_start();
require_once "../Service/PhotoService.php";
require_once "../Service/RequestPostService.php";
require_once "../Service/UserService.php";
$photoService = new PhotoService();
$requestPostService = new RequestPostService();
$userService = new UserService();
$organisasi = $userService->getUserOrganisationByNik($_SESSION['nik']);
$permintaan = $requestPostService->getRequestPostDetailsById($_GET["id"]);
try {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!isset($_SESSION['nik'])) {
            throw new Exception("Anda belum login. Silakan login terlebih dahulu.");
        }
        $nik = $_SESSION['nik'];
        $alamat = $userService->getUserAddressByNik($nik);
        $judul = trim($_POST["judul"] ?? '');
        $deskripsi = trim($_POST["deskripsi"] ?? '');
        if (empty($judul) || empty($deskripsi)) {
            throw new Exception("Harap lengkapi semua kolom input.");
        }
        $foto = $_FILES["file"] ?? null;
        if ($foto && $_FILES["file"]["error"] == UPLOAD_ERR_OK) {
            $file = $photoService->upload($foto, 'permintaan');
            if ($file === null) {
                throw new Exception("Gagal menyimpan foto. Silakan coba lagi.");
            }
        } else {
            $file = $permintaan["foto"];
        }
        $successUpdateRequest = $requestPostService->updateRequestPost($judul, $deskripsi, $file, $permintaan['id']);
        if (!$successUpdateRequest) {
            throw new Exception("Gagal membuat postingan. Silakan coba lagi. Harap Lengkapi Organisasi Anda");
        }
        header("Location: home.php");
        exit;
    }
} catch (Exception $e) {
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
<div class="row justify-content-center mt-3">
    <h2 class="text-center">Buat Postingan Penawaran Baju</h2>
    <form method="POST" id="offerForm" class="row g-3" enctype="multipart/form-data">
        <?php if(isset($error)):?>
            <div class="alert alert-danger mt-3 text-center col-md-12"><?php echo $error?></div>
        <?php endif;?>
        <div class="col-md-12 mt-3">
            <label for="judul" class="form-label">Judul Permintaan</label>
            <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan judul permintaan" value="<?php echo $permintaan['judul']?>" required>
        </div>
        <div class="col-md-12 mt-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" placeholder="Masukkan deskripsi permintaan"><?php echo $permintaan['deskripsi']?></textarea>
        </div>
        <div class="col-md-12 mt-3">
            <label for="file" class="form-label"> Foto </label>
            <input class="form-control-file" type="file" id="file" name="file">
        </div>
        <div class="col-md-9 mt-3">
            <label for="organisasi" class="form-label"> Organisasi</label>
            <input class="form-control col-md-6" type="text" placeholder="<?php if(empty($organisasi)){
                echo "Lengkapi Organisasi Anda";
            }else{
                echo $organisasi['organisasi'];
            }?>" name="organisasi" readonly>
        </div>
        <div class="col-md-3 mt-3">
            <a class="btn btn-primary md-5 mt-4" href="profile.php?id=" role="button">Lengkapi Organisasi</a>
        </div>
        <div class="col-md-12 text-center mt-3">
            <button type="submit" class="btn btn-success md-6">Kirim Permintaan</button>
        </div>
    </form>
</div>
<script src="/bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>