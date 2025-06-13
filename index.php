<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php';

// Fetch all posts ordered by latest first
$query = "SELECT id, title, content, author, category, created_at FROM posts ORDER BY created_at DESC";
$result = $conn->query($query);

if (!$result) {
    die("Query Failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Blogger</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f1f1f1;
            margin: 0;
            padding: 0;
        }
        .header {
            background: #007BFF;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            background: white;
            padding: 20px;
        }
        .post {
            border-bottom: 1px solid #ccc;
            margin-bottom: 20px;
            padding-bottom: 15px;
        }
        .post h2 {
            margin-top: 0;
        }
        .meta {
            color: gray;
            font-size: 14px;
        }
        .post a {
            color: #007BFF;
            text-decoration: none;
        }
        .post a:hover {
            text-decoration: underline;
        }
        .top-bar {
            text-align: right;
            margin-bottom: 10px;
        }
        .top-bar a {
            margin-left: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Welcome to My Blogger</h1>
</div>

<div class="container">
    <div class="top-bar">
        <a href="new_post.php">+ New Post</a>
        <a href="signout.php">Logout</a>
    </div>

    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="post">
            <h2><a href="view_post.php?id=<?php echo $row['id']; ?>">
                <?php echo htmlspecialchars($row['title']); ?>
            </a></h2>
            <div class="meta">
                By <?php echo htmlspecialchars($row['author']); ?> |
                Category: <?php echo htmlspecialchars($row['category']); ?> |
                <?php echo date('F j, Y', strtotime($row['created_at'])); ?>
            </div>
            <p><?php echo nl2br(htmlspecialchars(substr($row['content'], 0, 150))) . '...'; ?></p>
            <a href="edit_post.php?id=<?php echo $row['id']; ?>">Edit</a> |
            <a href="delete_post.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this post?');">Delete</a>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>
