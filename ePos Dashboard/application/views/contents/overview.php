<script type="text/javascript">
  $(function () {
	
	$('#container').highcharts({
	  chart: {
    	plotBackgroundColor: null,
    	plotBorderWidth: 1,//null,
    	plotShadow: false
	  },
	  title: {
    	text: 'Browser market shares at a specific website, 2014'
	  },
	  tooltip: {
    	pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
	  },
	  plotOptions: {
    	pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          dataLabels: {
            enabled: true,
            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
            style: {
              color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
            }
          }
        }
	  },
	  series: [{
    	type: 'pie',
    	name: 'Browser share',
    	data: [
          ['Firefox',   45.0],
          ['IE',       26.8],
          {
            name: 'Chrome',
            y: 12.8,
            sliced: true,
            selected: true
          },
          ['Safari',    8.5],
          ['Opera',     6.2],
          ['Others',   0.7]
    	]
	  }]
	});
	var years = ['1750', '1800', '1850', '1900', '1950', '1999', '2050'];
	$('#container2').highcharts({
        chart: {
            type: 'area'
        },
        title: {
            text: 'Historic and Estimated Worldwide Population Growth by Region'
        },
        subtitle: {
            text: 'Source: Wikipedia.org'
        },
        xAxis: {
            categories: years,
            tickmarkPlacement: 'on',
            title: {
                enabled: false
            }
        },
        yAxis: {
            title: {
                text: 'Billions'
            },
            labels: {
                formatter: function () {
                    return this.value / 1000;
                }
            }
        },
        tooltip: {
            shared: true,
            valueSuffix: ' millions'
        },
        plotOptions: {
            area: {
                stacking: 'normal',
                lineColor: '#666666',
                lineWidth: 1,
                marker: {
                    lineWidth: 1,
                    lineColor: '#666666'
                }
            }
        },
        series: [{
            name: 'Asia',
            data: [502, 635, 809, 947, 1402, 3634, 5268]
        }, {
            name: 'Africa',
            data: [106, 107, 111, 133, 221, 767, 1766]
        }, {
            name: 'Europe',
            data: [163, 203, 276, 408, 547, 729, 628]
        }, {
            name: 'America',
            data: [18, 31, 54, 156, 339, 818, 1201]
        }, {
            name: 'Oceania',
            data: [2, 2, 2, 6, 13, 30, 46]
        }]
    });
	
  });

</script>

<div id="page-content-wrapper">

	<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
  
  <a href="#menu-toggle" class="" id="menu-toggle" style="font-size:80%; margin-top:-5%;">
    <span id="hand" class="glyphicon glyphicon-hand-left"></span> Show/Hide Menu</a>
  <br /><br />

	<!-- Heading Row -->
    <div class="row">
	  <div class="col-md-6">
	    <div id="container"></div>
      </div><!-- /.col-md-8 -->
      
      <div class="col-md-6">
	    <div id="container2"></div>
      </div><!-- /.col-md-8 -->
    </div><!-- /.row -->
    <hr />
    <div class="row">
	  
    </div><!-- /.row -->
    
    <!-- /FOOTER -->
    <hr class="featurette-divider">
    
    <footer>
      <p class="pull-right"><a href="#">Back to top</a></p>
      <p>© 2014 Company, Inc. · <a href="#">Privacy</a> · <a href="#">Terms</a></p>
	</footer>

</div>
    
  </div><!-- /.container-fluid -->
  
</div><!-- /.page-content-wrapper -->

<!-- Menu Toggle Script -->
<script>
$("#menu-toggle").click(function(e) {
  e.preventDefault();
  $("#wrapper").toggleClass("toggled");
});
$( "#menu-toggle" ).click(function(){
	if($( "#hand" ).attr("class") == "glyphicon glyphicon-hand-left"){
      $( "#hand" ).removeClass("glyphicon glyphicon-hand-left",500);
	  $( "#hand" ).addClass("glyphicon glyphicon-hand-right",500);
	}
	else{
	  $( "#hand" ).removeClass("glyphicon glyphicon-hand-right",500);
	  $( "#hand" ).addClass("glyphicon glyphicon-hand-left",500);
	}
	  
      //$( "#hand" ).switchClass( "glyphicon glyphicon-hand-right glyphicon", "glyphicon glyphicon-hand-left glyphicon");
    });

</script>



