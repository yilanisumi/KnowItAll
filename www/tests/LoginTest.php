<?php 
	use PHPUnit\Framework\TestCase;

	final class LoginTest extends TestCase{
		public function testInvalidUSCEmail(){
			include("database-connector.php");
			$email = "gibberish@gibberish.gibber";
			$sql = $conn->prepare("SELECT * FROM user WHERE usc_email = ?;");
		  $sql->bind_param('s', $email);
		  $sql->execute();
		  $ans = $sql->get_result();
			$this->assertEquals(0, $ans->num_rows);
		}
		public function testValidUSCEmail(){
			include("database-connector.php");
			$email = "admin@usc.edu";
			$sql = $conn->prepare("SELECT * FROM user WHERE usc_email = ?;");
		  $sql->bind_param('s', $email);
		  $sql->execute();
		  $ans = $sql->get_result();
			$this->assertEquals(1, $ans->num_rows);
		}

		public function testInvalidUSCID(){
			include("database-connector.php");
			$uscid = "1234567890";
			$sql = $conn->prepare("SELECT * FROM user WHERE usc_id = ?;");
			$sql->bind_param('s', $uscid);
			$sql->execute();
			$ans = $sql->get_result();
			$this->assertEquals(0, $ans->num_rows);
		}

		public function testValidUSCID(){
			include("database-connector.php");
			$uscid = "9999999999";
			$sql = $conn->prepare("SELECT * FROM user WHERE usc_id = ?;");
			$sql->bind_param('s', $uscid);
			$sql->execute();
			$ans = $sql->get_result();
			$this->assertEquals(1, $ans->num_rows);
		}

		public function testCorrectPasswordE(){
			include("database-connector.php");
			$email = "admin@usc.edu";
			$password = "admin";
			$sql = $conn->prepare("SELECT * FROM user WHERE usc_email = ?;");
			$sql->bind_param('s', $email);
			$sql->execute();
			$ans = $sql->get_result();
			$row = $ans->fetch_assoc();
			$passHash = $row['password'];
			$result = password_verify($password, $passHash);
			$this->assertEquals(TRUE, $result);
		}

		public function testIncorrectPasswordE(){
			include("database-connector.php");
			$email = "admin@usc.edu";
			$password = "abcde";
			$sql = $conn->prepare("SELECT * FROM user WHERE usc_email = ?;");
			$sql->bind_param('s', $email);
			$sql->execute();
			$ans = $sql->get_result();
			$row = $ans->fetch_assoc();
			$passHash = $row['password'];
			$result = password_verify($password, $passHash);
			$this->assertEquals(FALSE, $result);
		}

		public function testCorrectPasswordI(){
			include("database-connector.php");
			$uscid = "9999999999";
			$password = "admin";
			$sql = $conn->prepare("SELECT * FROM user WHERE usc_id = ?;");
			$sql->bind_param('s', $uscid);
			$sql->execute();
			$ans = $sql->get_result();
			$row = $ans->fetch_assoc();
			$passHash = $row['password'];
			$result = password_verify($password, $passHash);
			$this->assertEquals(TRUE, $result);
		}

		public function testIncorrectPasswordI(){
			include("database-connector.php");
			$uscid = "9999999999";
			$password = "abcde";
			$sql = $conn->prepare("SELECT * FROM user WHERE usc_id = ?;");
			$sql->bind_param('s', $uscid);
			$sql->execute();
			$ans = $sql->get_result();
			$row = $ans->fetch_assoc();
			$passHash = $row['password'];
			$result = password_verify($password, $passHash);
			$this->assertEquals(FALSE, $result);
		}
	}
?>