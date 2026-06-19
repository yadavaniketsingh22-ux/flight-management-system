<?php
include 'config.php';
include 'header.php';

// Get counts
$passengers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM Passenger"))['count'];
$agencies = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM Agency"))['count'];
$flights = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM Flight"))['count'];
$bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM Booking"))['count'];
?>

<div class="card">
    <h2>🏠 Welcome to Flight Booking System</h2>
    <p style="font-size: 18px; color: #666; margin-bottom: 20px;">
        A comprehensive web-based application for managing passenger flight booking operations through travel agencies.
    </p>
    <p><strong>Designed by:</strong> Aniket Singh Yadav</p>
    <p><strong>Department:</strong> Computer Science & Information Technology</p>
    <p><strong>Institution:</strong> Sagar Institute of Research & Technology</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h3><?php echo $passengers; ?></h3>
        <p>👥 Passengers</p>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #28a745, #20c997);">
        <h3><?php echo $agencies; ?></h3>
        <p>🏢 Agencies</p>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #6f42c1, #e83e8c);">
        <h3><?php echo $flights; ?></h3>
        <p>✈️ Flights</p>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #fd7e14, #ffc107);">
        <h3><?php echo $bookings; ?></h3>
        <p>📋 Bookings</p>
    </div>
</div>

<div class="card">
    <h2>🎯 System Objectives</h2>
    <ul style="list-style: none; padding: 0;">
        <li style="padding: 10px 0; border-bottom: 1px solid #eee;">✅ Maintain passenger information</li>
        <li style="padding: 10px 0; border-bottom: 1px solid #eee;">✅ Manage travel agency details</li>
        <li style="padding: 10px 0; border-bottom: 1px solid #eee;">✅ Store flight schedule records</li>
        <li style="padding: 10px 0; border-bottom: 1px solid #eee;">✅ Perform passenger bookings through agencies</li>
        <li style="padding: 10px 0; border-bottom: 1px solid #eee;">✅ Search flights based on source, destination, and date</li>
        <li style="padding: 10px 0; border-bottom: 1px solid #eee;">✅ Generate booking and passenger reports</li>
        <li style="padding: 10px 0;">✅ Demonstrate SQL operations in real-time applications</li>
    </ul>
</div>

<div class="card">
    <h2>📦 System Modules</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 20px;">
        <div style="background: #e3f2fd; padding: 20px; border-radius: 10px;">
            <h3 style="color: #1565c0;">👥 Passenger Module</h3>
            <ul style="margin-top: 10px; margin-left: 20px; color: #555;">
                <li>Add new passenger</li>
                <li>Update passenger details</li>
                <li>Search passenger records</li>
                <li>View booking history</li>
            </ul>
        </div>
        <div style="background: #e8f5e9; padding: 20px; border-radius: 10px;">
            <h3 style="color: #2e7d32;">🏢 Agency Module</h3>
            <ul style="margin-top: 10px; margin-left: 20px; color: #555;">
                <li>Add agency details</li>
                <li>Manage agency locations</li>
                <li>Handle passenger bookings</li>
            </ul>
        </div>
        <div style="background: #f3e5f5; padding: 20px; border-radius: 10px;">
            <h3 style="color: #7b1fa2;">✈️ Flight Module</h3>
            <ul style="margin-top: 10px; margin-left: 20px; color: #555;">
                <li>Add flight information</li>
                <li>Update flight timings</li>
                <li>Search flights</li>
                <li>View routes</li>
            </ul>
        </div>
        <div style="background: #fff3e0; padding: 20px; border-radius: 10px;">
            <h3 style="color: #e65100;">📋 Booking Module</h3>
            <ul style="margin-top: 10px; margin-left: 20px; color: #555;">
                <li>Book tickets</li>
                <li>Cancel bookings</li>
                <li>View booking records</li>
                <li>Generate reports</li>
            </ul>
        </div>
    </div>
</div>

<div class="card">
    <h2>🛠️ Technologies Used</h2>
    <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-top: 15px;">
        <span style="background: #1e3a5f; color: white; padding: 10px 20px; border-radius: 25px;">HTML</span>
        <span style="background: #2196f3; color: white; padding: 10px 20px; border-radius: 25px;">CSS</span>
        <span style="background: #f7df1e; color: black; padding: 10px 20px; border-radius: 25px;">JavaScript</span>
        <span style="background: #777bb3; color: white; padding: 10px 20px; border-radius: 25px;">PHP</span>
        <span style="background: #00758f; color: white; padding: 10px 20px; border-radius: 25px;">MySQL</span>
        <span style="background: #fb7a24; color: white; padding: 10px 20px; border-radius: 25px;">XAMPP</span>
    </div>
</div>

<?php include 'footer.php'; ?>
