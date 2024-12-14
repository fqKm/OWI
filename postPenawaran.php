<?php
include 'database.php'; // Ensure this file contains your database connection details

$sql = "
    SELECT pd.id, pd.judul, pd.deskripsi, pd.dibuat_pada, pd.foto, 
           CONCAT(a.jalan, ', ', a.dusun, ', ', a.desa, ', ', a.kecamatan, ', ', a.kota) AS alamat
    FROM penawaran_donasi pd
    LEFT JOIN alamat a ON pd.id_alamat = a.id
    LIMIT 2
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postingan Barang</title>
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap Icon CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>

        /* Reset dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .post-container {
            width: 600px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
        }

        /* Icon Bootstrap */
        .icon {
            font-size: 40px;
            color: #007bff;
            margin-bottom: 10px;
            text-align: center;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h2 {
            font-size: 1.5rem;
            margin-bottom: 5px;
        }

        .location {
            font-size: 0.9rem;
            color: #666;
        }

        /* Details */
        .details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .details .Loc,
        .details .time {
            font-size: 0.9rem;
            color: #333;
        }

        /* Deskripsi */
        .description {
            background-color: #f8f9fa;
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        /* Foto */
        .photo img {
            width: 100%;
            height: auto;
            border-radius: 5px;
            border: 1px solid #ddd;
            width: 560px;
            height: 300px;
        }

        .actions {
            text-align: center; /* Center the actions */
        }

        .actions button {
            background-color: #dc3545; /* Bootstrap danger color */
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .actions button:hover {
            background-color: #c82333; /* Darker shade on hover */
        }

    </style>
</head>
<body>
    <div class="headers"></div>

    <!-- First Post Container -->
    <div class="post-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="post" id="post-<?php echo $row['id']; ?>">

                    <div class="icon">
                        <i class="bi bi-box-seam"></i>
                    </div>

                    <div class="header">
                        <h2><?php echo $row['judul']; ?></h2>
                    </div>

                    <div class="details">
                        <div class="Loc">
                            <p class="location">Lokasi: <?php echo $row['alamat']; ?></p>
                        </div>

                        <div class="time">
                            <label></label>
                            <span><?php echo date("d M Y, H:i", strtotime($row['dibuat_pada'])); ?> WIB</span>
                        </div>
                    </div>

                    <div class="description">
                        <p><?php echo $row['deskripsi']; ?></p>
                    </div>

                    <div class="photo">
                        <img src="getImage.php?id=1" width="560" height="300" />
                    </div>

                    <div class="actions">

                        <form action="edit.php" method="POST" ></form>
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn edit-btn">Edit</a>
                        <form action="delete.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this post?');">Delete</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No postings available.</p>
        <?php endif; ?>
    </div>
</body>
</html>
