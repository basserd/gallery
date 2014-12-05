<?php
class Connection{

	protected $db;


	function __construct($host, $user, $password, $database){
		$this->db = new PDO("mysql:host=".$host.";dbname=".$database.";charset=utf8", $user, $password);
	}
}

class Image extends Connection{
	private $conn;

	function __construct(){
		$this->conn = new Connection("localhost", "root", "", "gallery");
		$this->db = $this->conn->db;
	}

	// To check for already existing image.
	public function checkforimagename($image_name){
		$errors = array();

		$query = 'SELECT image FROM images WHERE image=:image';
		$stmt = $this->db->prepare($query);
		$stmt->bindParam(':image', $image_name, PDO::PARAM_STR);
		if($stmt->execute()){
			$count = $stmt->rowCount();
			if($count > 0){
				array_push($errors, "Image name already exists, change it.");
			}else{
				return true;
			}
		}
	}

	public function showFullSize($userid, $id){
		$errors = array();

		$query = 'SELECT * FROM images WHERE id=:id AND userid=:userid';
		$stmt = $this->db->prepare($query);

		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->bindParam(':userid', $userid, PDO::PARAM_INT);

		if($stmt->execute()){
			if($stmt->rowCount() == 1){
				$images = array();

				while($row = $stmt->fetch()){
					$images[] = array('id' => $row['id'], 'userid' => $row['userid'], 'image' => $row['image'], 'title' => $row['title']);
				}
				foreach($images as $image){
					echo '<div class="full-image-title">'. $image['title']. '</div></br>';
					echo '<img src="media/database_images/full-size/'. $image['image']. '" class="image_full"';
				}
				
			}
		}

	}

	public function showThumbs($userid){
		$errors = array();
		$teller = 0;

		$query = 'SELECT * FROM images WHERE userid = :userid';
		$stmt = $this->db->prepare($query);

		$stmt->bindParam(':userid', $userid, PDO::PARAM_INT);

		if($stmt->execute()){
			if($stmt->rowCount() > 0){
				$images = array();

				while($row = $stmt->fetch()){
					$images[] = array('id' => $row['id'], 'userid' => $row['userid'], 'image' => $row['image'], 'title' => $row['title']);
				}

				// Loop wich will make the structure for the images.
				// This will be used, in the admin panel.
				// The user will get all the Thumbnails, onclick he will get the original size in his screen.

				foreach($images as $image){
					//$imageId = $image['id'];
					$teller++;

					echo '<a href="image_overview.php?id='.$image['id']. '"><img src="media/database_images/thumb/'. $image['image'] .'"/></a> ';
					if($teller == 4){
						echo "<br/><br/>";
					}
				}
			}
		}else{
			echo "Stmt not executed;";
		}
	}

	public function imagetodb($title, $image_name, $userid){
		$errors = array();
		

		if(count($errors) == 0){
			$query = 'INSERT INTO images(id, userid, image, title)VALUES(null, :userid, :image, :title)';

			$stmt = $this->db->prepare($query);
			$stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
			$stmt->bindParam(':image', $image_name, PDO::PARAM_STR);
			$stmt->bindParam(':title', $title, PDO::PARAM_STR);

			if($stmt->execute()){
				echo "";
			}else{
				echo "Niet geupload.";
			}
		}else{
			return $errors;
		}
	}
}

class User extends Connection{
	private $conn;	

	function __construct(){
		$this->conn = new Connection("localhost", "root", "", "gallery");
		$this->db = $this->conn->db;
	}

