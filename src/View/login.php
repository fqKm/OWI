<?php
session_start();
require_once "../Service/UserService.php";
$userService = new UserService();
$email = null;
$password = null;
$error = null;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST["Email"] ?? '';
    $password = $_POST["Password"] ?? '';
    $result = $userService->loginService($email, $password);
    if($result != null){
        $_SESSION['nik'] = $result['nik'];
        header("Location: home.php");
        exit();
    } else {
        $error = "Wrong email or password";
    }
}
?>

<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.css">
</head>

<body>
<div class="container">
    <div class="d-flex justify-content-center mt-5">
        <h1 style="color: #C6E385" >Login</h1>
    </div>
    <div class="row justify-content-center mt-3">
        <form class="row g-3" method="POST">
            <?php if(isset($error)):?>
            <div class="alert alert-danger mt-3 text-center col-md-12"><?php echo $error?></div>
            <?php endif;?>
            <div class="form-group col-md-12">
                <label for="Email">Email</label>
                <input type="email" class="form-control" placeholder="Email" name="Email">
            </div>
            <div class="form-group col-md-12">
                <label for="Password">Password</label>
                <input type="password" class="form-control" placeholder="Password" name="Password">
            </div>
            <div class="col-md-12 text-center mt-3">
                <a href="register.php" class="text-center">I Don't Have an Account</a>
            </div>
            <div class="col-md-12 text-center mt-3">
                <button type="submit" class="btn btn-primary col-md-6">LogIn</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
