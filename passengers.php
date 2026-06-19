<?php
include 'config.php';
include 'header.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $pid = mysqli_real_escape_string($conn, $_GET['delete']);
    mysqli_query($conn, "DELETE FROM Passenger WHERE pid = '$pid'");
    echo '<div class="alert alert-success">Passenger deleted successfully!</div>';
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pid = mysqli_real_escape_string($conn, $_POST['pid']);
    $pname = mysqli_real_escape_string($conn, $_POST['pname']);
    $pgender = mysqli_real_escape_string($conn, $_POST['pgender']);
    $pcity = mysqli_real_escape_string($conn, $_POST['pcity']);
    
    if (isset($_POST['edit'])) {
        $sql = "UPDATE Passenger SET pname='$pname', pgender='$pgender', pcity='$pcity' WHERE pid='$pid'";
        $msg = "Passenger updated successfully!";
    } else {
        $sql = "INSERT INTO Passenger (pid, pname, pgender, pcity) VALUES ('$pid', '$pname', '$pgender', '$pcity')";
        $msg = "Passenger added successfully!";
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
    $pid = mysqli_real_escape_string($conn, $_GET['edit']);
    $result = mysqli_query($conn, "SELECT * FROM Passenger WHERE pid = '$pid'");
    $edit_data = mysqli_fetch_assoc($result);
}
?>

<div class="card">
    <h2><?php echo $edit_data ? '✏️ Edit Passenger' : '➕ Add New Passenger'; ?></h2>
    <form method="POST" action="">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
            <div class="form-group">
                <label>Passenger ID</label>
                <input type="text" name="pid" value="<?php echo $edit_data['pid'] ?? ''; ?>" <?php echo $edit_data ? 'readonly' : 'required'; ?>>
            </div>
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="pname" value="<?php echo $edit_data['pname'] ?? ''; ?>" required>
            </div>
            <div class="form-group">
                <label>Gender</label>
                <select name="pgender" required>
                    <option value="">Select Gender</option>
                    <option value="Male" <?php echo ($edit_data['pgender'] ?? '') == 'Male' ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo ($edit_data['pgender'] ?? '') == 'Female' ? 'selected' : ''; ?>>Female</option>
                </select>
            </div>
            <div class="form-group">
                <label>City</label>
                <input type="text" name="pcity" value="<?php echo $edit_data['pcity'] ?? ''; ?>" required>
            </div>
        </div>
        <?php if ($edit_data): ?>
            <input type="hidden" name="edit" value="1">
        <?php endif; ?>
        <button type="submit" class="btn btn-success" style="margin-top: 15px;">
            <?php echo $edit_data ? 'Update Passenger' : 'Add Passenger'; ?>
        </button>
        <?php if ($edit_data): ?>
            <a href="passengers.php" class="btn">Cancel</a>
        <?php endif; ?>
    </form>
</div>

<div class="card">
    <h2>👥 All Passengers</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Gender</th>
                <th>City</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM Passenger ORDER BY pid");
            while ($row = mysqli_fetch_assoc($result)):
            ?>
            <tr>
                <td><?php echo $row['pid']; ?></td>
                <td><?php echo $row['pname']; ?></td>
                <td>
                    <span class="badge <?php echo $row['pgender'] == 'Male' ? 'badge-male' : 'badge-female'; ?>">
                        <?php echo $row['pgender']; ?>
                    </span>
                </td>
                <td><?php echo $row['pcity']; ?></td>
                <td>
                    <a href="passengers.php?edit=<?php echo $row['pid']; ?>" class="btn btn-warning" style="padding: 5px 10px;">Edit</a>
                    <a href="passengers.php?delete=<?php echo $row['pid']; ?>" class="btn btn-danger" style="padding: 5px 10px;" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
