<?php
require("../base_config.php");
require(BASE_DOC."/header.php");
require("user_validator.php");

$month = date('m');
$year = date('Y');
if (isset($_POST['month']) && isset($_POST['year'])) {
    $month = $_POST['month'];
    $year = $_POST['year'];
}
$clinic_id = $_SESSION['user']['clinic_id'];
$status = array('reject', 'consult', 'queue', 'done');
$output_data = "[";
for ($i=0; $i<sizeof($status); $i++) {
    $stat = $status[$i];
    $sql = "SELECT COUNT(b.b_id) AS count_id
            FROM bookings b
            WHERE MONTH(b.b_datetime) = '$month'
            AND YEAR(b.b_datetime) = '$year'
            AND b.clinic_id = '$clinic_id'
            AND b.b_status = '$stat'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $output_data .= $row['count_id'];
        if ($i != (sizeof($status)-1)) {
            $output_data .= ", ";
        }
    }
}
$output_data .= "]";
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.js" integrity="sha256-8zyeSXm+yTvzUN1VgAOinFgaVFEFTyYzWShOy9w7WoQ=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js" integrity="sha256-TQq84xX6vkwR0Qs1qH5ADkP+MvH0W+9E7TdHJsoIQiM=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.css" integrity="sha256-IvM9nJf/b5l2RoebiFno92E5ONttVyaEEsdemDC6iQA=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js" integrity="sha256-nZaxPHA2uAaquixjSDX19TmIlbRNCOrf5HO1oHl5p70=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" integrity="sha256-aa0xaJgmK/X74WM224KMQeNQC2xYKwlAt08oZqjeF0E=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>

<div class="container" style="padding-top: 1%;">
    <div class="row card">
        <div class="col-md-10 offset-1 card-body">
            <center>

                <?php require("nav_items.php"); ?>

                <h3>Report</h3>

                <div class="row card">
                    <div class="col-md-12 card-body">
                        <form method="POST" action="report.php">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>Month</td>
                                        <td width="40px" align="center">:</td>
                                        <td>
                                            <select name="month" class="form-control">
                                                <?php for ($m=1; $m<=12; $m++) { ?>
                                                <option value="<?=$m ?>" <?php if ($m==$month) { echo "selected"; } ?>><?=$m ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td width="100px">&nbsp;</td>
                                        <td>Year</td>
                                        <td width="40px" align="center">:</td>
                                        <td>
                                            <select name="year" class="form-control">
                                                <?php for ($y=date('Y'); $y>=date('Y')-10; $y--) { ?>
                                                <option value="<?=$y ?>" <?php if ($y==$year) { echo "selected"; } ?>><?=$y ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td width="100px">&nbsp;</td>
                                        <td>
                                            <button type="submit" class="btn btn-primary">Search</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 offset-3">
                        <canvas id="myChart" width="400" height="400"></canvas>
                        <script>
                        var ctx = document.getElementById('myChart').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ['Reject', 'Consult', 'Queue', 'Done'],
                                datasets: [{
                                    label: '# of Votes',
                                    data: <?=$output_data ?>,
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 206, 86, 0.2)',
                                        'rgba(75, 192, 192, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(75, 192, 192, 1)'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                            }
                        });
                        </script>
                    </div>
                </div>

            </center>
        </div>
    </div>
</div>
