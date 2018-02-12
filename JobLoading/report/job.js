google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() 
{
    // Create our data table out of JSON data loaded from server.
    var jsonTable = {
          "cols": [
                  {"id":"","label":"Job Name","pattern":"","type":"string"},
                  {"id":"","label":"Hours","pattern":"","type":"number"}
                  ],
          "rows": [
                  {"c":[{"v":"Job Name 1","f":null},{"v":5,"f":null}]},
                  {"c":[{"v":"Job Name 2","f":null},{"v":14,"f":null}]},
                  {"c":[{"v":"Job Name 3","f":null},{"v":10,"f":null}]},
                  {"c":[{"v":"Job Name 4","f":null},{"v":7,"f":null}]},
                  {"c":[{"v":"Job Name 5","f":null},{"v":2,"f":null}]}
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