@extends('admin_layout')
@section('admin_content')

        <!-- page content goes here -->
        <!-- Home page -->
            <div class="container-fluid page-ti-co p-0 col-11 col-sm-8 col-md-8">
                <div class="page-title">Dashboard</div>
                <div class="page-content container-fluid d-flex justify-content-evenly flex-row">
                  {{-- Pie chart --}}
                  <div class="row">
                    <div id="piechart" style="width: 600px; height: 400px;" class="col-11"></div>
                    <div id="columnchart_values" style="width: 600px; height: 400px;"></div>
                  </div>
                  {{-- {{dd($dataComment)}} --}}
                </div>
          </div>
        </div>
      </div>
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <script type="text/javascript">
        google.charts.load("current", {packages:['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
          var data = google.visualization.arrayToDataTable([
            ["Element", "Density", { role: "style" } ],
            <?php echo $dataComment;?>
          ]);

          var view = new google.visualization.DataView(data);
          view.setColumns([0, 1,
                          { calc: "stringify",
                            sourceColumn: 1,
                            type: "string",
                            role: "annotation" },
                          2]);

          var options = {
            title: "Comment statistics",
            width: 600,
            height: 400,
            bar: {groupWidth: "50%"},
            legend: { position: "none" },
          };
          var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
          chart.draw(view, options);
          }
      </script>
      
      <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
  
        function drawChart() {
  
          var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            <?php echo $data;?>
          ]);
  
          var options = {
            title: 'BurgerZ statistics'
          };
  
          var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  
          chart.draw(data, options);
        }
      </script>
@endsection