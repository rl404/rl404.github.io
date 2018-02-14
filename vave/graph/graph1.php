<?php

include "db.php";

// Select all supplier
$selectSql = "SELECT * FROM vave order by model,manufacturerNo";
$selectResult = $conn->query($selectSql);

$vave = array();
$vaveIndex = 0;
$currentModel = '';

while($row = mysqli_fetch_assoc($selectResult)) {
    if($currentModel != $row['model']){
        $currentModel = $row['model'];

        $vave[$vaveIndex][0] = $currentModel;

        $selectSql2 = "SELECT * FROM vave where model='$currentModel' order by model,manufacturerNo";
        $selectResult2 = $conn->query($selectSql2);
        
        $currentManuc = '';
        while($row2 = mysqli_fetch_assoc($selectResult2)) {
            if($currentManuc != $row2['manufacturerNo']){
                $vave[$vaveIndex][1]++;
                $vave[$vaveIndex][2] += $row2['costReduction'];

                $currentManuc = $row2['manufacturerNo'];
            }
        }       

        $vaveIndex++;
    }
}

// Select all supplier
$selectSql = "SELECT * FROM vave order by model";
$selectResult = $conn->query($selectSql);

$vave3 = array();
$vaveIndex3 = 0;
$currentModel = '';

while($row = mysqli_fetch_assoc($selectResult)) {
    if($currentModel != $row['model']){
        $currentModel = $row['model'];

        $vave3[$vaveIndex3][0] = $currentModel;

        $selectSql2 = "SELECT * FROM vave where model='$currentModel'";
        $selectResult2 = $conn->query($selectSql2);
        
        while($row2 = mysqli_fetch_assoc($selectResult2)) {
            $vave3[$vaveIndex3][1]++;
        }       

        $vaveIndex3++;
    }
}

$rows = array();
$rows2 = array();
$rows3 = array();
//flag is not needed
$flag = true;
$table = array();
$table2 = array();
$table3 = array();

$table['cols'] = array(
    array('label' => 'Model', 'type' => 'string'),
    array('label' => 'Proposal', 'type' => 'number')
);

$table2['cols'] = array(
    array('label' => 'Model', 'type' => 'string'),
    array('label' => 'Cost', 'type' => 'number')
);

$table3['cols'] = array(
    array('label' => 'Type', 'type' => 'string'),
    array('label' => 'Count', 'type' => 'number')
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

$rows2 = array();
for($i=0; $i<$vaveIndex; $i++){
    $vaveModel = $vave[$i][0];
    $vaveProp = $vave[$i][2];

    $temp = array();
    // the following line will be used to slice the Pie chart
    $temp[] = array('v' => (string) $vaveModel); 

    // Values of each slice
    $temp[] = array('v' => (int) $vaveProp); 
    $rows2[] = array('c' => $temp);
}

$rows3 = array();
for($i=0; $i<$vaveIndex3; $i++){
    $vaveModel = $vave3[$i][0];
    $vaveProp = $vave3[$i][1];

    $temp = array();
    // the following line will be used to slice the Pie chart
    $temp[] = array('v' => (string) $vaveModel); 

    // Values of each slice
    $temp[] = array('v' => (int) $vaveProp); 
    $rows3[] = array('c' => $temp);
}

$table['rows'] = $rows;
$table2['rows'] = $rows2;
$table3['rows'] = $rows3;

$jsonTable = json_encode($table);
$jsonTable2 = json_encode($table2);
$jsonTable3 = json_encode($table3);

echo "
<script type=\"text/javascript\">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        // Create our data table out of JSON data loaded from server.
        var data = new google.visualization.DataTable($jsonTable);
        var data2 = new google.visualization.DataTable($jsonTable2);
        var data3 = new google.visualization.DataTable($jsonTable3);

        var view = new google.visualization.DataView(data);
        var view2 = new google.visualization.DataView(data2);
        var view3 = new google.visualization.DataView(data3);

        view.setColumns([0,1,
                       { 'calc': 'stringify',
                         'sourceColumn': 1,
                         'type': 'string',
                         'role': 'annotation' }
                        ]);
        view2.setColumns([0,1,
                       { 'calc': 'stringify',
                         'sourceColumn': 1,
                         'type': 'string',
                         'role': 'annotation' }
                        ]);
        view3.setColumns([0,1,
                       { 'calc': 'stringify',
                         'sourceColumn': 1,
                         'type': 'string',
                         'role': 'annotation' }
                        ]);
        var options = {
            title: 'Number of Proposal',
            backgroundColor: '#efefef',
            bar: {groupWidth: '95%'},
            annotations: {textStyle: {color: '#5b4421'}},
            hAxis: {textStyle: {color: '#5b4421'}},
            vAxis: {textStyle: {color: '#5b4421'}},
            legend: { position: 'none' }
        };

        var options2 = {
            title: 'Total Cost Reduction / Vehicle (IDR)',
            backgroundColor: '#efefef',
            bar: {groupWidth: '95%'},
            annotations: {textStyle: {color: '#5b4421'}},
            hAxis: {textStyle: {color: '#5b4421'}},
            vAxis: {textStyle: {color: '#5b4421'}},
            legend: { position: 'none' }
        };

        var options3 = {
            title: 'Number of Proposed Part Number',
            backgroundColor: '#efefef',
            bar: {groupWidth: '95%'},
            annotations: {textStyle: {color: '#5b4421'}},
            hAxis: {textStyle: {color: '#5b4421'}},
            vAxis: {textStyle: {color: '#5b4421'}},
            legend: { position: 'none' }
        };

        // Instantiate and draw our chart, passing in some options.
        // Do not forget to check your div ID
        var chart = new google.visualization.ColumnChart(document.getElementById('vavegraph1'));
        var chart2 = new google.visualization.ColumnChart(document.getElementById('vavegraph2'));
        var chart3 = new google.visualization.ColumnChart(document.getElementById('vavegraph3'));

        chart.draw(view, options);
        chart2.draw(view2, options2);
        chart3.draw(view3, options3);
    }
</script>";
?>

