google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() 
{
    // Create our data table out of JSON data loaded from server.
    var jsonTable = {
          "cols": [
                  {"id":"","label":"Dept. Code","pattern":"","type":"string"},
                  {"id":"","label":"Hours","pattern":"","type":"number"}
                  ],
          "rows": [
                  {"c":[{"v":"DEPT01","f":null},{"v":500,"f":null}]},
                  {"c":[{"v":"DEPT02","f":null},{"v":450,"f":null}]},
                  {"c":[{"v":"DEPT03","f":null},{"v":500,"f":null}]},
                  {"c":[{"v":"DEPT04","f":null},{"v":610,"f":null}]},
                  {"c":[{"v":"DEPT05","f":null},{"v":300,"f":null}]}
                  ]
    };

  var data = new google.visualization.DataTable(jsonTable);

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