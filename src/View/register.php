<?php
require "../Service/UserService.php";
$userService = new UserService();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Proses data POST
    $nik = $_POST["NIK"] ?? null;
    $email = $_POST['Email'] ?? null;
    $password = $_POST["Password"] ?? null;
    $nama_depan = $_POST["Nama Depan"] ?? null;
    $nama_belakang = $_POST["Nama Belakang"] ?? '';
    $nomor_telepon = $_POST["Nomor Telephone"] ?? null;
    $rt = $_POST["RT"] ?? '';
    $rw = $_POST["RW"] ?? '';
    $jalan = $_POST["Jalan"] ?? '';
    $dusun = $_POST["Dusun"] ?? '';
    $desa = $_POST["Desa"] ?? '';
    $kecamatan = $_POST["Kecamatan"] ?? '';
    $kota = $_POST["Kota"] ?? '';
} else {
    $nik = $email = $password = $nama_depan = $nama_belakang = $nomor_telepon = $rt = $rw = $jalan = $dusun = $desa = $kecamatan = $kota = '';
}


$result = $userService->registerService($nik,$nama_depan,$nama_belakang, $email, $password, $nomor_telepon, $rt, $rw, $jalan, $dusun, $desa,$kecamatan,$kota);
if($result){
    session_start();
    $_SESSION['nik'] = $nik;
    header("Location: home.php");
    exit();
} else {
    $error = "Gagal Register, Tolong Ulangi Kembali";
}
?>
<html>
<head>
<title>Regitser</title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-center">
        <h1 style="color: #C6E385" >Register</h1>
    </div>
    <?php if(isset($error)):?>
        <div class="alert alert-danger mt-3 text-center"><?php echo $error?></div>
    <?php endif;?>
    <div class="row justify-content-center mt-3">
        <form class="row g-3" method="POST">
            <div class="col-md-12">
                <label for="NIK" class="form-label">NIK</label>
                <input type="number" class="form-control" name="NIK">
            </div>
            <div class="col-md-12">
                <label for="Email" class="form-label">Email</label>
                <input type="email" class="form-control" name="Email">
            </div>
            <div class="col-md-12">
                <label for="Password" class="form-label">Password</label>
                <input type="password" class="form-control" name="Password">
            </div>
            <div class="col-md-6">
                <label for="Nama Depan" class="form-label">Nama</label>
                <input type="text" class="form-control" name="Nama Depan">
            </div>
            <div class="col-md-6">
                <label for="Nama Belakang" class="form-label">Nama Belakang</label>
                <input type="text" class="form-control" name="Nama Belakang">
            </div>
            <div class="col-md-12">
                <label for="Nomor Telephone" class="form-label">Nomor Telephone</label>
                <input type="text" class="form-control" name="Nomor Telephone">
            </div>
            <div class="col-12">
                <label for="Jalan" class="form-label">Address</label>
                <input type="text" class="form-control" name="Jalan" placeholder="1234 Main St">
            </div>
            <div class="col-md-6">
                <label for="RT" class="form-label">RT</label>
                <input type="text" class="form-control" name="RT">
            </div>
            <div class="col-md-6">
                <label for="RW" class="form-label">RW</label>
                <input type="text" class="form-control" name="RW">
            </div>
            <div class="col-md-6">
                <label for="Desa" class="form-label">Desa</label>
                <input type="text" class="form-control" name="Desa">
            </div>
            <div class="col-md-6">
                <label for="Kecamatan" class="form-label">Kecamatan</label>
                <input type="text" class="form-control" name="kecamatan">
            </div>
            <div class="col-md-6">
                <label for="Kota" class="form-label">Kabupaten/Kota</label>
                <input type="text" class="form-control" name="Kota">
            </div>
            <div class="col-md-6">
                <label for="Provinsi" class="form-label">Provinsi</label>
                <input type="text" class="form-control" id="Provinsi">
            </div>
            <a href="login.php" class="mt-3 col-md-6 text-center"> I Already Has An Account</a>
            <div class="col-md-6 mt-3">
                <button type="submit" class="btn btn-primary w-100">SignUp</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
