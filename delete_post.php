<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $post_id = $_GET['id'];

    // Prepare the delete query
    $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->bind_param("i", $post_id);

    if ($stmt->execute()) {
        echo "<script>alert('Post deleted successfully'); window.location.href = 'blog.php';</script>";
    } else {
        echo "<script>alert('Failed to delete the post.'); window.location.href = 'blog.php';</script>";
    }
} else {
    echo "<script>alert('Invalid post ID.'); window.location.href = 'blog.php';</script>";
}
?>
