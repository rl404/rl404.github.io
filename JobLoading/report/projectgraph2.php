<?php

$rows = array();
//flag is not needed
$flag = true;
$table = array();
$table['cols'] = array(

    // Labels for your chart, these represent the column titles
    // Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
    array('label' => 'Job', 'type' => 'string'),
    array('label' => 'Hours', 'type' => 'number')

);

$rows = array();
for($i=0; $i<$jobIndex; $i++){
    $jobName = $job[$i][0];
    $jobHour = number_format((float)$job[$i][1], 1, '.', '');

    $temp = array();
    // the following line will be used to slice the Pie chart
    $temp[] = array('v' => (string) $jobName); 

    // Values of each slice
    $temp[] = array('v' => (int) $jobHour); 
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
            backgroundColor: '#e8dac3',
            bar: {groupWidth: '95%'},
            annotations: {textStyle: {color: '#5b4421'}},
            hAxis: {textStyle: {color: '#5b4421'}},
            vAxis: {textStyle: {color: '#5b4421'}},
            legend: { position: 'none' }
        };
        // Instantiate and draw our chart, passing in some options.
        // Do not forget to check your div ID
        var chart = new google.visualization.ColumnChart(document.getElementById('reportgraph'));

        chart.draw(view, options);
    }
</script>";
?>

