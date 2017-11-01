<?php
	use PHPUnit\Framework\TestCase;
	include("database-connector.php");

	final class SearchTest extends TestCase {
		public function testKeywordAdmin() {
			include("database-connector.php");
			$keyword = "admin";
			$sql = $conn->prepare("SELECT * FROM survey WHERE survey_title LIKE '%$keyword%';");
			$sql->execute();
			$ans = $sql->get_result();
			$this->assertEquals(4, $ans->num_rows);
		}

		public function testKeywordPoll() {
			include("database-connector.php");
			$keyword = "poll";
			$sql = $conn->prepare("SELECT * FROM survey WHERE survey_title LIKE '%$keyword%';");
			$sql->execute();
			$ans = $sql->get_result();
			$this->assertEquals(2, $ans->num_rows);
		}

		public function testKeyword2() {
			include("database-connector.php");
			$keyword = "2";
			$sql = $conn->prepare("SELECT * FROM survey WHERE survey_title LIKE '%$keyword%';");
			$sql->execute();
			$ans = $sql->get_result();
			$this->assertEquals(2, $ans->num_rows);
		}

		public function testKeywordRandom() {
			include("database-connector.php");
			$keyword = "absolutegibberish";
			$sql = $conn->prepare("SELECT * FROM survey WHERE survey_title LIKE '%$keyword%';");
			$sql->execute();
			$ans = $sql->get_result();
			$this->assertEquals(0, $ans->num_rows);
		}
	}

?>