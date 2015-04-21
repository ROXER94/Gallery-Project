<?php 
session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Info 2300 Project Three - Albums</title>
		<link rel="stylesheet" type="text/css" href="CSS/CSS.css">
		<link href='http://fonts.googleapis.com/css?family=Arizonia' rel='stylesheet' type='text/css'>
	</head>
	
<body>
<?php if (! isset( $_SESSION[ 'logged_user' ] ) ) {//If user is not logged in
	echo '<div class = "contentbody">
	<div class = "header">
	<ul class = "nav">
	     	<li><a href="Index.php">Home</a></li>
			<li><div class="activepage"><a href="Albums.php">Albums</a></div></li>
			<li><a href="Search.php">Search</a></li>
			<li><a href="SignUp.php">Sign Up</a></li>
			<li><a href="LogIn.php">Log In</a></li>
	</ul></div>';
	
	}else{//User is logged in - Do some delete and other modifying stuff here
	echo "<div class = 'contentbody'>
	<div class = 'header'>
	<ul class = 'navlarge'>
	     	<li><a href='Index.php'>Home</a></li>
	     	<li><a href='AddPhoto.php'>Add Photo</a></li>
			<li><a href='AddAlbum.php'>Add Album</a></li>
			<li><div class='activepage'><a href='Albums.php'>Albums</a></div></li>
			<li><a href='Search.php'>Search</a></li>
			<li><a href='SignUp.php'>Sign Up</a></li>
			<li><a href='LogOut.php'>Log Out</a></li>
	</ul></div>";}
	
	//<!-- Albums go here-->
		require_once "config.php";
					$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );

					if (mysqli_connect_error() ){
						die("Can't connect to database: " . $mysqli->error);
					}
					
				$Albumquery = $mysqli->query("SELECT * FROM Albums");
					if($Albumquery && $Albumquery->num_rows > 0){
						while($Albumqueryarray = $Albumquery->fetch_assoc()){
							$AlbumName = $Albumqueryarray['AlbumName'];
							$aID = $Albumqueryarray['aID'];
							$AlbumDescription = $Albumqueryarray['AlbumDescription'];
							$date_modified = $Albumqueryarray['date_modified'];
							echo '<div class = "albumdiv"><a href="AlbumView.php?aID='.$aID.'">';
							echo "Album Name: $AlbumName <br />";
							echo "Description: $AlbumDescription <br />";
							echo "Last Modified: $date_modified </a></div><hr>";
							}
						}
						
					$mysqli->close();
					
				?>	
				
	<!-- take a user back to the main page -->
	<div class = "fancy"><a class = "bottomlink" href="Index.php"><b>Back to Home page</b></a></div>
	
	</div>	
	
</body>
</html>