<?php 
	use PHPUnit\Framework\TestCase;

	final class SurveyTest extends TestCase{
		public function testEmptyId(){
			include("database-connector.php");
			$id = "";
			$sql = $conn->prepare("SELECT * FROM survey WHERE survey_id = ?;");
		  $sql->bind_param('s', $id);
		  $sql->execute();
		  $ans = $sql->get_result();
			$this->assertEquals(0, $ans->num_rows);
		}
		public function testGibberishId(){
			include("database-connector.php");
			$id = "absolutegibberish";
			$sql = $conn->prepare("SELECT * FROM survey WHERE survey_id = ?;");
		  $sql->bind_param('s', $id);
		  $sql->execute();
		  $ans = $sql->get_result();
			$this->assertEquals(0, $ans->num_rows);
		}
		public function testNotExistingId(){
			include("database-connector.php");
			$id = "P9999999999";
			$sql = $conn->prepare("SELECT * FROM survey WHERE survey_id = ?;");
		  $sql->bind_param('s', $id);
		  $sql->execute();
		  $ans = $sql->get_result();
			$this->assertEquals(0, $ans->num_rows);
		}
		public function testValidId(){
			include("database-connector.php");
			$id = "P0000000001";
			$sql = $conn->prepare("SELECT * FROM survey WHERE survey_id = ?;");
		  $sql->bind_param('s', $id);
		  $sql->execute();
		  $ans = $sql->get_result();
			$this->assertEquals(1, $ans->num_rows);
		}
		public function testCheckSurveyInfo(){
			include("database-connector.php");
			$id = "P0000000001";
			$sql = $conn->prepare("SELECT * FROM survey WHERE survey_id = ?;");
		  $sql->bind_param('s', $id);
		  $sql->execute();
		  $ans = $sql->get_result();
		  $this->assertEquals(1, $ans->num_rows);
		  $row = $ans->fetch_assoc();
		  $this->assertEquals("Admin Poll 1", $row['survey_title']);
		  $this->assertEquals("2017-10-29", $row['create_time']);
		 	$this->assertEquals("9999999999", $row['user_id']);
		 	$creator = $row['user_id'];
		  $sql = $conn->prepare("SELECT user_name FROM user WHERE user_id = ?;");
		  $sql->bind_param('s', $creator);
		  $sql->execute();
		  $ans2 = $sql->get_result();
		  $row2 = $ans2->fetch_assoc();
		 	$this->assertEquals("admin", $row2['user_name']);
		  $sql = $conn->prepare("SELECT * FROM survey_options WHERE survey_id = ?;");
		  $sql->bind_param('s', $id);
		  $sql->execute();
		  $ans3 = $sql->get_result();
		  $this->assertEquals(3, $ans3->num_rows);
		}
		public function testVoteFunction(){
			include("database-connector.php");
			$id = "P0000000001";
			$selectionid = 1;

			$sql = $conn->prepare("SELECT voter_number FROM survey WHERE survey_id = ?;");
			$sql->bind_param('s', $id);
			$sql->execute();
			$ans = $sql->get_result();
			$row = $ans->fetch_assoc();
			$oldtotal = $row['voter_number'];

			$sql = $conn->prepare("SELECT voter_number FROM survey_options WHERE survey_id = ? AND option_id = ?;");
			$sql->bind_param('si', $id, $selectionid);
			$sql->execute();
			$ans = $sql->get_result();
			$row = $ans->fetch_assoc();
			$oldoptvote = $row['voter_number'];

			$sql = $conn->prepare("UPDATE survey SET voter_number = voter_number + 1 WHERE survey_id = ?;");
		  $sql->bind_param('s', $id);
		  $sql->execute();

		  $sql = $conn->prepare("UPDATE survey_options SET voter_number = voter_number + 1 WHERE survey_id = ? AND option_id = ?;");
		  $sql->bind_param('ss', $id, $selectionid);
		  $sql->execute();

		  $sql = $conn->prepare("SELECT voter_number FROM survey WHERE survey_id = ?;");
			$sql->bind_param('s', $id);
			$sql->execute();
			$ans = $sql->get_result();
			$row = $ans->fetch_assoc();
			$newtotal = $row['voter_number'];

			$sql = $conn->prepare("SELECT voter_number FROM survey_options WHERE survey_id = ? AND option_id = ?;");
			$sql->bind_param('si', $id, $selectionid);
			$sql->execute();
			$ans = $sql->get_result();
			$row = $ans->fetch_assoc();
			$newoptvote = $row['voter_number'];

		  $this->assertEquals(($oldtotal+1), $newtotal);
		  $this->assertEquals(($oldoptvote+1), $newoptvote);

		  $sql = $conn->prepare("UPDATE survey SET voter_number = voter_number - 1 WHERE survey_id = ?;");
		  $sql->bind_param('s', $id);
		  $sql->execute();

		  $sql = $conn->prepare("UPDATE survey_options SET voter_number = voter_number - 1 WHERE survey_id = ? AND option_id = ?;");
		  $sql->bind_param('ss', $id, $selectionid);
		  $sql->execute();
		}
		public function testCreatorAddOption(){
			$newopt = "new option";
			$surveyid = "P0000000001";
			include("database-connector.php");
			$sql = $conn->prepare("SELECT option_id FROM survey_options WHERE survey_id = ? ORDER BY option_id DESC LIMIT 1;");
			$sql->bind_param('s', $surveyid);
			$sql->execute();
			$currans = $sql->get_result();
			$curr = $currans->fetch_assoc();
			$currnum = $curr['option_id']+1;

			$sql = $conn->prepare("INSERT INTO survey_options (survey_id, option_id, option_string, voter_number) VALUES (?, ?, ?, 0);");
			$sql->bind_param('sis', $surveyid, $currnum, $newopt);
			$sql->execute();

			$sql = $conn->prepare("SELECT option_id FROM survey_options WHERE survey_id = ? ORDER BY option_id DESC LIMIT 1;");
			$sql->bind_param('s', $surveyid);
			$sql->execute();
			$currans = $sql->get_result();
			$curr2 = $currans->fetch_assoc();
			$this->assertEquals($curr2['option_id'], $currnum);

			$sql = $conn->prepare("DELETE FROM survey_options WHERE survey_id = ? AND option_id = ?;");
			$sql->bind_param('si', $surveyid, $currnum);
			$sql->execute();
		}
		public function testCreatorDeleteOption(){
			$id = "P0000000001";
			$optid = 4;
			include("database-connector.php");
			$sql = $conn->prepare("SELECT option_id FROM survey_options WHERE survey_id = ? ORDER BY option_id DESC LIMIT 1;");
			$sql->bind_param('s', $surveyid);
			$sql->execute();
			$currans = $sql->get_result();
			$curr = $currans->fetch_assoc();
			$currnum = $curr['option_id'];

			$sql = $conn->prepare("DELETE FROM survey_options WHERE survey_id = ? AND option_id = ?");
			$sql->bind_param('si', $id, $optid);
			$sql->execute();

			$sql = $conn->prepare("DELETE FROM user_survey WHERE survey_id = ? AND option_id = ?");
			$sql->bind_param('si', $id, $optid);
			$sql->execute();

			$sql = $conn->prepare("UPDATE survey_options SET option_id = option_id-1 WHERE survey_id = ? and option_id > ?");
			$sql->bind_param('si', $id, $optid);
			$sql->execute();

			$sql = $conn->prepare("SELECT option_id FROM survey_options WHERE survey_id = ? ORDER BY option_id DESC LIMIT 1;");
			$sql->bind_param('s', $surveyid);
			$sql->execute();
			$currans = $sql->get_result();
			$curr = $currans->fetch_assoc();
			
			$this->assertEquals($currnum, $curr['option_id']);
		}
		public function testCreatorDeleteSurvey(){
			$stitle = "New Test Rating";
		  $stags = "New Test Rating";
		  $userid = "9999999999";
		  date_default_timezone_set('America/Los_Angeles');
		  $stime = date("Y-m-d", time());
		  $surveyid = "R0000000003";

		  include("database-connector.php");

		  $sql = $conn->prepare("INSERT INTO survey (create_time, rating_average, survey_id, survey_tags, survey_title, user_id, voter_number) VALUES (?, 0.0, ?, ?, ?, ?, 0);");
		  $sql->bind_param('sssss', $stime, $surveyid, $stags, $stitle, $userid);
		  $sql->execute();
		  
		  $i = 0;
		  for($i = 0; $i < 10; $i++){
		    $sql = $conn->prepare("INSERT INTO survey_options (survey_id, option_id, option_string, voter_number) VALUES (\"" .$surveyid."\", ?, \"\", 0);");
		    $y = $i+1;
		    $sql->bind_param('i', $y);
		    $sql->execute();
		  }

			$dsurveyid = "R0000000003";
			$sql = $conn->prepare("DELETE FROM survey WHERE survey_id = ?;");
			$sql->bind_param('s', $dsurveyid);
			$sql->execute();
			$sql = $conn->prepare("DELETE FROM trending_survey WHERE survey_id = ?;");
			$sql->bind_param('s', $dsurveyid);
			$sql->execute();
			$sql = $conn->prepare("DELETE FROM user_survey WHERE survey_id = ?;");
			$sql->bind_param('s', $dsurveyid);
			$sql->execute();

			$sql= $conn->prepare("SELECT * FROM survey WHERE survey_id = ?;");
			$sql->bind_param('s', $dsurveyid);
			$sql->execute();
			$ans = $sql->get_result();
			$this->assertEquals(0, $ans->num_rows);
			$sql= $conn->prepare("SELECT * FROM trending_survey WHERE survey_id = ?;");
			$sql->bind_param('s', $dsurveyid);
			$sql->execute();
			$ans = $sql->get_result();
			$this->assertEquals(0, $ans->num_rows);
			$sql= $conn->prepare("SELECT * FROM user_survey WHERE survey_id = ?;");
			$sql->bind_param('s', $dsurveyid);
			$sql->execute();
			$ans = $sql->get_result();
			$this->assertEquals(0, $ans->num_rows);
		}
		public function testRatingHasTenOptions(){
			include("database-connector.php");
			$id = "R0000000001";
			$sql = $conn->prepare("SELECT * FROM survey_options WHERE survey_id = ?;");
		  $sql->bind_param('s', $id);
		  $sql->execute();
		  $ans = $sql->get_result();
			$this->assertEquals(10, $ans->num_rows);
		}
	}	
?>