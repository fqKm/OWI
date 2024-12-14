<?php
include 'database.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the data from the POST request
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $id_alamat = $_POST['id_alamat'];

    // Handle file upload
    $foto = null; // Initialize the variable
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "img/"; // Directory to save uploaded files
        $target_file = $target_dir . basename($_FILES["foto"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size (limit to 5MB)
        if ($_FILES["foto"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // If everything is ok, try to upload file
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                $foto = $target_file; // Store the file path
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Prepare the SQL statement to update the post
    $sql = "UPDATE penawaran_donasi SET judul = ?, deskripsi = ?, id_alamat = ?, dibuat_pada = NOW()" . ($foto ? ", foto = ?" : "") . " WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    if ($foto) {
        $stmt->bind_param("ssisi", $judul, $deskripsi, $id_alamat, $foto, $id); // Bind the parameters with photo
    } else {
        $stmt->bind_param("ssii", $judul, $deskripsi, $id_alamat, $id); // Bind the parameters without photo
    }

    if ($stmt->execute()) {
        // Redirect to the previous page or a success page
        header("Location: postPenawaran.php?message=Post updated successfully");
        exit();
    } else {
        // Handle error
        echo "Error updating post: " . $conn->error;
    }

    $stmt->close();
}
$conn->close();
?>
