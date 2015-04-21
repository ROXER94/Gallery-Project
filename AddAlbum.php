<?php 
session_start(); //If we ARE Logged In?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Info 2300 Project Three - Add Album</title>
		<link rel="stylesheet" type="text/css" href="CSS/CSS.css">
		<link href='http://fonts.googleapis.com/css?family=Arizonia' rel='stylesheet' type='text/css'>
	</head>
	
<body>
	<div class = "contentbody">
	<div class = 'header'>
	<ul class = "navlarge">
	     	<li><a href="Index.php">Home</a></li>
	     	<li><a href="AddPhoto.php">Add Photo</a></li>
			<li><div class="activepage"><a href="AddAlbum.php">Add Album</a></div></li>
			<li><a href="Albums.php">Albums</a></li>
			<li><a href="Search.php">Search</a></li>
			<li><a href="SignUp.php">Sign Up</a></li>
			<li><a href="LogOut.php">Log Out</a></li>
	</ul></div>
	
	<!-- Adding Albums goes here-->
	<br />
		<form id="upload" action="AddAlbum.php" method="post">
				<label for="title">Album Title:&nbsp;&nbsp;</label><input type="text" name="title" id="title" placeholder="Name of Album"><br />
				<textarea name="description" rows="5" cols="35" placeholder="Please Describe The Album"></textarea><br />
				<input id="uploadButton" type="submit" name="submit" value="Add Album" />
		</form>
	
	
	<?php
		$valid = true;
		
		require_once "config.php";
		$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
	
		if (mysqli_connect_error() ){
			die("Can't connect to database: " . $mysqli->error);
		}
	
	//Need to do form checking for creating album
	if(isset($_POST["submit"])) {
	
		// Auto-increment the aID myself
		$maxaID = $mysqli->query("SELECT MAX(aID) as aID FROM Albums");
			if($maxaID && $maxaID->num_rows > 0){
				$maxaIDarray = $maxaID->fetch_assoc();
					$maximumaID = $maxaIDarray['aID'];
			}
		$aID = $maximumaID+1;
		
		$regexTitle = "/^[a-zA-Z0-9 ]+/i";
		$regexDescription = "/^[a-zA-Z0-9 ]+/i";
	
		$AlbumName = strip_tags($_POST['title']);
		$AlbumName = trim($AlbumName);
		$Description = strip_tags($_POST['description']);
		$Description = trim($Description);
		
		if(!preg_match($regexTitle,$AlbumName) || strlen($AlbumName) <= 0 || strlen($AlbumName) > 32){
			print("Album Title must contain alphabetic letters and/or numerals between 1 and 32 characters");
				$valid = false;
		} else if(!preg_match($regexDescription,$Description) || strlen($Description) <= 0 || strlen($Description) > 100){
			print("Description must contain alphabetic letters and/or numerals between 1 and  100 characters");
			$valid = false;
		} else if ($valid){
			$result = $mysqli->query("INSERT INTO Albums ( aID, AlbumName, AlbumDescription, date_created, date_modified )
										VALUES( '$aID', '$AlbumName', '$Description', CURDATE() , CURDATE() )");
			if ($result){
				print("<p>The album $AlbumName was created successfully.</p>");
			} else {
				print("<p>Error: The album $AlbumName was not created.</p>");
				}
			}
		}
		
	$mysqli->close();
	
	?>
	<br />
	<br />
	<br />
	<br />
	
	<!-- take a user back to the main page -->
	<div class = "fancy"><a class = "bottomlink" href="Index.php"><b>Back to Home page</b></a></div>
	
	</div>
	
</body>
</html>