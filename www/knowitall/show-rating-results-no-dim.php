<div class="row">
  <div class="ui master-center">
    <div id="chart_div" class="chart_div">
      <script src="https://www.gstatic.com/charts/loader.js"></script>
      <script>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart(){
          var data = new google.visualization.arrayToDataTable([
            ['Stars', 'Responses', {role: 'style'}],
            ['1', <?php $sql = $conn->prepare("SELECT voter_number FROM survey_options WHERE survey_id = ? AND option_id = 1;");
                    $sql->bind_param('s', $id);
                    $sql->execute();
                    $chartans = $sql->get_result();
                    $chartrow = $chartans->fetch_assoc();
                    echo $chartrow['voter_number']?>, 'gold'],
            ['2', <?php $sql = $conn->prepare("SELECT voter_number FROM survey_options WHERE survey_id = ? AND option_id = 2;");
                    $sql->bind_param('s', $id);
                    $sql->execute();
                    $chartans = $sql->get_result();
                    $chartrow = $chartans->fetch_assoc();
                    echo $chartrow['voter_number']?>, 'gold'],
            ['3', <?php $sql = $conn->prepare("SELECT voter_number FROM survey_options WHERE survey_id = ? AND option_id = 3;");
                    $sql->bind_param('s', $id);
                    $sql->execute();
                    $chartans = $sql->get_result();
                    $chartrow = $chartans->fetch_assoc();
                    echo $chartrow['voter_number']?>, 'gold'],
            ['4', <?php $sql = $conn->prepare("SELECT voter_number FROM survey_options WHERE survey_id = ? AND option_id = 4;");
                    $sql->bind_param('s', $id);
                    $sql->execute();
                    $chartans = $sql->get_result();
                    $chartrow = $chartans->fetch_assoc();
                    echo $chartrow['voter_number']?>, 'gold'],
            ['5', <?php $sql = $conn->prepare("SELECT voter_number FROM survey_options WHERE survey_id = ? AND option_id = 5;");
                    $sql->bind_param('s', $id);
                    $sql->execute();
                    $chartans = $sql->get_result();
                    $chartrow = $chartans->fetch_assoc();
                    echo $chartrow['voter_number']?>, 'gold'],
            ['6', <?php $sql = $conn->prepare("SELECT voter_number FROM survey_options WHERE survey_id = ? AND option_id = 6;");
                    $sql->bind_param('s', $id);
                    $sql->execute();
                    $chartans = $sql->get_result();
                    $chartrow = $chartans->fetch_assoc();
                    echo $chartrow['voter_number']?>, 'gold'],
            ['7', <?php $sql = $conn->prepare("SELECT voter_number FROM survey_options WHERE survey_id = ? AND option_id = 7;");
                    $sql->bind_param('s', $id);
                    $sql->execute();
                    $chartans = $sql->get_result();
                    $chartrow = $chartans->fetch_assoc();
                    echo $chartrow['voter_number']?>, 'gold'],
            ['8', <?php $sql = $conn->prepare("SELECT voter_number FROM survey_options WHERE survey_id = ? AND option_id = 8;");
                    $sql->bind_param('s', $id);
                    $sql->execute();
                    $chartans = $sql->get_result();
                    $chartrow = $chartans->fetch_assoc();
                    echo $chartrow['voter_number']?>, 'gold'],
            ['9', <?php $sql = $conn->prepare("SELECT voter_number FROM survey_options WHERE survey_id = ? AND option_id = 9;");
                    $sql->bind_param('s', $id);
                    $sql->execute();
                    $chartans = $sql->get_result();
                    $chartrow = $chartans->fetch_assoc();
                    echo $chartrow['voter_number']?>, 'gold'],
            ['10',<?php $sql = $conn->prepare("SELECT voter_number FROM survey_options WHERE survey_id = ? AND option_id = 10;");
                    $sql->bind_param('s', $id);
                    $sql->execute();
                    $chartans = $sql->get_result();
                    $chartrow = $chartans->fetch_assoc();
                    echo $chartrow['voter_number']?>, 'gold']
          ]);
          var opt = {'title':'', 'width':800, 'height':600, 'color':'#da0', 'legend':'none'};
          var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
          chart.draw(data, opt);
        }
      </script>
    </div>
  </div>
</div>