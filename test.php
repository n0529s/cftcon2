<?php 
    try {
            $pdo = new PDO(
                'mysql:dbname=xxx;host=localhost;charset=utf8',
                'xxx',
                'xxx',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES =>false
                ]
            );
            $sql = "SELECT age,count(age_id) FROM age_data
                    RIGHT OUTER JOIN age on age.id = age_data.age_id
                    GROUP BY age
                    ORDER BY age.id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
        } catch (PDOException $e) {
            header('Content-Type: text/plain; charset=UTF-8', true, 500);
            exit($e->getMessage()); 
        }
        header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>example2</title>
    </head>
    <body>
        
            <div class="chart-container" style="position: relative; height:40vh; width:60vw">
                <canvas id="myChart" ></canvas>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
                <script>
                    var ctx = document.getElementById('myChart').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: [<?php foreach($result as $row){
                                            echo '"'.($row["age"]).'",';
                                     } ?>],
                            datasets: [{
                                label: '年齢',
                                data: [<?php foreach($result as $row){
                                            echo $row["count(age_id)"].",";
                                       } ?>],
                                backgroundColor: 
                                    'rgba(255, 99, 132, 0.2)',
                                borderColor: 
                                    'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {     
                                        beginAtZero: true,
                                        max: 10
                                    }
                                }]
                            }
                        }
                    });
                </script>
            </div>
      
    </body>
</html>