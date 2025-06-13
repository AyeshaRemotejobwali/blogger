<?php
require 'db.php';
require 'includes/header.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<script>window.location.href = 'index.php';</script>";
    exit;
}

// Fetch the post
$stmt = $pdo->prepare("SELECT posts.title, posts.content, posts.created_at, users.username, categories.name AS category_name
                       FROM posts
                       JOIN users ON posts.user_id = users.id
                       JOIN categories ON posts.category_id = categories.id
                       WHERE posts.id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    echo "<p>Post not found.</p>";
    require 'includes/footer.php';
    exit;
}

// Fetch comments
$stmt = $pdo->prepare("SELECT author, content, created_at FROM comments WHERE post_id = ? ORDER BY created_at ASC");
$stmt->execute([$id]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1><?= htmlspecialchars($post['title']); ?></h1>
<p>By <?= htmlspecialchars($post['username']); ?> in <?= htmlspecialchars($post['category_name']); ?> on <?= $post['created_at']; ?></p>
<div>
    <?= nl2br(htmlspecialchars($post['content'])); ?>
</div>

<h2>Comments</h2>
<?php foreach ($comments as $comment): ?>
    <div class="comment">
        <p><strong><?= htmlspecialchars($comment['author']); ?></strong> on <?= $comment['created_at']; ?></p>
        <p><?= nl2br(htmlspecialchars($comment['content'])); ?></p>
    </div>
<?php endforeach; ?>

<h3>Add a Comment</h3>
<form method="post" action="comment.php">
    <input type="hidden" name="post_id" value="<?= $id; ?>">
    <input type="text" name="author" placeholder="Your Name" required><br>
    <textarea name="content" rows="5" cols="50" placeholder="Your Comment" required></textarea><br>
    <button type="submit">Submit Comment</button>
</form>

<?php require 'includes/footer.php'; ?>
