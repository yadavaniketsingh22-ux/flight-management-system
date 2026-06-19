-- ============================================================
-- SAGAR INSTITUTE OF RESEARCH AND TECHNOLOGY
-- Department of Computer Science and Information Technology
-- CSIT-405 DBMS - Passenger Flight Booking System
-- Designed by: Aniket Singh Yadav
-- ============================================================

-- ============================================================
-- DATABASE SETUP
-- ============================================================

DROP DATABASE IF EXISTS flight_booking_db;
CREATE DATABASE flight_booking_db;
USE flight_booking_db;

-- ============================================================
-- CREATE TABLES
-- ============================================================

-- 1. Passenger Table
CREATE TABLE Passenger (
    pid VARCHAR(10) PRIMARY KEY,
    pname VARCHAR(50) NOT NULL,
    pgender VARCHAR(10) NOT NULL,
    pcity VARCHAR(50) NOT NULL
);

-- 2. Agency Table
CREATE TABLE Agency (
    aid VARCHAR(10) PRIMARY KEY,
    aname VARCHAR(50) NOT NULL,
    acity VARCHAR(50) NOT NULL
);

-- 3. Flight Table
CREATE TABLE Flight (
    fid VARCHAR(10) PRIMARY KEY,
    fdate DATE NOT NULL,
    time TIME NOT NULL,
    src VARCHAR(50) NOT NULL,
    dest VARCHAR(50) NOT NULL
);

-- 4. Booking Table
CREATE TABLE Booking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pid VARCHAR(10),
    aid VARCHAR(10),
    fid VARCHAR(10),
    fdate DATE NOT NULL,
    FOREIGN KEY (pid) REFERENCES Passenger(pid) ON DELETE CASCADE,
    FOREIGN KEY (aid) REFERENCES Agency(aid) ON DELETE CASCADE,
    FOREIGN KEY (fid) REFERENCES Flight(fid) ON DELETE CASCADE
);

-- ============================================================
-- INSERT DATA
-- ============================================================

-- Passengers (10 Records)
INSERT INTO Passenger (pid, pname, pgender, pcity) VALUES
('101', 'Aman Sharma', 'Male', 'Bhopal'),
('102', 'Priya Verma', 'Female', 'Delhi'),
('103', 'Rohit Singh', 'Male', 'Chennai'),
('104', 'Sneha Jain', 'Female', 'Mumbai'),
('105', 'Akash Patel', 'Male', 'Indore'),
('106', 'Neha Gupta', 'Female', 'Bhopal'),
('107', 'Vikas Kumar', 'Male', 'Delhi'),
('108', 'Anjali Mehta', 'Female', 'Chennai'),
('109', 'Raj Malhotra', 'Male', 'Mumbai'),
('110', 'Arjun Saxena', 'Male', 'Bhopal');

-- Agencies (7 Records)
INSERT INTO Agency (aid, aname, acity) VALUES
('201', 'Jet', 'Bhopal'),
('202', 'AirIndia', 'Delhi'),
('203', 'Indigo', 'Chennai'),
('204', 'SpiceJet', 'Mumbai'),
('205', 'GoFirst', 'Indore'),
('206', 'Vistara', 'Bhopal'),
('207', 'Akasa', 'Delhi');

-- Flights (10 Records)
INSERT INTO Flight (fid, fdate, time, src, dest) VALUES
('301', '2020-11-05', '10:00:00', 'Bhopal', 'Chennai'),
('302', '2020-11-04', '12:00:00', 'Chennai', 'New Delhi'),
('303', '2020-12-01', '16:00:00', 'Mumbai', 'Delhi'),
('304', '2020-12-02', '16:00:00', 'Mumbai', 'Delhi'),
('305', '2020-11-03', '09:00:00', 'Delhi', 'Chennai'),
('306', '2020-11-06', '18:00:00', 'Bhopal', 'Mumbai'),
('307', '2020-12-01', '16:00:00', 'Chennai', 'New Delhi'),
('308', '2020-12-02', '16:00:00', 'Chennai', 'New Delhi'),
('309', '2020-11-07', '08:00:00', 'Indore', 'Delhi'),
('310', '2020-11-08', '14:00:00', 'Delhi', 'Bhopal');

-- Bookings (13 Records)
INSERT INTO Booking (pid, aid, fid, fdate) VALUES
('110', '201', '301', '2020-11-05'),
('110', '201', '302', '2020-11-04'),
('101', '201', '303', '2020-12-01'),
('102', '202', '304', '2020-12-02'),
('103', '203', '305', '2020-11-03'),
('104', '204', '306', '2020-11-06'),
('105', '205', '307', '2020-12-01'),
('106', '206', '308', '2020-12-02'),
('107', '207', '309', '2020-11-07'),
('108', '203', '310', '2020-11-08'),
('109', '204', '303', '2020-12-01'),
('110', '201', '307', '2020-12-01'),
('110', '201', '308', '2020-12-02');

