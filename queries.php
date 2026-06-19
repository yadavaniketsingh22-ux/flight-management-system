<?php
include 'config.php';
include 'header.php';

$queries = [
    ["Get all flights to New Delhi", "SELECT * FROM Flight WHERE dest = 'New Delhi'"],
    ["Get flights from Chennai to New Delhi", "SELECT * FROM Flight WHERE src = 'Chennai' AND dest = 'New Delhi'"],
    ["Passengers with at least one booking", "SELECT DISTINCT p.pname FROM Passenger p JOIN Booking b ON p.pid = b.pid"],
    ["Passengers with no bookings", "SELECT p.pname FROM Passenger p WHERE p.pid NOT IN (SELECT DISTINCT pid FROM Booking)"],
    ["Male passengers with Jet agency", "SELECT DISTINCT p.* FROM Passenger p JOIN Booking b ON p.pid = b.pid JOIN Agency a ON b.aid = a.aid WHERE p.pgender = 'Male' AND a.aname = 'Jet'"],
    ["Passengers who booked more than one flight", "SELECT p.pname, COUNT(b.fid) as flights FROM Passenger p JOIN Booking b ON p.pid = b.pid GROUP BY p.pid HAVING COUNT(b.fid) > 1"],
    ["Agency with maximum bookings", "SELECT a.aname, COUNT(*) as bookings FROM Agency a JOIN Booking b ON a.aid = b.aid GROUP BY a.aid ORDER BY bookings DESC LIMIT 1"],
    ["Flights with no bookings", "SELECT f.* FROM Flight f WHERE f.fid NOT IN (SELECT DISTINCT fid FROM Booking)"],
    ["Agencies with no bookings", "SELECT a.aname FROM Agency a WHERE a.aid NOT IN (SELECT DISTINCT aid FROM Booking)"],
    ["Most popular destination", "SELECT f.dest, COUNT(*) as count FROM Flight f JOIN Booking b ON f.fid = b.fid GROUP BY f.dest ORDER BY count DESC LIMIT 1"],
    ["Passengers from each source city", "SELECT f.src, COUNT(DISTINCT b.pid) as passengers FROM Flight f JOIN Booking b ON f.fid = b.fid GROUP BY f.src"],
    ["Bookings per date", "SELECT fdate, COUNT(*) as bookings FROM Booking GROUP BY fdate ORDER BY fdate"],
    ["Passengers starting with 'A'", "SELECT * FROM Passenger WHERE pname LIKE 'A%'"],
    ["Flights where src != dest", "SELECT * FROM Flight WHERE src != dest"],
    ["Complete booking details", "SELECT b.fdate, p.pname, a.aname, f.src, f.dest FROM Booking b JOIN Passenger p ON b.pid = p.pid JOIN Agency a ON b.aid = a.aid JOIN Flight f ON b.fid = f.fid"]
];

// Execute selected query
$selected = isset($_GET['q']) ? (int)$_GET['q'] : -1;
?>

<div class="card">
    <h2>💾 SQL Queries - CSIT-405 DBMS</h2>
    <p>Click on any query to execute and see results</p>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
    <div class="card">
        <h2>📝 Available Queries</h2>
        <?php foreach ($queries as $index => $query): ?>
        <div class="query-card" style="<?php echo $selected == $index ? 'border-left-color: #28a745; background: #e8f5e9;' : ''; ?>">
            <h4><?php echo ($index + 1) . ". " . $query[0]; ?></h4>
            <pre style="font-size: 12px;"><?php echo $query[1]; ?></pre>
            <a href="queries.php?q=<?php echo $index; ?>" class="btn btn-success" style="margin-top: 10px;">Run Query</a>
        </div>
        <?php endforeach; ?>
    </div>
    
    <div class="card" style="position: sticky; top: 100px; height: fit-content;">
        <h2>📊 Query Results</h2>
        <?php if ($selected >= 0 && $selected < count($queries)): ?>
            <div style="background: #e3f2fd; padding: 15px; border-radius: 5px; margin-bottom: 15px;">
                <strong>Query:</strong> <?php echo $queries[$selected][0]; ?>
            </div>
            <pre style="margin-bottom: 15px;"><?php echo $queries[$selected][1]; ?></pre>
            
            <?php
            $result = mysqli_query($conn, $queries[$selected][1]);
            if ($result && mysqli_num_rows($result) > 0):
            ?>
            <table>
                <thead>
                    <tr>
                        <?php
                        $fields = mysqli_fetch_fields($result);
                        foreach ($fields as $field):
                        ?>
                        <th><?php echo $field->name; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <?php foreach ($row as $value): ?>
                        <td><?php echo $value; ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <p style="margin-top: 10px; color: #28a745;"><strong>✅ <?php echo mysqli_num_rows(mysqli_query($conn, $queries[$selected][1])); ?> rows returned</strong></p>
            <?php else: ?>
            <p style="color: #dc3545;">No results found or query error.</p>
            <?php endif; ?>
        <?php else: ?>
            <p style="color: #666; text-align: center; padding: 50px;">
                👈 Select a query from the left to see results
            </p>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
