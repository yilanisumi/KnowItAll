<div class="row">
  <div class="ui blurring dimmable dimmed master-center">
    <div id="chart_div" class="chart_div">
      <script src="https://www.gstatic.com/charts/loader.js"></script>
      <script>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart(){
          var data = new google.visualization.arrayToDataTable([
            ['Option', 'Votes']
            <?php 
              $sql = $conn->prepare("SELECT * FROM survey_options WHERE survey_id = ?;");
              $sql->bind_param('s', $id);
              $sql->execute();
              $chartans = $sql->get_result();
              $j = $chartans->num_rows;
              for($i = 0; $i < $j; $i++){
                $chartrow = $chartans->fetch_assoc();
                echo ",[\"".$chartrow['option_string']."\",".$chartrow['voter_number']."]";
              }
            ?>
          ]);
          // data.addColumn('string', 'Topping');
          // data.addColumn('number', 'Slices');
          // data.addRows([
          //   ['Shrooms', 3],
          //   ['Bacon', 4],
          //   ['Trash',1]
          // ]);
          var opt = {'title':'', 'width':800, 'height':600};
          var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
          chart.draw(data, opt);
        }
      </script>
    </div>
    <div class="ui dimmer active">
      <div class="content">
        <div class="center">
          <button class="ui button" id="show-results">Show Results</button>
        </div>
      </div>
    </div>
  </div>
</div>