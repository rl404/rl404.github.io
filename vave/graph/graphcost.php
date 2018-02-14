<?php

// Select all supplier
$selectSql = "SELECT * FROM vave where YEAR(proposerDate)='$graphyear' order by model,manufacturerNo";
$selectResult = $conn->query($selectSql);

$vave = array();
$vaveIndex = 0;
$currentModel = '';

while($row = mysqli_fetch_assoc($selectResult)) {
    if($currentModel != $row['model']){
        $currentModel = $row['model'];

        $vave[$vaveIndex][0] = $currentModel;

        $selectSql2 = "SELECT * FROM vave where model='$currentModel' and YEAR(proposerDate)='$graphyear' order by manufacturerNo";
        $selectResult2 = $conn->query($selectSql2);
        
        $currentManuc = '';
        while($row2 = mysqli_fetch_assoc($selectResult2)) {

            // if(empty($row2['manufacturerNo'])) $row2['manufacturerNo'] = "empty";

            if($currentManuc != $row2['manufacturerNo']){                
                $vave[$vaveIndex][1] += $row2['costReduction'];
                $currentManuc = $row2['manufacturerNo'];
            }
        }       

        $vaveIndex++;
    }
}

$rows = array();

//flag is not needed
$flag = true;
$table = array();

$table['cols'] = array(
    array('label' => 'Model', 'type' => 'string'),
    array('label' => 'Cost Reduction', 'type' => 'number')
);

$rows = array();
for($i=0; $i<$vaveIndex; $i++){
    $vaveModel = $vave[$i][0];
    $vaveProp = $vave[$i][1];

    $temp = array();
    // the following line will be used to slice the Pie chart
    $temp[] = array('v' => (string) $vaveModel); 

    // Values of each slice
    $temp[] = array('v' => (int) $vaveProp); 
    $rows[] = array('c' => $temp);
}

$table['rows'] = $rows;

$jsonTable = json_encode($table);

echo "
<script type=\"text/javascript\">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        // Create our data table out of JSON data loaded from server.
        var data = new google.visualization.DataTable($jsonTable);

        var view = new google.visualization.DataView(data);

        view.setColumns([0,1,
                       { 'calc': 'stringify',
                         'sourceColumn': 1,
                         'type': 'string',
                         'role': 'annotation' }
                        ]);

        var options = {
            title: 'Total Cost Reduction / Vehicle',
            backgroundColor: '#fafaff',
            bar: {groupWidth: '95%'},
            annotations: {textStyle: {color: '#5b4421'}},
            hAxis: {textStyle: {color: '#5b4421'}},
            vAxis: {textStyle: {color: '#5b4421'}},
            legend: { position: 'none' }
        };

        // Instantiate and draw our chart, passing in some options.
        // Do not forget to check your div ID
        var chart = new google.visualization.ColumnChart(document.getElementById('graphcost'));

        chart.draw(view, options);
    }
</script>";
?>

