google.charts.load("43", {packages:["corechart"]});
//For content type
function checkSup(provider){
    $('#content-type').each(function() {
      var query=$(this).val(); 
      if(query == "Select a type:"){

      }else if(query == "all" && provider == "all"){
        $.get("headers_data.php", function(data){
            google.charts.setOnLoadCallback(Histogram(data,query,provider));     
          });
      }else if(query == "all" && provider != "all"){
        $.get("headers_data.php?provider="+provider, function(data){
            google.charts.setOnLoadCallback(Histogram(data,query,provider));     
          });
      }
      else{
        $.get("headers_data.php?query="+query+"&provider="+provider, function(data){
            google.charts.setOnLoadCallback(Histogram(data,query,provider));     
          }); 
      }
      });
};
//For provider
function check(){   
    $('#provider').each(function() {
        checkSup($(this).val());
    });
};

function getMax(arr) {
    var max;
    for (var i=1 ; i<arr.length ; i++) {
        if (max == null || parseInt(arr[i][1]) > parseInt(max))
            max = arr[i][1];
    }
    return max;
}



//creating google chart function
function Histogram(result,query,provider) {

    var array = JSON.parse(result);
    var max = getMax(array);
    var data = google.visualization.arrayToDataTable(
        JSON.parse(result));

      var options = {
        title: 'Max-Age by Content-Type ('+ query +' & '+ provider + ')',
        width:1800,
        height:650,
        backgroundColor: { fill:'transparent' },
        colors: ['#CC0000'],
        titleTextStyle: {
            color: '#000080'
        },
        hAxis:{
            textStyle: {
                fontSize: 14,
                color: '000080',
                bold: true,
                italic: false
            }
        },
        vAxis: {
            title: 'Content-Types',
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
        },
        histogram: {
            bucketSize: (max/10)+1
        },
        legend: { position: 'none' },
      };

      var chart = new google.visualization.Histogram(document.getElementById('chart'));
      chart.draw(data, options);
    
};