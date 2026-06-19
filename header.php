<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIRT - Flight Booking System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .navbar {
            background: #1e3a5f;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        .navbar .logo {
            color: white;
            font-size: 24px;
            font-weight: bold;
        }
        .navbar .logo span {
            color: #ffd700;
        }
        .navbar nav a {
            color: white;
            text-decoration: none;
            margin-left: 25px;
            padding: 8px 16px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .navbar nav a:hover, .navbar nav a.active {
            background: #ffd700;
            color: #1e3a5f;
        }
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        .card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .card h2 {
            color: #1e3a5f;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #ffd700;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        table th {
            background: #1e3a5f;
            color: white;
        }
        table tr:hover {
            background: #f5f5f5;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #1e3a5f;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #2c5282;
        }
        .btn-success { background: #28a745; }
        .btn-success:hover { background: #218838; }
        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }
        .btn-warning { background: #ffc107; color: #333; }
        .btn-warning:hover { background: #e0a800; }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        .form-group input:focus, .form-group select:focus {
            border-color: #1e3a5f;
            outline: none;
        }
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: linear-gradient(135deg, #1e3a5f, #2c5282);
            color: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
        }
        .stat-card h3 {
            font-size: 36px;
            margin-bottom: 5px;
        }
        .stat-card p {
            opacity: 0.8;
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge-male { background: #cce5ff; color: #004085; }
        .badge-female { background: #f8d7da; color: #721c24; }
        pre {
            background: #1e3a5f;
            color: #7fff00;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
        }
        .query-card {
            background: #f8f9fa;
            border-left: 4px solid #1e3a5f;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 0 5px 5px 0;
        }
        .query-card h4 {
            color: #1e3a5f;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">✈️ SIRT <span>Flight Booking</span></div>
        <nav>
            <a href="index.php" <?php if(basename($_SERVER['PHP_SELF']) == 'index.php') echo 'class="active"'; ?>>Home</a>
            <a href="passengers.php" <?php if(basename($_SERVER['PHP_SELF']) == 'passengers.php') echo 'class="active"'; ?>>Passengers</a>
            <a href="agencies.php" <?php if(basename($_SERVER['PHP_SELF']) == 'agencies.php') echo 'class="active"'; ?>>Agencies</a>
            <a href="flights.php" <?php if(basename($_SERVER['PHP_SELF']) == 'flights.php') echo 'class="active"'; ?>>Flights</a>
            <a href="bookings.php" <?php if(basename($_SERVER['PHP_SELF']) == 'bookings.php') echo 'class="active"'; ?>>Bookings</a>
            <a href="queries.php" <?php if(basename($_SERVER['PHP_SELF']) == 'queries.php') echo 'class="active"'; ?>>SQL Queries</a>
        </nav>
    </div>
    <div class="container">
