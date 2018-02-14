<?php

$rows = array();

//flag is not needed
$flag = true;
$table = array();

$table['cols'] = array(
    array('label' => 'Model', 'type' => 'string'),
    array('label' => 'Number of Proposal', 'type' => 'number')
);

$rows = array();
for($i=0; $i<count($typeP); $i++){
    $typeName = $typeP[$i][0];
    $typeCount = $typeP[$i][1];

    $temp = array();
    // the following line will be used to slice the Pie chart
    $temp[] = array('v' => (string) $typeName); 

    // Values of each slice
    $temp[] = array('v' => (int) $typeCount); 
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
            backgroundColor: '#fafaff',
            bar: {groupWidth: '95%'},
            annotations: {textStyle: {color: '#5b4421'}},
            hAxis: {textStyle: {color: '#5b4421'}},
            vAxis: {textStyle: {color: '#5b4421'}},
            legend: { position: 'none' }
        };

        // Instantiate and draw our chart, passing in some options.
        // Do not forget to check your div ID
        var chart = new google.visualization.ColumnChart(document.getElementById('graph2$row[model]'));

        chart.draw(view, options);
    }
</script>";

?>