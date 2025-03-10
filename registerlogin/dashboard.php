<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>
<?php
$conn = new mysqli("localhost", "root", "", "aastecs");


if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];
    $activity = $_POST['activity'];
    $stmt = $conn->prepare("INSERT INTO activity (name, phone, department,activity) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $phone, $department, $activity);
    
    if ($stmt->execute()) {
        echo "Registration successful! for $activity.";
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
            <h2>Registration for Cultural Activities</h2>
            <input type="text" name="name" placeholder="Name" required>
            <input type="text" name="phone" placeholder="Phone" required>
            <select name="department">
                <option value="R&D">R&D</option>
                <option value="Software Engineer">Software Engineer</option>
                <option value="Intern">Intern</option>
                <option value="Technical">Technical</option>
                <option value="Accounts">Accounts</option>
                <option value="Admin">Admin</option>
                <option value="Sales">Sales</option>
            </select>
            <input type="text" name="activity" placeholder="Activity" required>
            <button type="submit" name="register">Register to Participate</button> 
        
    </div>
    </form>
</body>
</html>
<p>Registration completed ?<a href="logout.php">Logout</a></p>
