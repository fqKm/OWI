<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <title>Profile</title>
</head>
<body>
<?php include 'header.php'; ?>
<div class="container mt-5">
    <?php
    require 'koneksi.php';
    $NIK = 123;
    // Using prepared statement for security
    $stmt = $conn->prepare("SELECT * FROM user LEFT JOIN alamat ON user.id_alamat = alamat.id WHERE user.nik = ?");
    $stmt->bind_param("i", $NIK);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if (!$data) {
        echo "<div class='alert alert-danger'>User not found</div>";
        exit;
    }
    ?>
    <form action="updateprofile.php" method="POST" class="card shadow mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <div class="text-center mb-4">
                <img src="https://i.imgur.com/xO14F5q.png" alt="Profile Image" class="rounded-circle img-fluid" style="width: 150px; height: 150px;">
            </div>

            <div class="mb-3">
                <label for="nik" class="form-label fw-bold text-uppercase text-muted">NIK</label>
                <input type="text" id="nik" name="nik" class="form-control" value="<?php echo htmlspecialchars($data['nik']); ?>" readonly>
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

            <!-- Hidden ID for alamat -->
            <input type="hidden" name="id_alamat" value="<?php echo htmlspecialchars($data['id_alamat']); ?>">

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="profile.php" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>
</body>

<?php
if (isset($_POST["submit"])) {
    $nama_depan = $_POST["nama_depan"];
    $nama_belakang = $_POST["nama_belakang"];
    $email = $_POST["email"];
    $nomor_telepon = $_POST["nomor_telepon"];
    $organisasi = $_POST["organisasi"];
    $rt = $_POST["rt"];
    $rw = $_POST["rw"];
    $jalan = $_POST["jalan"];
    $dusun = $_POST["dusun"];
    $desa = $_POST["desa"];
    $kecamatan = $_POST["kecamatan"];
    $kota = $_POST["kota"];
    $id_alamat = $_POST["id_alamat"];
    $query = '';
}
?>
</html>
