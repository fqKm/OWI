<?php
include 'database.php'; // Include your database connection

// Check if the ID is provided
if (!isset($_GET['id'])) {
    header("Location: index.php"); // Redirect if no ID is provided
    exit();
}

$id = $_GET['id'];

// Fetch the post data based on the ID
$sql = "SELECT pd.id, pd.judul, pd.deskripsi, pd.foto, pd.id_alamat, 
               CONCAT(a.jalan, ', ', a.dusun, ', ', a.desa, ', ', a.kecamatan, ', ', a.kota) AS alamat
        FROM penawaran_donasi pd
        LEFT JOIN alamat a ON pd.id_alamat = a.id
        WHERE pd.id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: index.php"); // Redirect if no post found
    exit();
}

$row = $result->fetch_assoc();

// Fetch all addresses for the dropdown
$alamat_sql = "SELECT id, CONCAT(jalan, ', ', dusun, ', ', desa, ', ', kecamatan, ', ', kota) AS full_alamat FROM alamat";
$alamat_result = $conn->query($alamat_sql);

if ($alamat_result === false) {
    die("Error fetching addresses: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>

    <style>
        *{
            font-family: Arial, Helvetica, sans-serif;
            padding: 5px;
        }

        label{
            display: block;
           
        }

        label.judul{
            background-color: red;
            height: 20px;
        }
        
    </style>
</head>
<body>
    <h2>Edit Post</h2>
    <form action="update.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <label for="judul" class="judul">Judul</label>
        <input type="text" id="judul" name="judul" value="<?php echo htmlspecialchars($row['judul']); ?>" required>

        <label for="deskripsi">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" rows="4" required><?php echo htmlspecialchars($row['deskripsi']); ?></textarea>

        <label for="foto">Foto (Upload Image)</label>
        <input type="file" id="foto" name="foto" accept="image/*">

        <label for="alamat">Alamat</label>
        <select id="alamat" name="id_alamat" required>
            <?php while ($alamat_row = $alamat_result->fetch_assoc()): ?>
                <option value="<?php echo $alamat_row['id']; ?>" <?php echo ($alamat_row['id'] == $row['id_alamat']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($alamat_row['full_alamat']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Update</button>
        <a href="index.php">Cancel</a>
    </form>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
