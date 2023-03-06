<?php
include_once "controller/sales_controller.php";
// Retrieve data from the database
// ...
$sales = new SalesController();
$item = $sales->getItem();
$charts=$sales->getChats();
// var_dump($chats);
// Prepare data for the chart
$labels = []; // Array of labels for each bar
$totalBalances = []; // Array of total balances for each bar
$bestSellingProducts = []; // Array of best-selling products for each bar

foreach ($charts as $row) {
    $labels[] = $row['month'] . '/' . $row['year'];
    $totalBalances[] = $row['total'];
    $bestSellingProducts[] = $row['count'];
}
 //var_dump($bestSellingProducts);

?>
<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="col-md-4">
            <select name="year" id="year" class="form-control">
                <option value="">Choose Year</option>
                <?php
                for($year=2015;$year<=date(2115);$year++){
                    if($_POST['year']==$year)
                    echo "<option value='".$year."' selected>".$year."</option>";
                    else
                    echo "<option value='".$year."'>".$year."</option>";

                }

                ?>
            </select>
          </div>
   <canvas id="myChart" width="500" height="600"></canvas>
   
   
    <script>
        let total = <?php echo json_encode($totalBalances); ?>;
        let bestSell = <?php echo json_encode($bestSellingProducts); ?>;

        let month = ['Jan','Feb','March','April','May','June','July','Aug','Sep','Oct','Nov','Dec'];
        console.log(bestSell);
        var ctx = document.getElementById('myChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: month,
                datasets: [{
                    label: 'Total Balance',
                    data: total,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }, {
                    label: 'Best-Selling Products',
                    data: bestSell,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                }]
            },
            options: {
                responsive:false,
                maintainAspectRatio:false,
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMin: 50,
                    }
                }
            }
        });
        // chart.update();
    </script>
</body>
</html>
