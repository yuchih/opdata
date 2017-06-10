function drawBarChart( barData ) {

    google.charts.load('current', {packages: ['corechart', 'bar']});
    google.charts.setOnLoadCallback(function(){ drawBasic(barData) });

    $(window).resize(function(){
      drawBasic( barData );
    });

}


// title, data, axa
function drawBasic( barData ) {

      var json = barData;

      if( json ) {

            // Create our data table out of JSON data loaded from server.
            var data = new google.visualization.DataTable(json.data);
            var ddd = json.data;
            var min_time = json.time['min_time'];
            var max_time = json.time['max_time'];
            var today = (ddd[0]['mrttime_date']).split('-');
            var day = (today[1]).replace('0', '') +'月'+ (today[2]) +'日 旅運量';
            var currentTime = new Date().getHours();
            var visualData = [];

            data.addColumn('timeofday', '時間');
            data.addColumn('number', '進出人數');
            data.addColumn({type: 'string', role: 'style'});

            for(var i=0; i<ddd.length; i++) {

                var volume = parseInt(ddd[i]['mrttime_in']) + parseInt(ddd[i]['mrttime_out']);
                if( currentTime===parseInt(ddd[i]['mrttime_time']) ) {
                    var tmp = [{v: [parseInt(ddd[i]['mrttime_time']), 0, 0], f: '時間：'+ddd[i]['mrttime_time']+ ':00' }, volume, 'color:green'];
                } else {
                    var tmp = [{v: [parseInt(ddd[i]['mrttime_time']), 0, 0], f: '時間：'+ddd[i]['mrttime_time']+ ':00' }, volume, 'color:rgb(51, 102, 204)'];
                }
                visualData.push( tmp );

            }

            data.addRows( visualData );

            var options = {
              title: day,
              titleTextStyle: {
                  color: '#000',    // any HTML string color ('red', '#cc00cc')
                  fontName: '微軟正黑體', // i.e. 'Times New Roman'
                  fontSize: 14, // 12, 18 whatever you want (don't specify px)
                  bold: false,    // true or false
              },
              legend: {position: 'none'},
              titlePosition: 'out',
              hAxis: {
                //title: 'Time of Day',
                gridlines: {
                      color: '#fff'
                  }   ,
                 format: 'H',
                 viewWindow: {
                  min: [min_time-1, 0, 0],
                  max: [max_time+1, 0, 0]
                }
              },
              vAxis: {
                title: '總進出人次',
                titleTextStyle: {
                    italic: false,
                    fontSize: 14,
                    fontName: '微軟正黑體'
                },
                gridlines: {
                  // color: '#fff', //Red lines
                },
                // minValue: 0,
                // ticks: [0, 7500, 15000, 22500, 30000]
              },
              animation:{
                duration: 300,
                easing: 'out',
                startup: true
              },
              tooltip: {
                textStyle:
                {
                    color: '#000000',
                    fontName: '微軟正黑體',
                    fontSize: 14,
                    bold: false
                },
              }
            };

            var chart = new google.visualization.ColumnChart(
            document.getElementById('barchart'));

            chart.draw(data, options);

      } else {

          alert('無此歷史資料');

      }


}