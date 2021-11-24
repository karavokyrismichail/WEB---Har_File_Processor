google.charts.load('current', {packages: ['corechart', 'bar']});
//content type
function check() {
    $('#content-type').each(function() {
      var query=$(this).val();
      //get all data
      if(query == "all"){
        $.get("content_type_data.php", function(data){
            data = JSON.parse(data);
            google.charts.setOnLoadCallback(columnchart(data,query));     
          });
      }else{
        //get query-data
        $.get("content_type_data.php?query="+query, function(data){
            data = JSON.parse(data);
            google.charts.setOnLoadCallback(columnchart(data,query));     
          }); 
      }
      });
};
//day
$(document).ready(function() {
    $('#dayofWeek').change(function() {
      var query=$(this).val();
      //get all data
      if(query == "all"){
        $.get("day_data.php", function(data){
            data = JSON.parse(data);
            google.charts.setOnLoadCallback(columnchart(data,query));     
          });
      }else{
        //get query-data
        $.get("day_data.php?query="+query, function(data){
            data = JSON.parse(data);
            google.charts.setOnLoadCallback(columnchart(data,query));     
          }); 
      }
      });
});
//HTTP method
function checkM(){
    $('#method').each(function() {
      var query=$(this).val();
      //get all data
      if(query == "all"){
        $.get("method_data.php", function(data){
            data = JSON.parse(data);
            google.charts.setOnLoadCallback(columnchart(data,query));     
          });
      }else{
        //get query-data
        $.get("method_data.php?query="+query, function(data){
            data = JSON.parse(data);
            google.charts.setOnLoadCallback(columnchart(data,query));     
          }); 
      }
      });
};
//provider
$(document).ready(function() {
    $('#provider').change(function() {
      var query=$(this).val();
      //get all data
      if(query == "all"){
        $.get("provider_data.php", function(data){
            data = JSON.parse(data);
            google.charts.setOnLoadCallback(columnchart(data,query));     
          });
      }else{
        //get query-data
        $.get("provider_data.php?query="+query, function(data){
            data = JSON.parse(data);
            google.charts.setOnLoadCallback(columnchart(data,query));     
          }); 
      }
      });
});

//google chart function
function columnchart(result,query) {

    var data = new google.visualization.DataTable();
    data.addColumn('timeofday', 'Hour');
    data.addColumn('number', 'Average Response Time(ms)');

    data.addRows(
        result
    );

    var options = {
        title: 'Average Response Time by Hour ('+ query +')',
        explorer: { 
            actions: ['dragToZoom', 'rightClickToReset'],
            axis: 'horizontal',
            keepInBounds: true,
            maxZoomIn: 35
        },
        titleTextStyle: {
            color: '#000080'
        },
        focusTarget: 'category',
        width:1700,
        height:650,
        backgroundColor: { fill:'transparent' },
        colors: ['#CC0000'],
        bar: {
            groupWidth: 60
        },
        hAxis: {
        title: 'Hour',
        format: 'h:mm:s a',
        gridlines: {color: '#000080'},
        
        textStyle: {
            fontSize: 14,
            color: '000080',
            bold: true,
            italic: false
        },
        titleTextStyle: {
            fontSize: 18,
            color: '000080',
            bold: true,
            italic: false
        }
        },
        vAxis: {
        gridlines: {color: '#000080'},
        title: 'Average Response Time (ms)',
        textStyle: {
            fontSize: 18,
            color: '#000080',
            bold: false,
            italic: false
        },
        titleTextStyle: {
            fontSize: 18,
            color: '#000080',
            bold: true,
            italic: false
        }
        }
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('chart'));
    chart.draw(data, options);
};