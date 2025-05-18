<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check if username already exists
    $check = "SELECT id FROM users WHERE username=?";
    $stmt = mysqli_prepare($conn, $check);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        $error = "Username already exists. Please choose another one.";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $username, $hashed);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Registration failed.";
        }
    }
}
?>

<link rel="stylesheet" href="style.css">
<form method="POST">
    <h2>Register</h2>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <input type="text" name="username" placeholder="Choose Username" required>
    <input type="password" name="password" placeholder="Choose Password" required>
    <button type="submit">Register</button>
</form>
<p>Already have an account? <a href="login.php">Login here</a></p>
