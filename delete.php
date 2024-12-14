<?php
include 'database.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the ID from the POST request
    $id = $_POST['id'];

    // Prepare the SQL statement to delete the post
    $sql = "DELETE FROM penawaran_donasi WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // Bind the ID parameter

    if ($stmt->execute()) {
        // Redirect to the previous page or a success page
        header("Location: index.php?message=Post deleted successfully");
        exit();
    } else {
        // Handle error
        echo "Error deleting post: " . $conn->error;
    }

    $stmt->close();
}
$conn->close();
?>
