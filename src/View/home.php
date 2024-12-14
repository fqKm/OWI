<?php
require_once "../Service/OfferPostService.php";
require_once "../Service/RequestPostService.php";
$offerPostService = new OfferPostService();
$requestPostService = new RequestPostService();
$postPenawaran = $offerPostService->getPostByHighestUpvote();
$postPermintaan = $requestPostService->getPostByHighestUpvote();
?>
<html>
<head>
    <title> Homepage </title>
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.css">
</head>
<body>
<div class="container mt-3 border-dark">
    <h1 class="text-center"> Penawaran yang Sedang Baru</h1>
    <?php foreach($postPenawaran as $penawaran):?>
    <a href="detail_penawaran.php?id=<?php echo (int)$penawaran['id']?>" class="text-decoration-none">
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
    <div class="text-center mt-4">
        <a href="semua_penawran.php?page=0" class="btn btn-primary">Lihat Semua</a>
    </div>
    <div class="text-center mt-4">
        <a href="buat_penawaran.php" class="btn btn-success"> Buat Penawaran </a>
    </div>
</div>

<div class="container mt-3">
    <h1 class="text-center"> Permintaan Donasi Baru</h1>
    <?php foreach($postPermintaan as $permintaan):?>
        <a href="detail_perminataan.php?id=<?php echo (int)$permintaan['id']?>" class="text-decoration-none">
            <div class="card mb-3">
                <img src="<?php echo $permintaan['foto']?>" class="card-img-top" alt="Post Image">
                <div class="card-body">
                    <h5 class="card-title"> <?php echo $permintaan['judul']?></h5>
                    <p class="card-text"><small class="text-body-secondary">Requested by : <?php echo $permintaan['organisasi']?></small></p>
                    <p class="card-text"><small class="text-body-secondary">Created at : <?php echo $permintaan['dibuat_pada']?></small></p>
                </div>
            </div>
        </a>
    <?php endforeach;?>
    <div class="text-center mt-4">
        <a href="semua_permintaan.php?page=0" class="btn btn-primary">Lihat Semua</a>
    </div>
    <div class="text-center mt-4">
        <a href="buat_permintaan.php" class="btn btn-success"> Buat Permintaan </a>
    </div>
</div>
</body>
</html>