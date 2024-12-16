<?php
require_once "../Service/OfferPostService.php";
$offerPostService = new OfferPostService();
$postPenawaran = $offerPostService->getAllOfferPost()?>
<html>
<head>
    <title>
        Semua Penawaran
    </title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
</head>
<body>
<?php include "navbar.php" ?>
<div class="container mt-3 border-dark">
    <h1 class="text-center"> Semua Penawaran yang Tersedia</h1>
    <?php foreach($postPenawaran as $penawaran):?>
        <a href="detail_penawaran.php?id=<?php echo $penawaran['id']?>" class="text-decoration-none">
            <div class="card mb-3">
                <img src="<?php echo $penawaran['foto']?>" class="card-img-top" alt="Post Image">
                <div class="card-body">
                    <h5 class="card-title"> <?php echo $penawaran['judul']?></h5>
                    <p class="card-text"><small class="text-body-secondary">Created by : <?php echo $penawaran['nama_depan']." ".$penawaran['nama_belakang'] ?></small></p>
                    <p class="card-text"><small class="text-body-secondary">Created at : <?php echo $penawaran['dibuat_pada']?></small></p>
                </div>
            </div>
        </a>
    <?php endforeach;?>
</div>
</body>
</html>
