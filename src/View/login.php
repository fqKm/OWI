<?php

//require "loginService.php";?>

<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
</head>

<body>
<h1 class="d-flex align-content-center justify-content-center" style="color: #C6E385" >Login</h1>
<from>
    <div class="form-group" style="background-color:">
        <div class="form-group col-md-6">
            <label for="Email">Email</label>
            <input type="email" class="form-control" placeholder="Email" id="Email">
        </div>
        <div class="form-group col-md-6">
            <label for="Password">Password</label>
            <input type="password" class="form-control" placeholder="Password" id="Email">
        </div>
        <button type="submit" class="btn" style="background: #C6E385; color: white"> Login </button>
    </div>
</from>
</body>
</html>
