<?php
session_start();
$conn = new mysqli("localhost", "root", "", "aastecs");


if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $department = $_POST['department'];
    $role = "user";

    $stmt = $conn->prepare("INSERT INTO users (name, phone, email, password, department, role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $phone, $email, $password, $department, $role);
    
    if ($stmt->execute()) {
        echo "Registration successful! Wait for admin approval.";
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <form method="post">
            <h2>User Registration</h2>
            <input type="text" name="name" placeholder="Name" required>
            <input type="text" name="phone" placeholder="Phone" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="department">
                <option value="R&D">R&D</option>
                <option value="Software Engineer">Software Engineer</option>
                <option value="Intern">Intern</option>
                <option value="Technical">Technical</option>
                <option value="Accounts">Accounts</option>
                <option value="Admin">Admin</option>
                <option value="Sales">Sales</option>

            </select>
            <button type="submit" name="register">Register</button>
            <p>Already have an account? <a href="login.php">Login</a></p>
        

        <div class="admin-section">
            <h2>Admin Panel</h2>
            <a href="adminlogin.php" class="admin-btn">Login as Admin</a>
        </div>
    </div>
    </form>
</body>
</html>
