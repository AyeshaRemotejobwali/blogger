<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'] ?? null;
    $author = $_POST['author'] ?? '';
    $content = $_POST['content'] ?? '';

    if ($post_id && $author && $content) {
        $stmt = $pdo->prepare("INSERT INTO comments (post_id, author, content) VALUES (?, ?, ?)");
        $stmt->execute([$post_id, $author, $content]);
    }
}

echo "<script>window.location.href = 'post.php?id={$post_id}';</script>";
exit;
?>
