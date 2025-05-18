<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $content);
    $stmt->execute();

    header("Location: dashboard.php");
}
?>
<link rel="stylesheet" href="style.css">

<form method="POST">
    Title: <input type="text" name="title" required><br>
    Content:<br>
    <textarea name="content" rows="5" cols="40" required></textarea><br>
    <button type="submit">Add Post</button>
</form>