-- ============================================================
-- 30 SQL QUERIES
-- ============================================================

-- Query 1: Get complete details of all flights to New Delhi
SELECT * FROM Flight WHERE dest = 'New Delhi';

-- Query 2: Get details about all flights from Chennai to New Delhi
SELECT * FROM Flight WHERE src = 'Chennai' AND dest = 'New Delhi';

-- Query 3: Find flight numbers for passenger with pid 110 for flights to Chennai before 06/11/2020
SELECT f.fid FROM Booking b JOIN Flight f ON b.fid = f.fid 
WHERE b.pid = '110' AND f.dest = 'Chennai' AND f.fdate < '2020-11-06';

-- Query 4: Find passenger names who have bookings on at least one flight
SELECT DISTINCT p.pname FROM Passenger p JOIN Booking b ON p.pid = b.pid;

-- Query 5: Find passenger names who do not have any bookings
SELECT p.pname FROM Passenger p WHERE p.pid NOT IN (SELECT DISTINCT pid FROM Booking);

-- Query 6: Find agency names located in same city as passenger 110
SELECT a.aname FROM Agency a WHERE a.acity = (SELECT pcity FROM Passenger WHERE pid = '110');

-- Query 7: Get flights scheduled on both 01/12/2020 and 02/12/2020 at 16:00
SELECT f1.* FROM Flight f1
WHERE f1.time = '16:00:00' AND f1.fdate = '2020-12-01'
AND EXISTS (SELECT 1 FROM Flight f2 WHERE f2.src = f1.src AND f2.dest = f1.dest 
AND f2.time = '16:00:00' AND f2.fdate = '2020-12-02');

-- Query 8: Get flights on either 01/12/2020 or 02/12/2020 at 16:00
SELECT * FROM Flight WHERE fdate IN ('2020-12-01', '2020-12-02') AND time = '16:00:00';

-- Query 9: Find agencies who do not have bookings for passenger 110
SELECT a.aname FROM Agency a WHERE a.aid NOT IN (SELECT b.aid FROM Booking b WHERE b.pid = '110');

-- Query 10: Find male passengers associated with Jet agency
SELECT DISTINCT p.* FROM Passenger p 
JOIN Booking b ON p.pid = b.pid 
JOIN Agency a ON b.aid = a.aid 
WHERE p.pgender = 'Male' AND a.aname = 'Jet';

-- Query 11: Find passengers who booked more than one flight
SELECT p.pname, COUNT(b.fid) AS flight_count FROM Passenger p 
JOIN Booking b ON p.pid = b.pid 
GROUP BY p.pid, p.pname HAVING COUNT(b.fid) > 1;

-- Query 12: Find agency with maximum bookings
SELECT a.aname, COUNT(*) AS booking_count FROM Agency a 
JOIN Booking b ON a.aid = b.aid 
GROUP BY a.aid, a.aname ORDER BY booking_count DESC LIMIT 1;

-- Query 13: Find passengers who booked through agencies in different cities
SELECT DISTINCT p.pname FROM Passenger p 
JOIN Booking b ON p.pid = b.pid 
JOIN Agency a ON b.aid = a.aid 
WHERE a.acity != p.pcity;

-- Query 14: Find flights with more than 5 passengers
SELECT f.fid, f.src, f.dest, COUNT(b.pid) AS passenger_count FROM Flight f 
JOIN Booking b ON f.fid = b.fid 
GROUP BY f.fid, f.src, f.dest HAVING COUNT(b.pid) > 5;

-- Query 15: Find passenger who booked the earliest flight
SELECT p.pname, f.fdate, f.time FROM Passenger p 
JOIN Booking b ON p.pid = b.pid 
JOIN Flight f ON b.fid = f.fid 
ORDER BY f.fdate, f.time LIMIT 1;

-- Query 16: Find passengers who booked flights to more than one destination
SELECT p.pname, COUNT(DISTINCT f.dest) AS destinations FROM Passenger p 
JOIN Booking b ON p.pid = b.pid 
JOIN Flight f ON b.fid = f.fid 
GROUP BY p.pid, p.pname HAVING COUNT(DISTINCT f.dest) > 1;

-- Query 17: Find agencies that never handled any booking
SELECT a.aname FROM Agency a WHERE a.aid NOT IN (SELECT DISTINCT aid FROM Booking);

-- Query 18: Find flights that have no bookings
SELECT f.* FROM Flight f WHERE f.fid NOT IN (SELECT DISTINCT fid FROM Booking);

-- Query 19: Find passengers who booked all available flights
SELECT p.pname FROM Passenger p 
WHERE (SELECT COUNT(DISTINCT fid) FROM Booking WHERE pid = p.pid) = (SELECT COUNT(*) FROM Flight);

