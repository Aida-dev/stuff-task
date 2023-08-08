<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "staff";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getSeptemberReport($staffId) {
    global $conn;

    $sql = "SELECT DATE(s.start) AS date,
                   MIN(s.start) AS start,
                   MAX(s.end) AS end,
                   SUM(w.id = 1) AS check_ins,
                   SUM(w.id = 2) AS general_cleanings,
                   SUM(w.id = 3) AS current_cleanings,
                   SUM(p.price + IF(s.bed = 1, 30, 0) + IF(s.towels = 1, 10, 0)) AS total_income
            FROM statistics AS s
            JOIN rooms AS r ON s.room = r.id
            JOIN prices AS p ON r.type = p.room_type AND s.work = p.work
            JOIN works AS w ON s.work = w.id
            WHERE s.staff = ? AND MONTH(s.start) = 9
            GROUP BY DATE(s.start)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $staffId);
    $stmt->execute();
    $result = $stmt->get_result();

    $reportData = array();

    while ($row = $result->fetch_assoc()) {
        $reportData[] = $row;
    }

    return $reportData;
}

function getDailyReport($selectedDate) {
    global $conn;

    $sql = "SELECT r.num AS room_number, CONCAT(b.name, '-', r.type) AS room_category,
                   t.name AS cleaning_type, s.start, s.end,
                   (p.price + IF(s.bed = 1, 30, 0) + IF(s.towels = 1, 10, 0)) AS total_price
            FROM statistics AS s
            JOIN rooms AS r ON s.room = r.id
            JOIN prices AS p ON r.type = p.room_type AND s.work = p.work
            JOIN builds AS b ON r.build = b.id
            JOIN works AS t ON s.work = t.id
            WHERE DATE(s.start) = ?
            ORDER BY r.num";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $selectedDate);
    $stmt->execute();
    $result = $stmt->get_result();

    $dailyReportData = array();

    while ($row = $result->fetch_assoc()) {
        $dailyReportData[] = $row;
    }

    return $dailyReportData;
}


?>
