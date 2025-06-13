<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config.php';

$query = "SELECT id, title, author, category, created_at FROM posts ORDER BY created_at DESC";
$result = $conn->query($query);

if (!$result) {
    die("Query Failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Blogs</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f1f1f1;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px #ccc;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .post {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }
        .post:last-child {
            border-bottom: none;
        }
        .post h2 {
            margin: 0;
            font-size: 22px;
            color: #007BFF;
        }
        .meta {
            color: #777;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .actions a {
            margin-right: 10px;
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }
        .actions a:hover {
            text-decoration: underline;
        }
        .new-post {
            text-align: right;
            margin-bottom: 20px;
        }
        .new-post a {
            text-decoration: none;
            background: #007BFF;
            color: white;
            padding: 10px 15px;
            border-radius: 4px;
            font-weight: bold;
        }
        .new-post a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>All Blog Posts</h1>

    <div class="new-post">
        <a href="new_post.php">+ New Blog</a>
    </div>

    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="post">
            <h2><?php echo htmlspecialchars($row['title']); ?></h2>
            <div class="meta">
                By <?php echo htmlspecialchars($row['author']); ?> |
                Category: <?php echo htmlspecialchars($row['category']); ?> |
                <?php echo date('F j, Y', strtotime($row['created_at'])); ?>
            </div>
            <div class="actions">
                <a href="view_post.php?id=<?php echo $row['id']; ?>">View</a>
                <a href="edit_post.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a href="delete_post.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this blog?');">Delete</a>
            </div>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>

