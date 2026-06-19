<?php
include 'config.php';
include 'header.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete']);
    mysqli_query($conn, "DELETE FROM Booking WHERE id = '$id'");
    echo '<div class="alert alert-success">Booking deleted successfully!</div>';
}

// Handle Add
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pid = mysqli_real_escape_string($conn, $_POST['pid']);
    $aid = mysqli_real_escape_string($conn, $_POST['aid']);
    $fid = mysqli_real_escape_string($conn, $_POST['fid']);
    $fdate = mysqli_real_escape_string($conn, $_POST['fdate']);
    
    $sql = "INSERT INTO Booking (pid, aid, fid, fdate) VALUES ('$pid', '$aid', '$fid', '$fdate')";
    
    if (mysqli_query($conn, $sql)) {
        echo '<div class="alert alert-success">Booking added successfully!</div>';
    } else {
        echo '<div class="alert alert-danger">Error: '.mysqli_error($conn).'</div>';
    }
}

// Get passengers, agencies, flights for dropdowns
$passengers = mysqli_query($conn, "SELECT * FROM Passenger ORDER BY pname");
$agencies = mysqli_query($conn, "SELECT * FROM Agency ORDER BY aname");
$flights = mysqli_query($conn, "SELECT * FROM Flight ORDER BY fdate");
?>

<div class="card">
    <h2>➕ Add New Booking</h2>
    <form method="POST" action="">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
            <div class="form-group">
                <label>Passenger</label>
                <select name="pid" required>
                    <option value="">Select Passenger</option>
                    <?php while ($p = mysqli_fetch_assoc($passengers)): ?>
                        <option value="<?php echo $p['pid']; ?>"><?php echo $p['pname']; ?> (<?php echo $p['pid']; ?>)</option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Agency</label>
                <select name="aid" required>
                    <option value="">Select Agency</option>
                    <?php while ($a = mysqli_fetch_assoc($agencies)): ?>
                        <option value="<?php echo $a['aid']; ?>"><?php echo $a['aname']; ?> (<?php echo $a['acity']; ?>)</option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Flight</label>
                <select name="fid" required>
                    <option value="">Select Flight</option>
                    <?php while ($f = mysqli_fetch_assoc($flights)): ?>
                        <option value="<?php echo $f['fid']; ?>"><?php echo $f['fid']; ?> - <?php echo $f['src']; ?> to <?php echo $f['dest']; ?> (<?php echo $f['fdate']; ?>)</option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Booking Date</label>
                <input type="date" name="fdate" required>
            </div>
        </div>
        <button type="submit" class="btn btn-success" style="margin-top: 15px;">Add Booking</button>
    </form>
</div>

<div class="card">
    <h2>📋 All Bookings</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Passenger</th>
                <th>Agency</th>
                <th>Flight</th>
                <th>Route</th>
                <th>Booking Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($conn, "
                SELECT b.*, p.pname, p.pgender, a.aname, f.src, f.dest, f.time
                FROM Booking b
                JOIN Passenger p ON b.pid = p.pid
                JOIN Agency a ON b.aid = a.aid
                JOIN Flight f ON b.fid = f.fid
                ORDER BY b.fdate DESC
            ");
            $count = 0;
            while ($row = mysqli_fetch_assoc($result)):
            $count++;
            ?>
            <tr>
                <td><?php echo $count; ?></td>
                <td>
                    <span class="badge <?php echo $row['pgender'] == 'Male' ? 'badge-male' : 'badge-female'; ?>">
                        <?php echo $row['pgender'] == 'Male' ? '👨' : '👩'; ?>
                    </span>
                    <?php echo $row['pname']; ?>
                </td>
                <td><strong><?php echo $row['aname']; ?></strong></td>
                <td><?php echo $row['fid']; ?></td>
                <td><?php echo $row['src']; ?> ✈️ <?php echo $row['dest']; ?></td>
                <td><?php echo $row['fdate']; ?></td>
                <td>
                    <a href="bookings.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger" style="padding: 5px 10px;" onclick="return confirm('Are you sure?')">Cancel</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
