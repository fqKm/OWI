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
        $NIK = $_GET['nik'];
        $hasil= mysqli_query($conn,"SELECT * FROM user WHERE nim=$NIK");
       
        while ($data = mysqli_fetch_array($hasil)) {
            $nim = $data['nim'];
            $namaDepan = $data['nama_depan'];
            $namaBelakang = $data['nama_Belakang'];
            $email = $data['email'];
            $nomorHP = $data['nomor_telepon'];
            $alamat = $data['id_alamat'];
        }
        require 'koneksi.php';

        $NIK = $_GET['nik']; // Get NIK from the request

        // SQL query to fetch data from `user` and the related data from `alamat`
        $query = "
            SELECT 
                user.nim, 
                user.nama_depan, 
                user.nama_belakang, 
                user.email, 
                user.nomor_telepon, 
                alamat.jalan, 
                alamat.kota, 
                alamat.provinsi, 
                alamat.kode_pos
            FROM 
                user
            LEFT JOIN 
                alamat 
            ON 
                user.id_alamat = alamat.id
            WHERE 
                user.nim = '$NIK'
        ";

        $result = mysqli_query($conn, $query);

        if ($data = mysqli_fetch_array($result)) {
            // Fetch user details
            $nim = $data['nim'];
            $namaDepan = $data['nama_depan'];
            $namaBelakang = $data['nama_belakang'];
            $email = $data['email'];
            $nomorHP = $data['nomor_telepon'];

            // Fetch related address details
            $jalan = $data['jalan'];
            $kota = $data['kota'];
            $provinsi = $data['provinsi'];
            $kodePos = $data['kode_pos'];

    ?>
    <div class="profile-container">
        <img src="https://i.imgur.com/xO14F5q.png" alt="Profile Image">
        <h3>John Doe</h3>
        <p>Bay Area, San Francisco, CA</p>
    </div>
    <div class="info-container">
        <p><span class="label">NIK</span> 177013</p>
        <p><span class="label">First Name</span> John </p>
        <p><span class="label">Last Name</span> Doe</p>
        <p><span class="label">Email</span> john.doe@example.com</p>
        <p><span class="label">Nomor Telepon</span> 085313588532</p>
    </div>
    <a href="updateprofile.php" class="edit-btn">Edit Profile</a>
</div>
</body>
</html>