-- Query 20: Find most frequently traveled destination
SELECT f.dest, COUNT(*) AS travel_count FROM Flight f 
JOIN Booking b ON f.fid = b.fid 
GROUP BY f.dest ORDER BY travel_count DESC LIMIT 1;

-- Query 21: Find passengers who booked flights on consecutive dates
SELECT DISTINCT p.pname FROM Passenger p 
JOIN Booking b1 ON p.pid = b1.pid 
JOIN Booking b2 ON p.pid = b2.pid 
WHERE DATEDIFF(b2.fdate, b1.fdate) = 1;

-- Query 22: Find total passengers from each source city
SELECT f.src, COUNT(DISTINCT b.pid) AS passenger_count FROM Flight f 
JOIN Booking b ON f.fid = b.fid 
GROUP BY f.src ORDER BY passenger_count DESC;

-- Query 23: Find agencies that booked for both male and female passengers
SELECT a.aname FROM Agency a 
JOIN Booking b ON a.aid = b.aid 
JOIN Passenger p ON b.pid = p.pid 
GROUP BY a.aid, a.aname HAVING COUNT(DISTINCT p.pgender) = 2;

-- Query 24: Find flight with highest bookings
SELECT f.fid, f.src, f.dest, COUNT(*) AS booking_count FROM Flight f 
JOIN Booking b ON f.fid = b.fid 
GROUP BY f.fid, f.src, f.dest ORDER BY booking_count DESC LIMIT 1;

-- Query 25: Find passengers who booked only through one agency
SELECT p.pname, COUNT(DISTINCT b.aid) AS agency_count FROM Passenger p 
JOIN Booking b ON p.pid = b.pid 
GROUP BY p.pid, p.pname HAVING COUNT(DISTINCT b.aid) = 1;

-- Query 26: Find agencies with bookings greater than average
SELECT a.aname, COUNT(*) AS booking_count FROM Agency a 
JOIN Booking b ON a.aid = b.aid 
GROUP BY a.aid, a.aname 
HAVING COUNT(*) > (SELECT AVG(cnt) FROM (SELECT COUNT(*) AS cnt FROM Booking GROUP BY aid) AS avg_bookings);

-- Query 27: Find passengers who never traveled to New Delhi
SELECT p.pname FROM Passenger p 
WHERE p.pid NOT IN (SELECT b.pid FROM Booking b JOIN Flight f ON b.fid = f.fid WHERE f.dest = 'New Delhi');

-- Query 28: Find number of bookings on each date
SELECT fdate, COUNT(*) AS booking_count FROM Booking GROUP BY fdate ORDER BY fdate;

-- Query 29: Find passengers whose names start with 'A'
SELECT * FROM Passenger WHERE pname LIKE 'A%';

-- Query 30: Find flights where source and destination are different
SELECT * FROM Flight WHERE src != dest;

-- ============================================================
-- USEFUL VIEWS
-- ============================================================

-- View: Complete Booking Details
CREATE OR REPLACE VIEW vw_booking_details AS
SELECT b.fdate AS booking_date, p.pname, p.pgender, p.pcity,
       a.aname AS agency, a.acity AS agency_city,
       f.fid, f.src, f.dest, f.time
FROM Booking b
JOIN Passenger p ON b.pid = p.pid
JOIN Agency a ON b.aid = a.aid
JOIN Flight f ON b.fid = f.fid;

-- View: Agency Performance
CREATE OR REPLACE VIEW vw_agency_stats AS
SELECT a.aid, a.aname, a.acity,
       COUNT(DISTINCT b.pid) AS total_passengers,
       COUNT(*) AS total_bookings
FROM Agency a
LEFT JOIN Booking b ON a.aid = b.aid
GROUP BY a.aid, a.aname, a.acity;

-- View: Flight Summary
CREATE OR REPLACE VIEW vw_flight_summary AS
SELECT f.fid, f.src, f.dest, f.fdate, f.time,
       COUNT(b.pid) AS passengers_booked
FROM Flight f
LEFT JOIN Booking b ON f.fid = b.fid
GROUP BY f.fid, f.src, f.dest, f.fdate, f.time;

-- ============================================================
-- VERIFY DATABASE
-- ============================================================

SELECT 'Passenger' AS TableName, COUNT(*) AS Records FROM Passenger
UNION ALL SELECT 'Agency', COUNT(*) FROM Agency
UNION ALL SELECT 'Flight', COUNT(*) FROM Flight
UNION ALL SELECT 'Booking', COUNT(*) FROM Booking;

SELECT '✅ Database setup completed successfully!' AS Status;

-- ============================================================
-- HOW TO USE:
-- 1. Open XAMPP Control Panel
-- 2. Start Apache and MySQL
-- 3. Open http://localhost/phpmyadmin
-- 4. Click Import -> Choose this file -> Click Go
-- ============================================================
