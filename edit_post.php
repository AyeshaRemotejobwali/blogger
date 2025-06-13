<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid post ID");
}

$id = $_GET['id'];

// Fetch existing post
$stmt = $conn->prepare("SELECT title, content, category FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Post not found");
}

$post = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];

    $update = $conn->prepare("UPDATE posts SET title = ?, content = ?, category = ? WHERE id = ?");
    $update->bind_param("sssi", $title, $content, $category, $id);
    if ($update->execute()) {
        echo "<script>alert('Post updated successfully'); window.location.href = 'blog.php';</script>";
        exit;
    } else {
        echo "Error: " . $update->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f0f0f0;
            padding: 30px;
        }
        .container {
            background: white;
            padding: 25px;
            max-width: 700px;
            margin: auto;
            box-shadow: 0 0 10px #ccc;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        input, textarea, select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background: #007BFF;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Blog Post</h2>
    <form method="POST">
        <label>Title:</label>
        <input type="text" name="title" required value="<?php echo htmlspecialchars($post['title']); ?>">

        <label>Content:</label>
        <textarea name="content" rows="8" required><?php echo htmlspecialchars($post['content']); ?></textarea>

        <label>Category:</label>
        <select name="category" required>
            <option value="Technology" <?php if ($post['category'] == 'Technology') echo 'selected'; ?>>Technology</option>
            <option value="Lifestyle" <?php if ($post['category'] == 'Lifestyle') echo 'selected'; ?>>Lifestyle</option>
            <option value="Business" <?php if ($post['category'] == 'Business') echo 'selected'; ?>>Business</option>
            <option value="Travel" <?php if ($post['category'] == 'Travel') echo 'selected'; ?>>Travel</option>
        </select>

        <button type="submit">Update Post</button>
    </form>
</div>

</body>
</html>
