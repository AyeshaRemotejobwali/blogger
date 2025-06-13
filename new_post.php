<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if (empty($title) || empty($author) || empty($content)) {
        echo "<script>alert('Please fill all required fields.');</script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO posts (title, content, author, category) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ssss", $title, $content, $author, $category);
        if ($stmt->execute()) {
            echo "<script>alert('Post published successfully!'); window.location.href='blog.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>New Blog Post</title>
    <style>
        body { font-family: Arial; background: #f2f2f2; padding: 40px; }
        form {
            background: #fff; padding: 20px; margin: auto;
            max-width: 600px; box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input, textarea, select {
            width: 100%; padding: 12px; margin-bottom: 15px;
            border: 1px solid #ccc; border-radius: 4px;
        }
        input[type="submit"] {
            background: #0073e6; color: white;
            border: none; cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #005bb5;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Create New Blog Post</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Post Title" required>
        <input type="text" name="author" placeholder="Author Name" required>
        <select name="category">
            <option value="">--Select Category--</option>
            <option value="Technology">Technology</option>
            <option value="Business">Business</option>
            <option value="Lifestyle">Lifestyle</option>
            <option value="Travel">Travel</option>
        </select>
        <textarea name="content" rows="10" placeholder="Write your content here..." required></textarea>
        <input type="submit" value="Publish Post">
    </form>
</body>
</html>
