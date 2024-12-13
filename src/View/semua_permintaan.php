<?php
$page = null;
if(isset($page)){
    $page = $_GET['page'];
}
require "../Service/RequestPostService.php";
$offerPostService = new RequestPostService();
$postPermintaan = $offerPostService->getAllRequestPost($page)?>
<html>
<head>
    <title>
        Semua Permintaan
    </title>
    <link href="../../bootstrap/css/bootstrap.css" rel="stylesheet">
</head>
<body>
<div class="container mt-3 border-dark">
    <h1 class="text-center"> Semua Permintaan yang Tersedia</h1>
    <?php while($postPermintaan):?>
        <a href="detail.php?id=<?php echo $postPermintaan['id']?>" class="text-decoration-none">
            <div class="card mb-3">
                <img src="<?php echo $postPermintaan['foto']?>.jpg" class="card-img-top" alt="Post Image">
                <div class="card-body">
                    <h5 class="card-title"> <?php echo $postPermintaan['judul']?></h5>
                    <p class="card-text"><small class="text-body-secondary">Created by : <?php echo $postPermintaan['nama'] ?></small></p>
                    <p class="card-text"><small class="text-body-secondary">Created at : <?php echo $postPermintaan['dibuat_pada']?></small></p>
                </div>
            </div>
        </a>
    <?php endwhile;?>
    <div class="pagination justify-content-center">
        <?php if ($page > 0): ?>
            <a href="?page=<?php echo $page - 1; ?>" class="btn btn-primary m-5">Previous</a>
        <?php else: ?>
            <span class="btn btn-secondary m-5">Previous</span>
        <?php endif; ?>

        <a href="?page=<?php echo $page + 1; ?>" class="btn btn-primary m-5">Next</a>
    </div>
</div>
</body>
</html>
