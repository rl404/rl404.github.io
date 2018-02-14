<?php

$rows = array();

//flag is not needed
$flag = true;
$table = array();

$table['cols'] = array(
    array('label' => 'Model', 'type' => 'string'),
    array('label' => 'PE Approved', 'type' => 'number'),
    array('label' => 'PP Received', 'type' => 'number'),
    array('label' => 'PuD Process', 'type' => 'number'),
    array('label' => 'Send to EA', 'type' => 'number')
);

$rows = array();
for($i=0; $i<count($month); $i++){
    $monthName = $month[$i][0];

    $monthName = date("M",mktime(0,0,0,$monthName,1,2011));

    $monthCost = $month[$i][1];
    $monthCost2 = $monthPP[$i][1];
    $monthCost3 = $monthPUD[$i][1];
    $monthCost4 = $monthEA[$i][1];

    $temp = array();
    // the following line will be used to slice the Pie chart
    $temp[] = array('v' => (string) $monthName); 

    // Values of each slice
    $temp[] = array('v' => (int) $monthCost); 
    $temp[] = array('v' => (int) $monthCost2);
    $temp[] = array('v' => (int) $monthCost3);
    $temp[] = array('v' => (int) $monthCost4);
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
                         'role': 'annotation' },2,
                         { 'calc': 'stringify',
                         'sourceColumn': 2,
                         'type': 'string',
                         'role': 'annotation' },3,
                         { 'calc': 'stringify',
                         'sourceColumn': 3,
                         'type': 'string',
                         'role': 'annotation' },4,
                         { 'calc': 'stringify',
                         'sourceColumn': 4,
                         'type': 'string',
                         'role': 'annotation' }
                        ]);

        var options = {
            backgroundColor: '#fafaff',
            bar: {groupWidth: '95%'},
            annotations: {textStyle: {color: '#5b4421'}},
            hAxis: {textStyle: {color: '#5b4421'}},
            vAxis: {textStyle: {color: '#5b4421'}},
            
            legend: { position: 'top', maxLines: 3 }
        };

        // Instantiate and draw our chart, passing in some options.
        // Do not forget to check your div ID
        var chart = new google.visualization.ColumnChart(document.getElementById('graph$row[model]'));

        chart.draw(view, options);
    }
</script>";

?>