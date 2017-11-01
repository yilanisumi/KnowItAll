<?php 
	use PHPUnit\Framework\TestCase;

	final class SignupTest extends TestCase{
		protected function setUp(){
			include("database-connector.php");
			$email1 = "jsmith@usc.edu";
			$uscid1 = "1234567890";
			$password1 = "jsmith007";
			$passHash1 = password_hash($password1, PASSWORD_BCRYPT);
			$username1 = "John Smith";
			$sql = $conn->prepare("INSERT INTO `user` (`user_id`,`usc_email`, `usc_id`, `password`, `user_name`) VALUES (?, ?, ?, ?, ?);");
			$sql->bind_param('sssss', $uscid1, $email1, $uscid1, $passHash1, $username1);
			$sql->execute();

			$email2 = "jdoe@usc.edu";
			$uscid2 = "0987654321";
			$password2 = "jdoe42";
			$passHash2 = password_hash($password2, PASSWORD_BCRYPT);
			$username2 = "Jane Doe";
			$sql = $conn->prepare("INSERT INTO `user` (`user_id`,`usc_email`, `usc_id`, `password`, `user_name`) VALUES (?, ?, ?, ?, ?);");
			$sql->bind_param('sssss', $uscid2, $email2, $uscid2, $passHash2, $username2);
			$sql->execute();
		}

		protected function tearDown(){
			include("database-connector.php");
			$email1 = "jsmith@usc.edu";
			$sql = $conn->prepare("DELETE FROM user WHERE usc_email = ?;");
			$sql->bind_param('s', $email1);
			$sql->execute();

			$email2 = "jdoe@usc.edu";
			$sql = $conn->prepare("DELETE FROM user WHERE usc_email = ?;");
			$sql->bind_param('s', $email2);
			$sql->execute();
		}

		public function testRegisteredEmail() {
			include("database-connector.php");
			$email = "jsmith@usc.edu";
			$sql = $conn->prepare("SELECT * FROM user WHERE usc_email = ?;");
			$sql->bind_param('s', $email);
			$sql->execute();
			$ans = $sql->get_result();
			$this->assertEquals(1, $ans->num_rows);
		}

		public function testUnregisteredEmail() {
			include("database-connector.php");
			$email = "jonsnow@usc.edu";
			$sql = $conn->prepare("SELECT * FROM user WHERE usc_email = ?;");
			$sql->bind_param('s', $email);
			$sql->execute();
			$ans = $sql->get_result();
			$this->assertEquals(0, $ans->num_rows);
		}

		public function testRegisteredUSCID() {
			include("database-connector.php");
			$uscid = "1234567890";
			$sql = $conn->prepare("SELECT * FROM user WHERE usc_id = ?;");
			$sql->bind_param('s', $uscid);
			$sql->execute();
			$ans = $sql->get_result();
			$this->assertEquals(1, $ans->num_rows);
		}

		public function testUnregisteredUSCID() {
			include("database-connector.php");
			$uscid = "5555555555";
			$sql = $conn->prepare("SELECT * FROM user WHERE usc_id = ?;");
			$sql->bind_param('s', $uscid);
			$sql->execute();
			$ans = $sql->get_result();
			$this->assertEquals(0, $ans->num_rows);
		}

		public function testUsernameEmail() {
			include("database-connector.php");
			$email = "jsmith@usc.edu";
			$sql = $conn->prepare("SELECT * FROM user WHERE usc_email = ?;");
			$sql->bind_param('s', $email);
			$sql->execute();
			$ans = $sql->get_result();
			$row = $ans->fetch_assoc();
			$username = $row['user_name'];
			$this->assertEquals("John Smith", $username);
		}

		public function testUsernameUSCID() {
			include("database-connector.php");
			$uscid = "0987654321";
			$sql = $conn->prepare("SELECT * FROM user WHERE usc_id = ?;");
			$sql->bind_param('s', $uscid);
			$sql->execute();
			$ans = $sql->get_result();
			$row = $ans->fetch_assoc();
			$username = $row['user_name'];
			$this->assertEquals("Jane Doe", $username);
		}

		public function testPasswordEmail() {
			include("database-connector.php");
			$email = "jdoe@usc.edu";
			$sql = $conn->prepare("SELECT * FROM user WHERE usc_email = ?;");
			$sql->bind_param('s', $email);
			$sql->execute();
			$ans = $sql->get_result();
			$row = $ans->fetch_assoc();
			$passHash = $row['password'];
			$result = password_verify("jdoe42", $passHash);
			$this->assertEquals(1, $result);
		}

		public function testPasswordUSCID() {
			include("database-connector.php");
			$uscid = "1234567890";
			$sql = $conn->prepare("SELECT * FROM user WHERE usc_id = ?;");
			$sql->bind_param('s', $uscid);
			$sql->execute();
			$ans = $sql->get_result();
			$row = $ans->fetch_assoc();
			$passHash = $row['password'];
			$result = password_verify("jsmith007", $passHash);
			$this->assertEquals(1, $result);
		}

		public function testEmailUSCID() {
			include("database-connector.php");
			$uscid = "1234567890";
			$sql = $conn->prepare("SELECT * FROM user WHERE usc_id = ?;");
			$sql->bind_param('s', $uscid);
			$sql->execute();
			$ans = $sql->get_result();
			$row = $ans->fetch_assoc();
			$email = $row['usc_email'];
			$this->assertEquals($email, "jsmith@usc.edu");
		}

		public function testUSCIDEmail() {
			include("database-connector.php");
			$email = "jdoe@usc.edu";
			$sql = $conn->prepare("SELECT * FROM user WHERE usc_email = ?;");
			$sql->bind_param('s', $email);
			$sql->execute();
			$ans = $sql->get_result();
			$row = $ans->fetch_assoc();
			$uscid = $row['usc_id'];
			$this->assertEquals($uscid, "0987654321");
		}
	}

?>