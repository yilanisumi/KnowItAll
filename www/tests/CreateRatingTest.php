<?php 
	use PHPUnit\Framework\TestCase;

	final class CreateRatingTest extends TestCase{
		public function testRatingSurveyIdLength(){
			include("database-connector.php");

			$sql = $conn->prepare("SELECT survey_id FROM survey WHERE survey_id LIKE \"P%\" ORDER BY survey_id DESC LIMIT 1;");
			$sql->execute();
			$ans = $sql->get_result();
			$maxid = $ans->fetch_assoc();
			$oldid = substr($maxid["survey_id"], 1);
			$oldid = intval($oldid);
			$oldid += 1;
			$surveyid = "".$oldid;
			while(strlen($surveyid) < 10){
			$surveyid = "0".$surveyid;
			}
			$surveyid = "R".$surveyid;

			$this->assertEquals(strlen($maxid["survey_id"]), strlen($surveyid));			
		}

		public function testRatingSurveyIdPrefix(){
			include("database-connector.php");

			$sql = $conn->prepare("SELECT survey_id FROM survey WHERE survey_id LIKE \"P%\" ORDER BY survey_id DESC LIMIT 1;");
			$sql->execute();
			$ans = $sql->get_result();
			$maxid = $ans->fetch_assoc();
			$oldid = substr($maxid["survey_id"], 1);
			$oldid = intval($oldid);
			$oldid += 1;
			$surveyid = "".$oldid;
			while(strlen($surveyid) < 10){
			$surveyid = "0".$surveyid;
			}
			$surveyid = "R".$surveyid;

			$this->assertEquals("R", $surveyid[0]);
		}

		public function testRatingSurveyIdValue(){
			include("database-connector.php");

			$sql = $conn->prepare("SELECT survey_id FROM survey WHERE survey_id LIKE \"P%\" ORDER BY survey_id DESC LIMIT 1;");
			$sql->execute();
			$ans = $sql->get_result();
			$maxid = $ans->fetch_assoc();
			$oldid = substr($maxid["survey_id"], 1);
			$oldid = intval($oldid);
			$oldid += 1;
			$surveyid = "".$oldid;
			while(strlen($surveyid) < 10){
			$surveyid = "0".$surveyid;
			}
			$surveyid = "R".$surveyid;

			$this->assertEquals($oldid, intval(substr($surveyid, 1)));
		}

		public function testRatingSurveyDbInsert(){
			include("database-connector.php");

			// sample data for test row
			$stitle = "title";
			$stags = "tag1 tag2 tag3";
			$userid = "9999999999";
			date_default_timezone_set('America/Los_Angeles');
			$stime = date("Y-m-d", time());
			
			// create the survey id (will work if previous test cases pass)
			$sql = $conn->prepare("SELECT survey_id FROM survey WHERE survey_id LIKE \"R%\" ORDER BY survey_id DESC LIMIT 1;");
			$sql->execute();
			$ans = $sql->get_result();
			$maxid = $ans->fetch_assoc();
			$oldid = substr($maxid["survey_id"], 1);
			$oldid = intval($oldid);
			$oldid += 1;
			$surveyid = "".$oldid;
			while(strlen($surveyid) < 10){
			$surveyid = "0".$surveyid;
			}
			$surveyid = "R".$surveyid;


			// note how many rows were in the survey table before the test row was inserted
			$sql = $conn->prepare("SELECT * FROM survey WHERE survey_id LIKE \"R%\" ORDER BY survey_id DESC;");
			$sql->execute();
			$ans = $sql->get_result();
			$numRowsBefore = $ans->num_rows;

			// insert into the survey table
			$sql = $conn->prepare("INSERT INTO survey (create_time, rating_average, survey_id, survey_tags, survey_title, user_id, voter_number) VALUES (?, 0.0, ?, ?, ?, ?, 0);");
			$sql->bind_param('sssss', $stime, $surveyid, $stags, $stitle, $userid);
			$sql->execute();

			// note how many rows were in the survey table after the test row was inserted
			$sql = $conn->prepare("SELECT * FROM survey WHERE survey_id LIKE \"R%\" ORDER BY survey_id DESC;");
			$sql->execute();
			$ans = $sql->get_result();
			$numRowsAfter = $ans->num_rows;

			// check if the test row was added to the survey table
			$this->assertEquals($numRowsBefore + 1, $numRowsAfter);

			// delete the test row
			$sql = $conn->prepare("DELETE FROM survey WHERE survey_id LIKE \"R%\" ORDER BY survey_id DESC LIMIT 1;");
			$sql->execute(); 
		}

		public function testRatingSurveyTrendingLimit() {
			include("database-connector.php");

			$surveyid = "P0000000099";

			// create the survey id (will work if previous test cases pass)
			$sql = $conn->prepare("SELECT survey_id FROM trending_survey WHERE survey_id LIKE \"R%\" ORDER BY survey_id DESC LIMIT 1;");
			$sql->execute();
			$ans = $sql->get_result();
			$maxid = $ans->fetch_assoc();
			$oldid = substr($maxid["survey_id"], 1);
			$oldid = intval($oldid);
			$oldid += 1;
			$surveyid = "".$oldid;
			while(strlen($surveyid) < 10){
			$surveyid = "0".$surveyid;
			}
			$surveyid = "R".$surveyid;

			$sql = $conn->prepare("SELECT * FROM trending_survey WHERE survey_id LIKE \"R%\";");
			$sql->execute();
			$ans = $sql->get_result();
			$numrows = $ans->num_rows;
			if($numrows >= 3){
				$sql = $conn->prepare("DELETE FROM trending_survey WHERE survey_id LIKE \"R%\" ORDER BY survey_id ASC LIMIT 1;");
				$sql->execute();
			}
			$sql = $conn->prepare("INSERT INTO trending_survey (survey_id) VALUES (?);");
			$sql->bind_param('s', $surveyid);
			$sql->execute();

			$sql = $conn->prepare("SELECT * FROM trending_survey WHERE survey_id LIKE \"R%\";");
			$sql->execute();
			$ans = $sql->get_result();
			$numTrending = $ans->num_rows;

			$threeMax = false;
			if($numTrending <= 3) {
				$threeMax = true;
			}

			$this->assertEquals(true, $threeMax);

			$sql = $conn->prepare("DELETE FROM trending_survey WHERE survey_id = ?;");
			$sql->bind_param('s', $surveyid);
			$sql->execute();
		}

		public function testRatingSurveyTrendingFifo() {
			include("database-connector.php");

			$surveyid = "P0000000099";

			// create the survey id (will work if previous test cases pass)
			$sql = $conn->prepare("SELECT survey_id FROM trending_survey WHERE survey_id LIKE \"R%\" ORDER BY survey_id DESC LIMIT 1;");
			$sql->execute();
			$ans = $sql->get_result();
			$maxid = $ans->fetch_assoc();
			$oldid = substr($maxid["survey_id"], 1);
			$oldid = intval($oldid);
			$oldid += 1;
			$surveyid = "".$oldid;
			while(strlen($surveyid) < 10){
			$surveyid = "0".$surveyid;
			}
			$surveyid = "R".$surveyid;

			// Oldest trending poll survey
			$sql = $conn->prepare("SELECT survey_id FROM trending_survey WHERE survey_id LIKE \"R%\" ORDER BY survey_id ASC LIMIT 1;");
			$sql->execute();
			$ans = $sql->get_result();
			$minid = $ans->fetch_assoc();
			$oldid = substr($minid["survey_id"], 1);
			$oldid = intval($oldid);
			$firstId = "".$oldid;
			while(strlen($firstId) < 10){
			$firstId = "0".$firstId;
			}
			$firstId = "R".$firstId;

			$sql = $conn->prepare("SELECT * FROM trending_survey WHERE survey_id LIKE \"R%\";");
			$sql->execute();
			$ans = $sql->get_result();
			$numrows = $ans->num_rows;
			if($numrows >= 3){
				$sql = $conn->prepare("DELETE FROM trending_survey WHERE survey_id LIKE \"R%\" ORDER BY survey_id ASC LIMIT 1;");
				$sql->execute();
			}
			$sql = $conn->prepare("INSERT INTO trending_survey (survey_id) VALUES (?);");
			$sql->bind_param('s', $surveyid);
			$sql->execute();

			$sql = $conn->prepare("SELECT * FROM trending_survey WHERE survey_id LIKE \"R%\";");
			$sql->execute();
			$ans = $sql->get_result();
			$numTrending = $ans->num_rows;

			// Oldest trending poll survey
			$sql = $conn->prepare("SELECT * FROM trending_survey WHERE survey_id = ?");
			$sql->bind_param('s', $firstId);
			$sql->execute();
			$ans = $sql->get_result();
			$firstIdRemains = $ans->num_rows;

			if($numrows < 3)
				$this->assertEquals(1, $firstIdRemains);
			else 
				$this->assertEquals(0, $firstIdRemains);
			$sql = $conn->prepare("DELETE FROM trending_survey WHERE survey_id = ?;");
			$sql->bind_param('s', $surveyid);
			$sql->execute();
		}
	}
?>