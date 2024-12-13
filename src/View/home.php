<?php
require "../Service/OfferPostService.php";
$offerPostService = new OfferPostService();
$postPenawaran = $offerPostService->getPostByHighestUpvote();
?>
<html>
<head>
    <title> Homepage </title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
</head>
<body>
<div class="container mt-3 border-dark">
    <h1 class="text-center"> Penawaran yang Sedang Trending</h1>
<!--    --><?php //while($postPenawaran):?>
    <a href="detail.php?id=<?php echo $postPenawaran['id']?>" class="text-decoration-none">
        <div class="card mb-3">
            <img src="<?php echo $postPenawaran['foto']?>.jpg" class="card-img-top" alt="Post Image">
            <div class="card-body">
                <h5 class="card-title"> <?php echo $postPenawaran['judul']?></h5>
                <p class="card-text"><small class="text-body-secondary">Created by : <?php echo $postPenawaran['nama_depan'].$postPenawaran['nama_belakang'] ?></small></p>
                <p class="card-text"><small class="text-body-secondary">Created at : <?php echo $postPenawaran['dibuat_pada']?></small></p>
            </div>
        </div>
    </a>
<!--    --><?php //endwhile;?>
    <div class="text-center mt-4">
        <a href="semua_penawran.php?page=0" class="btn btn-primary">Lihat Semua</a>
    </div>
</div>

<div class="container mt-3">
    <h1 class="text-center"> Permintaan Donasi yang Sedang Trending</h1>
<!--    --><?php //while($postPermintaan):?>
        <a href="detail.php?id=<?php echo $postPermintaan['id']?>" class="text-decoration-none">
            <div class="card mb-3">
                <img src="<?php echo $postPermintaan['foto']?>.jpg" class="card-img-top" alt="Post Image">
                <div class="card-body">
                    <h5 class="card-title"> <?php echo $postPermintaan['judul']?></h5>
                    <p class="card-text"><small class="text-body-secondary">Created by : <?php echo $postPermintaan['nama_depan'].$postPermintaan['nama_belakang'] ?></small></p>
                    <p class="card-text"><small class="text-body-secondary">Created at : <?php echo $postPermintaan['dibuat_pada']?></small></p>
                </div>
            </div>
        </a>
<!--    --><?php //endwhile;?>
    <div class="text-center mt-4">
        <a href="semua_permintaan.php?page=0" class="btn btn-primary">Lihat Semua</a>
    </div>
</div>

</body>
</html>