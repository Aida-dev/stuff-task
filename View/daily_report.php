<?php
include "../Model/model.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="../Assets/css/style.css">
    <title></title>
</head>
<body>
    <?php
if (isset($_GET['date'])) {
    $selectedDate = $_GET['date'];

    $dailyReport = getDailyReport($selectedDate);

    if (!empty($dailyReport)) {
        echo "<h1>Отчёт за выбранный день</h1>";
        echo "<table class = 'table table-dark'>";
        echo "<tr><th>Номер</th><th>Категория номера</th><th>Тип уборки</th><th>Начало уборки</th><th>Конец уборки</th><th>Сумма за уборку</th></tr>";

        $totalDayIncome = 0;

        foreach ($dailyReport as $row) {
            echo "<tr>";
            echo "<td>{$row['room_number']}</td>";
            echo "<td>{$row['room_category']}</td>";
            echo "<td>{$row['cleaning_type']}</td>";
            echo "<td>{$row['start']}</td>";
            echo "<td>{$row['end']}</td>";
            echo "<td>{$row['total_price']}</td>";
            echo "</tr>";

            $totalDayIncome += $row['total_price'];
        }

        echo "</table>";
        echo "<div class= 'up'>";

        echo "<a class = 'btn btn-primary'  href = '#h1' >Вверх</a>";
        echo "</div>";

        echo "<p class = 'total-price'>Итоговая сумма за день: $totalDayIncome руб.</p>";
    } else {
        echo "Результатов не найдено.";
    }
}
?>
</body>
</html>

