<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: adminlogin.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "aastecs");

// Records per page
$limit = 50;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Fetch All Users (Pending, Approved, Rejected)
$totalUsers = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$totalUserPages = ceil($totalUsers / $limit);
$allUsers = $conn->query("SELECT * FROM users ORDER BY status DESC LIMIT $limit OFFSET $offset");

// Fetch Registered Activities
$totalActivities = $conn->query("SELECT COUNT(*) AS total FROM activity")->fetch_assoc()['total'];
$totalActivityPages = ceil($totalActivities / $limit);
$activityResult = $conn->query("SELECT * FROM activity ORDER BY created_at DESC LIMIT $limit OFFSET $offset");

// Approve or Reject Users
if (isset($_GET['approve'])) {
    $id = $_GET['approve'];
    $conn->query("UPDATE users SET status = 'approved' WHERE id = $id");
    header("Location: admin.php?page=$page");
    exit;
}

if (isset($_GET['reject'])) {
    $id = $_GET['reject'];
    $conn->query("UPDATE users SET status = 'rejected' WHERE id = $id");
    header("Location: admin.php?page=$page");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="admin-container">
        <h2>Admin Panel</h2>

        <!-- All Users Table -->
        <h3>All Users</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $allUsers->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td><?= $row['name']; ?></td>
                        <td><?= $row['email']; ?></td>
                        <td><?= $row['phone']; ?></td>
                        <td><?= $row['department']; ?></td>
                        <td class="<?= strtolower($row['status']); ?>-status"><?= ucfirst($row['status']); ?></td>
                        <td>
                            <?php if ($row['status'] == 'pending') { ?>
                                <a href="?approve=<?= $row['id']; ?>" class="approve-btn">Approve</a>
                                <a href="?reject=<?= $row['id']; ?>" class="reject-btn">Reject</a>
                            <?php } else { ?>
                                -
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?= createPaginationLinks($page, $totalUserPages, 'admin.php'); ?>

        <!-- Registered Activities Table -->
        <h3>Registered Activities</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Department</th>
                    <th>Activity</th>
                    <th>Submitted At</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $activityResult->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td><?= $row['name']; ?></td>
                        <td><?= $row['phone']; ?></td>
                        <td><?= $row['department']; ?></td>
                        <td><?= $row['activity']; ?></td>
                        <td><?= $row['created_at']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?= createPaginationLinks($page, $totalActivityPages, 'admin.php'); ?>

        <!-- Logout Button -->
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>

<?php
// Function to create pagination links
function createPaginationLinks($currentPage, $totalPages, $baseUrl) {
    if ($totalPages > 1) {
        echo '<div class="pagination">';
        if ($currentPage > 1) {
            echo '<a href="'.$baseUrl.'?page='.($currentPage - 1).'" class="pagination-btn">Previous</a>';
        }
        echo '<span>Page '.$currentPage.' of '.$totalPages.'</span>';
        if ($currentPage < $totalPages) {
            echo '<a href="'.$baseUrl.'?page='.($currentPage + 1).'" class="pagination-btn">Next</a>';
        }
        echo '</div>';
    }
}
?>
