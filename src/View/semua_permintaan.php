<?php
require_once "../Service/RequestPostService.php";
$requestPostService = new RequestPostService();
$postPermintaan = $requestPostService->getAllRequestPost()?>
<html>
<head>
    <title>
        Semua Permintaan
    </title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
</head>
<body>
<?php include "navbar.php" ?>
<div class="container mt-3 border-dark">
    <h1 class="text-center"> Semua Permintaan yang Tersedia</h1>
    <?php foreach($postPermintaan as $permintaan):?>
        <a href="detail_perminataan.php?id=<?php echo $permintaan['id']?>" class="text-decoration-none">
            <div class="card mb-3">
                <img src="<?php echo $permintaan['foto']?>" class="card-img-top" alt="Post Image">
                <div class="card-body">
                    <h5 class="card-title"> <?php echo $permintaan['judul']?></h5>
                    <p class="card-text"><small class="text-body-secondary">Created by : <?php echo $permintaan['nama_depan'] ?></small></p>
                    <p class="card-text"><small class="text-body-secondary">Created at : <?php echo $permintaan['dibuat_pada']?></small></p>
                </div>
            </div>
        </a>
    <?php endforeach;?>
</div>
</body>
</html>
