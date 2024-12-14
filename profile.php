<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <title>Profile</title>
    <style>
        body {
            background-color: #f4f4f4;
        }
        .header {
            width: 100%;
            margin-bottom: 20px;
        }
        .container {
            width: 100%;
            max-width: 1200px;
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .profile-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }
        .profile-container img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        .profile-container h3 {
            margin: 10px 0;
            font-size: 2rem;
            color: #333;
        }
        .profile-container p {
            margin: 0;
            font-size: 1.2rem;
            text-align: center;
            color: #666;
        }
        .info-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            margin-top: 30px;
        }
        .info-container p {
            margin: 0;
            font-size: 1.2rem;
            color: #333;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .info-container p:last-child {
            border-bottom: none;
        }
        .info-container p .label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #666;
            font-size: 0.9rem;
            text-transform: uppercase;
        }
        .edit-btn {
            padding: 12px 30px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1rem;
            margin-top: 20px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        .edit-btn:hover {
            background-color: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            color: white;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            .profile-container {
                padding: 20px;
            }
            .profile-container img {
                width: 120px;
                height: 120px;
            }
            .profile-container h3 {
                font-size: 1.8rem;
            }
            .profile-container p {
                font-size: 1rem;
            }
            .info-container {
                width: 100%;
                margin-top: 20px;
                padding: 20px;
            }
            .info-container p {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
<div class="container">
    <?php
    require 'koneksi.php';
    $NIK = 101;
    // Using prepared statement for security
    $stmt = $conn->prepare("SELECT * FROM user LEFT JOIN alamat ON user.id_alamat = alamat.id LEFT JOIN organisasi ON user.nik =organisasi.penanggung_jawab WHERE user.nik = ?");
    $stmt->bind_param("i", $NIK);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if (!$data) {
        echo "<div class='alert alert-danger'>User not found</div>";
        exit;
    }
    ?>

    <div class="profile-container">
        <img src="https://i.imgur.com/xO14F5q.png" alt="Profile Image">
        <h3><?php echo htmlspecialchars($data['nama_depan'] . " " . $data['nama_belakang']); ?></h3>
        <p><?php
            $address = array_filter([
                "RT " . htmlspecialchars($data['rt']),
                "RW " . htmlspecialchars($data['rw']),
                "Jl. " . htmlspecialchars($data['jalan']),
                "Dusun " . htmlspecialchars($data['dusun']),
                "Desa " . htmlspecialchars($data['desa']),
                "Kecamatan " . htmlspecialchars($data['kecamatan']),
                "Kota " . htmlspecialchars($data['kota'])
            ]);
            echo implode(", ", $address);
            ?></p>
    </div>

    <div class="info-container">
        <p><span class="label">NIK</span><?php echo htmlspecialchars($data['nik']); ?></p>
        <p><span class="label">First Name</span><?php echo htmlspecialchars($data['nama_depan']); ?></p>
        <p><span class="label">Last Name</span><?php echo htmlspecialchars($data['nama_belakang']); ?></p>
        <p><span class="label">Email</span><?php echo htmlspecialchars($data['email']); ?></p>
        <p><span class="label">Nomor Telepon</span><?php echo htmlspecialchars($data['nomor_telepon']); ?></p>
        <p><span class="label">Organisasi</span><?php echo htmlspecialchars($data['nama']); ?></p>
        <p><span class="label">Deskripsi Organisasi</span><?php echo htmlspecialchars($data['deskripsi']); ?></p>
    </div>

    <a href="updateprofile.php" class="edit-btn">Edit Profile</a>
</div>
</body>
</html>