	public function profileChange($id, $displayname_new){
		//$update_profile = 'UPDATE user SET displayname="'.$displayname_new.'" AND bio="'.$bio_new.'" WHERE id='.$id;
		$update_profile = 'UPDATE user SET displayname=:displayname_new WHERE id=:id';
		$stmt = $this->db->prepare($update_profile);


		$stmt->bindParam(':displayname_new', $displayname_new, PDO::PARAM_STR);
		//$stmt->bindParam(':bio_new', $bio_new, PDO::PARAM_STR);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		
		echo $update_profile;

		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	public function profile_picChange($id, $profile_pic_new){
		$query = 'UPDATE user SET profile_pic=:profile_pic_new WHERE id=:id';
		$stmt = $this->db->prepare($query);
		$stmt->bindParam(':profile_pic_new', $profile_pic_new, PDO::PARAM_STR);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);

		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	public function emailChange($email_new, $id){
		$query = 'UPDATE user SET email=:email WHERE id=:id';
		$stmt = $this->db->prepare($query);
		$stmt->bindParam(':email', $email_new, PDO::PARAM_STR);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	public function emailCheck($email_new){
		$query = 'SELECT email FROM user WHERE email=:email';
		$stmt = $this->db->prepare($query);
		$stmt->bindParam(':email', $email_new, PDO::PARAM_STR);
		if($stmt->execute()){
			$count = $stmt->rowCount();
			if($count > 0){
				return false;
			}else{
				return true;
			}
		}else{
			echo 'Stmt not executed.';
		}
	}

	public function backgroundChange($id, $image_name){
		$query = 'UPDATE user SET background=:background WHERE id=:id';

		$stmt = $this->db->prepare($query);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->bindParam(':background', $image_name, PDO::PARAM_STR);
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}	

	// The following functions are all for, Profile settings change.
	public function passwordCheck($id, $old_password){
		$old_password = sha1($old_password);

		$query = 'SELECT * FROM user WHERE id=:id AND password=:old_password';
		$stmt = $this->db->prepare($query);
		$stmt->bindParam(':old_password', $old_password, PDO::PARAM_STR);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		if($stmt->execute()){
			$count = $stmt->rowCount();
			if($count > 0){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	public function passwordChange($id, $password_new){
		$password = sha1($password_new);

		$query = 'UPDATE user SET password=:password WHERE id=:id';
		$stmt = $this->db->prepare($query);
		$stmt->bindParam(':password', $password, PDO::PARAM_STR);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	public function checkforEmptyFields($username, $password){
		if(strlen($username) == ""){
			return false;
		}else{
			echo "";
		}
		if(strlen($password) == ""){
			return false;
		}else{
			echo "";
		}
	}

	public function checkforFieldChars($username, $password){
		if(strlen($username) < 5){
			return false;
		}else{
			echo "";
		}
		if(strlen($password) < 6){
			return false;
		}else{
			echo "";
		}
	}

	public function Login($username, $password){
		$password = sha1($password);

		$login_query = 'SELECT * FROM user WHERE username=:username AND password=:password';
		$stmt = $this->db->prepare($login_query);
		$stmt->bindParam(':username', $username, PDO::PARAM_STR);
		$stmt->bindParam(':password', $password, PDO::PARAM_STR);
		if($stmt->execute()){
			$count = $stmt->rowCount();
			if($count > 0){
				$result = $stmt->fetch();
				return $result['id'];
			}else{
				return false;
			}
		}else{
			echo "No execute happened.";
		}
	}



	public function returnUsername(){
		return $this->username;
	}

	public function selectAllByUsername($username){
		$getid_query = 'SELECT * FROM user WHERE username = :username';
		$stmt = $this->db->prepare($getid_query);
		$stmt->bindParam(':username', $_SESSION['session_username'], PDO::PARAM_STR);
		if($stmt->execute()){
			$userdetails = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->id = $userdetails['id'];
			$this->displayname = $userdetails['displayname'];
			$this->email = $userdetails['email'];
			$this->background = $userdetails['background'];
			$this->password = $userdetails['password'];
			$this->profilepic = $userdetails['profile_picture'];
			$this->bio = $userdetails['bio'];
			return $userdetails;
		}else{
			return false;
		}
	}

	public function getId(){
		return $this->id;
	}

	public function getDisplayName(){
		return $this->displayname;
	}

	public function getEmail(){
		return $this->email;
	}

	public function getBackground(){
		return $this->background;
	}

	public function getProfilePic(){
		return $this->profilepic;
	}

	public function getBio(){
		return $this->bio;
	}

	public function Register($username, $displayname, $email, $password, $passwordconfirm){

		$username = $this->sanitize($username);
		// Hashing the password.
		$password = sha1($password);

		$errors = array();

		// Check for already existing username..
		$usernameCheck = 'SELECT username FROM user WHERE username = :username';
		$stmt = $this->db->prepare($usernameCheck);
		$stmt->bindParam(':username', $username, PDO::PARAM_STR);
		$count = $stmt->rowCount();
		if($stmt->execute()){
			$count = $stmt->rowCount();
			if($count != 0){
				array_push($errors, "Username is already taken.");
			}
		}

		// check for displayname.
		$displaynameCheck = 'SELECT displayname FROM user WHERE displayname = :displayname';
		$stmt = $this->db->prepare($displaynameCheck);
		$stmt->bindParam(':displayname', $username, PDO::PARAM_STR);
		$count = $stmt->rowCount();
		if($stmt->execute()){
			$count = $stmt->rowCount();
			if($count != 0){
				array_push($errors, "Displayname is already been taken.");
			}
		}

		// Check for already used email adress.
		$emailCheck = 'SELECT email FROM user WHERE email = :email';
		$stmt = $this->db->prepare($emailCheck);
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$count = $stmt->rowCount();
		if($stmt->execute()){
			$count = $stmt->rowCount();
			if($count != 0){
				array_push($errors, "Email-adress is already been used.");
			}
		}

		// Counting the errors, and returning them when they exist.
		if(count($errors) == 0){
			$register_query = 'INSERT INTO user(id, username, displayname, password, email)VALUES(null, :username, :displayname, :password, :email)';
			$stmt = $this->db->prepare($register_query);
			$stmt->bindParam(':username', $username, PDO::PARAM_STR);
			$stmt->bindParam(':displayname', $displayname, PDO::PARAM_STR);
			$stmt->bindParam(':password', $password, PDO::PARAM_STR);
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);

			if($stmt->execute()){
				return true;
			}
		}
		return $errors;
	}

	private function sanitize($input){
		$input = htmlspecialchars($input);
		$input = nl2br($input);
		return $input;
	}
}