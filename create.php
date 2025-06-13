<?php
require 'db.php';
require 'includes/header.php';

// Fetch categories for the dropdown
$stmt = $pdo->query("SELECT id, name FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category'];
    $user_id = 1; // Replace with the actual logged-in user's ID

    $stmt = $pdo->prepare("INSERT INTO posts (user_id, category_id, title, content) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $category_id, $title, $content]);

    echo "<script>window.location.href = 'index.php';</script>";
    exit;
}
?>

<h1>Create New Post</h1>
<form method="post">
    <input type="text" name="title" placeholder="Post Title" required><br>
    <select name="category" required>
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category['id']; ?>"><?= htmlspecialchars($category['name']); ?></option>
        <?php endforeach; ?>
    </select><br>
    <textarea name="content" id="editor" rows="10" cols="80"></textarea><br>
    <button type="submit">Publish</button>
</form>

<!-- Include TinyMCE or Quill -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: '#editor'
    });
</script>

<?php require 'includes/footer.php'; ?>
