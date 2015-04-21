<?php 
session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Info 2300 Project Three - Log In</title>
		<link rel="stylesheet" type="text/css" href="CSS/CSS.css">
		<link href='http://fonts.googleapis.com/css?family=Arizonia' rel='stylesheet' type='text/css'>
	</head>
	
<body>
	<?php
	$loginfailed = false;
	if ( isset( $_POST['username'] ) && isset( $_POST['password'] ) ) {
			$username = filter_input( INPUT_POST, 'username', FILTER_SANITIZE_STRING );//NUMBER_INT
			$password = filter_input( INPUT_POST, 'password', FILTER_SANITIZE_STRING );
			$salt = 'yadayadayada';
			$hashed_password = hash("sha256", $password.$salt);
			
			require_once 'config.php';
			$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
			$result = $mysqli->query( "SELECT * FROM Users WHERE Username = '$username' AND Password = '$hashed_password'");
			
			if ($result && $result->num_rows == 1) {//Login successful
				$_SESSION['logged_user'] = $_POST['username'];
			}else{//Login unsuccessful
				$loginfailed = true;
			}
		}
		if ( isset( $_SESSION[ 'logged_user' ] ) ) {//Logged In
		
		echo "<div class = 'contentbody'>
	<div class = 'header'>
	<ul class = 'navlarge'>
	     	<li><a href='Index.php'>Home</a></li>
	     	<li><a href='AddPhoto.php'>Add Photo</a></li>
			<li><a href='AddAlbum.php'>Add Album</a></li>
			<li><a href='Albums.php'>Albums</a></li>
			<li><a href='Search.php'>Search</a></li>
			<li><a href='SignUp.php'>Sign Up</a></li>
			<li><a href='LogOut.php'>Log Out</a></li>
	</ul></div>";
	
			print "<p>Welcome back, $username. You are currently logged in.</p>";
			print "<p>You can now do a bunch of cool stuff:</p>";
			print "<p>Creating albums, Editing albums, Deleting albums, Adding photos to albums, Editing photos, Deleting photos</p>";
			print" <br /><br /><br /><br /><br /><br /><br /><br />";
			
		$mysqli->close();
		
		}else{//Logged Out
		echo '<div class = "contentbody">
	<div class = "header">
	<ul class = "nav">
	     	<li><a href="Index.php">Home</a></li>
			<li><a href="Albums.php">Albums</a></li>
			<li><a href="Search.php">Search</a></li>
			<li><a href="SignUp.php">Sign Up</a></li>
			<li><div class="activepage"><a href="LogIn.php">Log In</a></div></li>
	</ul></div>';
		echo'<!-- Log In goes here-->
		<br />
		<br />
    <form action="LogIn.php" method="post">
    Username:&nbsp;&nbsp;<input type="text" name="username" />
    Password:&nbsp;&nbsp;<input type="password" name="password" />
    <input type="submit" name="submit" value="Submit" />
	</form>
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />';}
		
		if ($loginfailed){
			print "Sorry, your username or password did not match. Please try again.";
		}
			
		?>
	<!-- take a user back to the main page -->
	<div class = "fancy"><a class = "bottomlink" href="Index.php"><b>Back to Home page</b></a></div>
	
	</div>
	
</body>
</html>
		
		