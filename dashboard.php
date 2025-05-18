<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include 'db.php';

$result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
?>
<link rel="stylesheet" href="style.css">

<a href="add_post.php">Add New Post</a> | 
<a href="logout.php">Logout</a>
<h2>All Posts</h2>
<?php while ($row = $result->fetch_assoc()): ?>
    <div>
        <h3><?= $row['title'] ?></h3>
        <p><?= $row['content'] ?></p>
        <small><?= $row['created_at'] ?></small><br>
        <a href="edit_post.php?id=<?= $row['id'] ?>">Edit</a> | 
        <a href="delete_post.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
        <hr>
    </div>
<?php endwhile; ?>

