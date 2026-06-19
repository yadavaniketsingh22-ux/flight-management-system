<?php
include 'config.php';
include 'header.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $aid = mysqli_real_escape_string($conn, $_GET['delete']);
    mysqli_query($conn, "DELETE FROM Agency WHERE aid = '$aid'");
    echo '<div class="alert alert-success">Agency deleted successfully!</div>';
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $aid = mysqli_real_escape_string($conn, $_POST['aid']);
    $aname = mysqli_real_escape_string($conn, $_POST['aname']);
    $acity = mysqli_real_escape_string($conn, $_POST['acity']);
    
    if (isset($_POST['edit'])) {
        $sql = "UPDATE Agency SET aname='$aname', acity='$acity' WHERE aid='$aid'";
        $msg = "Agency updated successfully!";
    } else {
        $sql = "INSERT INTO Agency (aid, aname, acity) VALUES ('$aid', '$aname', '$acity')";
        $msg = "Agency added successfully!";
    }
    
    if (mysqli_query($conn, $sql)) {
        echo '<div class="alert alert-success">'.$msg.'</div>';
    } else {
        echo '<div class="alert alert-danger">Error: '.mysqli_error($conn).'</div>';
    }
}

// Get edit data
$edit_data = null;
if (isset($_GET['edit'])) {
    $aid = mysqli_real_escape_string($conn, $_GET['edit']);
    $result = mysqli_query($conn, "SELECT * FROM Agency WHERE aid = '$aid'");
    $edit_data = mysqli_fetch_assoc($result);
}
?>

<div class="card">
    <h2><?php echo $edit_data ? '✏️ Edit Agency' : '➕ Add New Agency'; ?></h2>
    <form method="POST" action="">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
            <div class="form-group">
                <label>Agency ID</label>
                <input type="text" name="aid" value="<?php echo $edit_data['aid'] ?? ''; ?>" <?php echo $edit_data ? 'readonly' : 'required'; ?>>
            </div>
            <div class="form-group">
                <label>Agency Name</label>
                <input type="text" name="aname" value="<?php echo $edit_data['aname'] ?? ''; ?>" required>
            </div>
            <div class="form-group">
                <label>City</label>
                <input type="text" name="acity" value="<?php echo $edit_data['acity'] ?? ''; ?>" required>
            </div>
        </div>
        <?php if ($edit_data): ?>
            <input type="hidden" name="edit" value="1">
        <?php endif; ?>
        <button type="submit" class="btn btn-success" style="margin-top: 15px;">
            <?php echo $edit_data ? 'Update Agency' : 'Add Agency'; ?>
        </button>
        <?php if ($edit_data): ?>
            <a href="agencies.php" class="btn">Cancel</a>
        <?php endif; ?>
    </form>
</div>

<div class="card">
    <h2>🏢 All Agencies</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Agency Name</th>
                <th>City</th>
                <th>Total Bookings</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($conn, "
                SELECT a.*, COUNT(b.aid) as booking_count 
                FROM Agency a 
                LEFT JOIN Booking b ON a.aid = b.aid 
                GROUP BY a.aid 
                ORDER BY a.aid
            ");
            while ($row = mysqli_fetch_assoc($result)):
            ?>
            <tr>
                <td><?php echo $row['aid']; ?></td>
                <td><strong><?php echo $row['aname']; ?></strong></td>
                <td><?php echo $row['acity']; ?></td>
                <td><span class="badge badge-male"><?php echo $row['booking_count']; ?></span></td>
                <td>
                    <a href="agencies.php?edit=<?php echo $row['aid']; ?>" class="btn btn-warning" style="padding: 5px 10px;">Edit</a>
                    <a href="agencies.php?delete=<?php echo $row['aid']; ?>" class="btn btn-danger" style="padding: 5px 10px;" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
