<!DOCTYPE html>
<html>
<head>
    <title>Отчёт за сентябрь</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="./Assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("body").on("click", ".report-date", function(e) {
                e.preventDefault();
                var selectedDate = $(this).data("date");

                $.ajax({
                    url: "./View/daily_report.php",
                    type: "GET",
                    data: { date: selectedDate },
                    success: function(data) {
                        $("#daily-report-container").html(data);
                        document.getElementById("daily-report-container").scrollIntoView({
                        behavior: "smooth",
                        block: "start"
                        });
                    }
                });
            });
        });
    </script>
</head>
<body>
    <h1 id = 'h1' >Отчёт за сентябрь</h1>
    <?php
        include "./Model/model.php";

        $staffId = 167;
        $septemberReport = getSeptemberReport($staffId);

        if (!empty($septemberReport)) {
            echo "<table class = 'table table-dark' >";
            echo "<tr><th>Дата</th><th>Начало рабочего дня</th><th>Конец рабочего дня</th><th>Кол-во ген. уборок</th><th>Кол-во тек. уборок</th><th>Кол-во заездов</th><th>Сумма оплаты</th></tr>";

            $totalSum = 0;

            foreach ($septemberReport as $row) {
                echo "<tr>";
                echo "<td><a href='#' class='report-date' data-date='{$row['date']}'>{$row['date']}</a></td>";
                echo "<td>{$row['start']}</td>";
                echo "<td>{$row['end']}</td>";
                echo "<td>{$row['general_cleanings']}</td>";
                echo "<td>{$row['current_cleanings']}</td>";
                echo "<td>{$row['check_ins']}</td>";
                echo "<td>{$row['total_income']}</td>";
                echo "</tr>";

                $totalSum += $row['total_income'];
            }

            echo "</table>";

            echo "<p  class = 'total-price'>Итоговая сумма за сентябрь: $totalSum руб.</p>";
        } else {
            echo "Результатов не найдено.";
        }
    ?>

    <div  id="daily-report-container">
       
    </div>
</body>
</html>
