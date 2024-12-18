<?php
session_start();
require_once "../Service/UserService.php";

$nik = $_GET['nik_user']; 
$userService = new UserService();
$data= $userService->getUserInfoByNik($nik);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
</head>
<body>
<?php include "navbar.php" ?>
<div class="card shadow mx-auto" style="max-width: 600px;">
        <div class="card-body text-center">
            <img src="mai.png" alt="Profile Image" class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px;">
            <h3 class="card-title">
                <?php echo htmlspecialchars($data['nama_depan'] . " " . $data['nama_belakang']); ?>
            </h3>
            <p class="text-muted">
                <?php
                $address = array_filter([
                    "RT " . htmlspecialchars($data['rt']),
                    "RW " . htmlspecialchars($data['rw']),
                    "Jl. " . htmlspecialchars($data['jalan']),
                    "Dusun " . htmlspecialchars($data['dusun']),
                    "Desa " . htmlspecialchars($data['desa']),
                    "Kecamatan " . htmlspecialchars($data['kecamatan']),
                    "Kota " . htmlspecialchars($data['kota']),
                    htmlspecialchars($data['kode_pos'])
                ]);
                echo implode(", ", $address);
                ?>
            </p>
        </div>
    </div>

    <div class="card shadow mx-auto mt-4" style="max-width: 500px;">
        <div class="card-body">
            <div class="mb-3">
                <span class="fw-bold text-uppercase text-muted">NIK</span>
                <p><?php echo htmlspecialchars($data['nik']); ?></p>
            </div>
            <div class="mb-3">
                <span class="fw-bold text-uppercase text-muted">First Name</span>
                <p><?php echo htmlspecialchars($data['nama_depan']); ?></p>
            </div>
            <div class="mb-3">
                <span class="fw-bold text-uppercase text-muted">Last Name</span>
                <p><?php echo htmlspecialchars($data['nama_belakang']); ?></p>
            </div>
            <div class="mb-3">
                <span class="fw-bold text-uppercase text-muted">Email</span>
                <p><?php echo htmlspecialchars($data['email']); ?></p>
            </div>
            <div class="mb-3">
                <span class="fw-bold text-uppercase text-muted">Nomor Telepon</span>
                <p><?php echo htmlspecialchars($data['nomor_telepon']); ?></p>
            </div>
            <div>
                <span class="fw-bold text-uppercase text-muted">Organisasi</span>
                <p>
                    <?php
                    if (!empty($data['organisasi']) && $data['organisasi'] != "0") {
                        echo htmlspecialchars($data['organisasi']);
                    } else {
                        echo "-";
                    }
                    ?>
                </p>
            </div>
        </div>
    </div>

</div>
</body>
</html>

