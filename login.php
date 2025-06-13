<?php
// SHOW ERRORS
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo "<script>alert('Email and password required');</script>";
        exit;
    }

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    if (!$result) {
        die("Query failed: " . $stmt->error);
    }

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            echo "<script>alert('Login successful'); window.location.href='blog.php';</script>";
        } else {
            echo "<script>alert('Wrong password');</script>";
        }
    } else {
        echo "<script>alert('User not found');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login Page</h2>
    <form method="POST">
        Email: <input type="email" name="email" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
