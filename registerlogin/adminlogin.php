<?php
session_start();

if (isset($_POST['admin_login'])) {
    $admin_email = $_POST['admin_email'];
    $admin_password = $_POST['admin_password'];

    if ($admin_email === "admin@gmail.com" && $admin_password === "admin") {
        $_SESSION['admin'] = "Admin";
        header("Location: admin.php");
        exit;
    } else {
        echo "Invalid admin credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="post">
        <h2>Admin Login</h2>
        <input type="email" name="admin_email" placeholder="Admin Email" required>
        <input type="password" name="admin_password" placeholder="Admin Password" required>
        <button type="submit" name="admin_login">Login as Admin</button>
        <p><a href="index.php">Back to Home</a></p>
    </form>
</body>
</html>
