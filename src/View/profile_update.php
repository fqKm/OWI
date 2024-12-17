<?php
session_start();
require_once "../Service/UserService.php";
require_once "../Service/AddressService.php";
$nik = $_SESSION['nik']; 
$addressService = new AddressService();
$userService = new UserService();


// Cek session login
if (!isset($_SESSION['nik'])) {
    header("Location: login.php");
    exit();
}

$data = $userService->getUserInfoByNik($_SESSION['nik']);

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Ambil data dari form POST
        $nik = $_POST['nik'];
        $nama_depan = trim($_POST['nama_depan']);
        $nama_belakang = trim($_POST['nama_belakang']);
        $email = trim($_POST['email']);
        $nomor_telepon = trim($_POST['nomor_telepon']);
        $organisasi = trim($_POST['organisasi'] ?? '');
        $rt = trim($_POST['rt']);
        $rw = trim($_POST['rw']);
        $jalan = trim($_POST['jalan']);
        $dusun = trim($_POST['dusun']);
        $desa = trim($_POST['desa']);
        $kecamatan = trim($_POST['kecamatan']);
        $kota = trim($_POST['kota']);
        $kode_pos = trim($_POST['kode_pos']);
        $id_alamat = $_POST['id_alamat'];

        // Validasi input kosong
        if (empty($nama_depan) || empty($nama_belakang) || empty($email)) {
            throw new Exception("Kolom First Name, Last Name, dan Email tidak boleh kosong.");
        }

        // Update data user
        $successUpdateInfo = $userService->updateUserInfo($nik, $nama_depan, $nama_belakang, $email, $nomor_telepon, $organisasi);

        // Update alamat
        $successUpdateAlamat = $addressService->updateAddressById($id_alamat, $rt, $rw, $jalan, $dusun, $desa, $kecamatan, $kota, $kode_pos);

        if ($successUpdateInfo && $successUpdateAlamat) {
            $success = "Profil berhasil diperbarui.";
            // Refresh data
            $data = $userService->getUserInfoByNik($_SESSION['nik']);
        } else {
            throw new Exception("Gagal memperbarui profil. Silakan coba lagi.");
        }
    }
} catch (Exception $e) {
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
</head>
<body>
<form method="POST" class="card shadow mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <div class="text-center mb-4">
                <img src="https://i.imgur.com/xO14F5q.png" alt="Profile Image" class="rounded-circle img-fluid" style="width: 150px; height: 150px;">
            </div>

            <div class="mb-3">
                <label for="nik" class="form-label fw-bold text-uppercase text-muted">NIK</label>
                <input type="text" id="nik" name="nik" class="form-control" value="<?php echo htmlspecialchars($data['nik']); ?>" readonly>
                <input type="hidden" name="nik" value="<?php echo htmlspecialchars($data['nik']); ?>">
            </div>

            <div class="mb-3">
                <label for="nama_depan" class="form-label fw-bold text-uppercase text-muted">First Name</label>
                <input type="text" id="nama_depan" name="nama_depan" class="form-control" value="<?php echo htmlspecialchars($data['nama_depan']); ?>">
            </div>

            <div class="mb-3">
                <label for="nama_belakang" class="form-label fw-bold text-uppercase text-muted">Last Name</label>
                <input type="text" id="nama_belakang" name="nama_belakang" class="form-control" value="<?php echo htmlspecialchars($data['nama_belakang']); ?>">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-bold text-uppercase text-muted">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($data['email']); ?>">
            </div>

            <div class="mb-3">
                <label for="nomor_telepon" class="form-label fw-bold text-uppercase text-muted">Nomor Telepon</label>
                <input type="text" id="nomor_telepon" name="nomor_telepon" class="form-control" value="<?php echo htmlspecialchars($data['nomor_telepon']); ?>">
            </div>

            <div class="mb-3">
                <label for="organisasi" class="form-label fw-bold text-uppercase text-muted">Organisasi</label>
                <input type="text" id="organisasi" name="organisasi" class="form-control" value="<?php echo !empty($data['organisasi']) ? htmlspecialchars($data['organisasi']) : ''; ?>">
            </div>

            <!-- Address Section -->
            <div class="mb-3">
                <label for="rt" class="form-label fw-bold text-uppercase text-muted">RT</label>
                <input type="text" id="rt" name="rt" class="form-control" value="<?php echo htmlspecialchars($data['rt']); ?>">
            </div>

            <div class="mb-3">
                <label for="rw" class="form-label fw-bold text-uppercase text-muted">RW</label>
                <input type="text" id="rw" name="rw" class="form-control" value="<?php echo htmlspecialchars($data['rw']); ?>">
            </div>

            <div class="mb-3">
                <label for="jalan" class="form-label fw-bold text-uppercase text-muted">Jalan</label>
                <input type="text" id="jalan" name="jalan" class="form-control" value="<?php echo htmlspecialchars($data['jalan']); ?>">
            </div>

            <div class="mb-3">
                <label for="dusun" class="form-label fw-bold text-uppercase text-muted">Dusun</label>
                <input type="text" id="dusun" name="dusun" class="form-control" value="<?php echo htmlspecialchars($data['dusun']); ?>">
            </div>

            <div class="mb-3">
                <label for="desa" class="form-label fw-bold text-uppercase text-muted">Desa</label>
                <input type="text" id="desa" name="desa" class="form-control" value="<?php echo htmlspecialchars($data['desa']); ?>">
            </div>

            <div class="mb-3">
                <label for="kecamatan" class="form-label fw-bold text-uppercase text-muted">Kecamatan</label>
                <input type="text" id="kecamatan" name="kecamatan" class="form-control" value="<?php echo htmlspecialchars($data['kecamatan']); ?>">
            </div>

            <div class="mb-3">
                <label for="kota" class="form-label fw-bold text-uppercase text-muted">Kota</label>
                <input type="text" id="kota" name="kota" class="form-control" value="<?php echo htmlspecialchars($data['kota']); ?>">
            </div>

            <div class="mb-3">
                <label for="kode_pos" class="form-label fw-bold text-uppercase text-muted">Kode Pos</label>
                <input type="number" id="kode_pos" name="kode_pos" class="form-control" value="<?php echo htmlspecialchars($data['kode_pos']); ?>">
            </div>

            <!-- Hidden ID for alamat -->
            <input type="hidden" name="id_alamat" value="<?php echo htmlspecialchars($data['id_alamat']); ?>">

            <div class="text-center">
                <button type="submit" name="submit" class="btn btn-primary">Save Changes</button>
                <a href="profile.php" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>   
</body>
</html>