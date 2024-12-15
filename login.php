<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
                        <label for="email">email</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="abcd@gmail.com" required>
                    </div>

                    <div class="form-group">
                        <label for="password">password</label>
                        <input type="Password" class="form-control" name="password" id="password" placeholder="password" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary mb-3">Register</button>
                </form>
            </div>
        </div>
</body>
<?php
require "koneksi.php";
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
    $hasil = mysqli_query($conn, $query);

    if (mysqli_num_rows($hasil) > 0) {
        header("Location: dashboard.php");
    } else {
        echo "Maaf email atau password salah";
    }
}
?>
</html>
