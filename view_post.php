<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: No post ID provided.");
}

$post_id = intval($_GET['id']);

// Prepare statement to prevent SQL injection
$stmt = $conn->prepare("SELECT title, content, author, category, created_at FROM posts WHERE id = ?");
$stmt->bind_param("i", $post_id);

if (!$stmt->execute()) {
    die("Error executing query: " . $stmt->error);
}

$stmt->store_result();

if ($stmt->num_rows === 0) {
    die("No post found with this ID.");
}

$stmt->bind_result($title, $content, $author, $category, $created_at);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($title); ?> - Blog</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f9f9f9;
            padding: 30px;
        }
        .container {
            background: #fff;
            padding: 25px;
            max-width: 800px;
            margin: auto;
            border-left: 5px solid #007BFF;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h1 {
            margin-top: 0;
        }
        .meta {
            color: #777;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .content {
            line-height: 1.6;
            font-size: 17px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1><?php echo htmlspecialchars($title); ?></h1>
    <div class="meta">
        By <?php echo htmlspecialchars($author); ?> |
        Category: <?php echo htmlspecialchars($category); ?> |
        Posted on <?php echo date('F j, Y', strtotime($created_at)); ?>
    </div>
    <div class="content">
        <?php echo nl2br(htmlspecialchars($content)); ?>
    </div>
</div>

</body>
</html>
