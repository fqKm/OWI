<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Load Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>

<body>
<div class="container mt-5">
        <center><h2>Registrasi akun</h2></center>
        <br>
        <div class="row justify-content-md-center">
            <div class="col-md-6">
                <!-- Form Section -->
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <!-- NIM Input -->
                    <div class="form-group">
                        <label for="nama_depan">nama_depan</label>
                        <input type="text" class="form-control" name="nama_depan" id="nama_depan" placeholder="John Doe" required>
                    </div>

                    <div class="form-group">
                        <label for="nama_belakang">nama_belakang</label>
                        <input type="text" class="form-control" name="nama_belakang" id="nama_belakang" placeholder="John Doe" required>
                    </div>

                    <div class="form-group">
                        <label for="nik">nik</label>
                        <input type="text" class="form-control" name="nik" id="nik" placeholder="8888888888888" required>
                    </div>

                    <div class="form-group">
                        <label for="email">email</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="abcd@gmail.com" required>
                    </div>

                    <div class="form-group">
                        <label for="password">password</label>
                        <input type="text" class="form-control" name="password" id="password" placeholder="password" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary mb-3">Register</button>
                </form>
            </div>
        </div>
</body>

<?php
require 'koneksi.php';
if (isset($_POST['submit'])) {
    $nama_depan = $_POST['nama_depan'];
    $nama_belakang = $_POST['nama_belakang'];
    $nik = $_POST['nik'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "INSERT INTO user (nama_depan, nama_belakang, nik, email, password) VALUES ('$nama_depan', '$nama_belakang', '$nik', '$email', '$password')";
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        header("Location: dashboard.php");
    } else {
        echo "Data Gagal Ditambahkan";
    }
}
?>
</html>

