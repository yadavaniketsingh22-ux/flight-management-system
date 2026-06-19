<?php
include 'config.php';
include 'header.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $fid = mysqli_real_escape_string($conn, $_GET['delete']);
    mysqli_query($conn, "DELETE FROM Flight WHERE fid = '$fid'");
    echo '<div class="alert alert-success">Flight deleted successfully!</div>';
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fid = mysqli_real_escape_string($conn, $_POST['fid']);
    $fdate = mysqli_real_escape_string($conn, $_POST['fdate']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $src = mysqli_real_escape_string($conn, $_POST['src']);
    $dest = mysqli_real_escape_string($conn, $_POST['dest']);
    
    if (isset($_POST['edit'])) {
        $sql = "UPDATE Flight SET fdate='$fdate', time='$time', src='$src', dest='$dest' WHERE fid='$fid'";
        $msg = "Flight updated successfully!";
    } else {
        $sql = "INSERT INTO Flight (fid, fdate, time, src, dest) VALUES ('$fid', '$fdate', '$time', '$src', '$dest')";
        $msg = "Flight added successfully!";
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
    $fid = mysqli_real_escape_string($conn, $_GET['edit']);
    $result = mysqli_query($conn, "SELECT * FROM Flight WHERE fid = '$fid'");
    $edit_data = mysqli_fetch_assoc($result);
}
?>

<div class="card">
    <h2><?php echo $edit_data ? '✏️ Edit Flight' : '➕ Add New Flight'; ?></h2>
    <form method="POST" action="">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
            <div class="form-group">
                <label>Flight ID</label>
                <input type="text" name="fid" value="<?php echo $edit_data['fid'] ?? ''; ?>" <?php echo $edit_data ? 'readonly' : 'required'; ?>>
            </div>
            <div class="form-group">
                <label>Date</label>
                <input type="date" name="fdate" value="<?php echo $edit_data['fdate'] ?? ''; ?>" required>
            </div>
            <div class="form-group">
                <label>Time</label>
                <input type="time" name="time" value="<?php echo $edit_data['time'] ?? ''; ?>" required>
            </div>
            <div class="form-group">
                <label>Source City</label>
                <input type="text" name="src" value="<?php echo $edit_data['src'] ?? ''; ?>" required>
            </div>
            <div class="form-group">
                <label>Destination City</label>
                <input type="text" name="dest" value="<?php echo $edit_data['dest'] ?? ''; ?>" required>
            </div>
        </div>
        <?php if ($edit_data): ?>
            <input type="hidden" name="edit" value="1">
        <?php endif; ?>
        <button type="submit" class="btn btn-success" style="margin-top: 15px;">
            <?php echo $edit_data ? 'Update Flight' : 'Add Flight'; ?>
        </button>
        <?php if ($edit_data): ?>
            <a href="flights.php" class="btn">Cancel</a>
        <?php endif; ?>
    </form>
</div>

<div class="card">
    <h2>✈️ All Flights</h2>
    <table>
        <thead>
            <tr>
                <th>Flight ID</th>
                <th>Date</th>
                <th>Time</th>
                <th>Route</th>
                <th>Passengers</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($conn, "
                SELECT f.*, COUNT(b.fid) as passenger_count 
                FROM Flight f 
                LEFT JOIN Booking b ON f.fid = b.fid 
                GROUP BY f.fid 
                ORDER BY f.fdate DESC
            ");
            while ($row = mysqli_fetch_assoc($result)):
            ?>
            <tr>
                <td><strong><?php echo $row['fid']; ?></strong></td>
                <td><?php echo $row['fdate']; ?></td>
                <td><?php echo $row['time']; ?></td>
                <td>
                    <span style="color: #1e3a5f; font-weight: bold;"><?php echo $row['src']; ?></span>
                    ✈️
                    <span style="color: #28a745; font-weight: bold;"><?php echo $row['dest']; ?></span>
                </td>
                <td><span class="badge badge-male"><?php echo $row['passenger_count']; ?></span></td>
                <td>
                    <a href="flights.php?edit=<?php echo $row['fid']; ?>" class="btn btn-warning" style="padding: 5px 10px;">Edit</a>
                    <a href="flights.php?delete=<?php echo $row['fid']; ?>" class="btn btn-danger" style="padding: 5px 10px;" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
