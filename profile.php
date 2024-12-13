<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
            background-color: #f4f4f4;
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
        }
        .profile-container img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
        }
        .profile-container h3 {
            margin: 0;
            font-size: 2rem;
        }
        .profile-container p {
            margin: 0;
            font-size: 1.2rem;
        }
        .info-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            background-color: #fff;
            padding: 20px;
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
        }
        .info-container p .label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .edit-btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1rem;
            margin-top: 20px;
            text-decoration: none;
            display: inline-block;
        }
        .edit-btn:hover {
            background-color: #45a049;
        }

        /* Media Query for smaller screens */
        @media (max-width: 768px) {
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
                width: 90%;
                margin-top: 20px;
            }
            .info-container p {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <?php
        require 'koneksi.php';
        $NIK = 101;
        $hasil= mysqli_query($conn,"SELECT * FROM user LEFT JOIN alamat ON user.id_alamat= alamat.id WHERE user.nik=$NIK");
        $data = mysqli_fetch_assoc($hasil);
    ?>
    <div class="profile-container">
        <img src="https://i.imgur.com/xO14F5q.png" alt="Profile Image">
        <h3><?php echo htmlspecialchars($data['nama_depan'] . " " . $data['nama_belakang']); ?></h3>
        <p><?php echo "RT " . htmlspecialchars($data['rt']) . ", RW " . htmlspecialchars($data['rw']) . ", Jl. " . htmlspecialchars($data['jalan']) . ", Dusun " . htmlspecialchars($data['dusun']) . ", Desa " . htmlspecialchars($data['desa']) . ", Kecamatan " . htmlspecialchars($data['kecamatan']) . ", Kota " . htmlspecialchars($data['kota']); ?></p>

    </div>
    <div class="info-container">
        <p><span class="label">NIK</span><?php echo $data['nik']?></p>
        <p><span class="label">First Name</span> <?php echo $data['nama_depan']?> </p>
        <p><span class="label">Last Name</span> <?php echo $data['nama_belakang']?></p>
        <p><span class="label">Email</span> <?php echo $data['email']?></p>
        <p><span class="label">Nomor Telepon</span> <?php echo $data['nomor_telepon']?></p>

    </div>
    <a href="updateprofile.php" class="edit-btn">Edit Profile</a>
</div>
</body>
</html>
