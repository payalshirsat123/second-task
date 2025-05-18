<?php
session_start();
include 'db.php';

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("UPDATE posts SET title=?, content=? WHERE id=?");
    $stmt->bind_param("ssi", $title, $content, $id);
    $stmt->execute();

    header("Location: dashboard.php");
}

$stmt = $conn->prepare("SELECT title, content FROM posts WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($title, $content);
$stmt->fetch();
?>
<link rel="stylesheet" href="style.css">

<form method="POST">
    Title: <input type="text" name="title" value="<?= $title ?>" required><br>
    Content:<br>
    <textarea name="content" rows="5" cols="40" required><?= $content ?></textarea><br>
    <button type="submit">Update Post</button>
</form>

