<?php 
session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Info 2300 Project Three - Update Albums</title>
		<link rel="stylesheet" type="text/css" href="CSS/CSS.css">
		<link href='http://fonts.googleapis.com/css?family=Arizonia' rel='stylesheet' type='text/css'>
	</head>
	
<body>
<?php if (! isset( $_SESSION[ 'logged_user' ] ) ) {//If user is not logged in
	$update = false;
	echo '<div class = "contentbody">
	<div class = "header">
	<ul class = "nav">
	     	<li><a href="Index.php">Home</a></li>
			<li><a href="Albums.php">Albums</a></li>
			<li><a href="Search.php">Search</a></li>
			<li><a href="SignUp.php">Sign Up</a></li>
			<li><a href="LogIn.php">Log In</a></li></ul></div>';
	echo '<br /><br /> This page is only viewable for the admin. Please log in to access this content.<br /><br /><a href="LogIn.php">Log In</a></div>';
	}else{//User is logged in
	
	$pID = filter_input( INPUT_GET, 'pID', FILTER_SANITIZE_NUMBER_INT );
	//if( gettype($pID) != 'integer'){
		//$pID=1;
	//}
	
	require_once "config.php";
	$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );

	if (mysqli_connect_error() ){
        die("Can't connect to database: " . $mysqli->error);
    }
	
	$UNCresult  = $mysqli->query("SELECT * FROM Photos WHERE Photos.pID NOT IN (SELECT pID FROM Relationships) AND pID =".$pID);
	$result = $mysqli->query("SELECT * FROM Relationships INNER JOIN Albums on Albums.aID = Relationships.aID INNER JOIN Photos on Relationships.pID = Photos.pID WHERE Photos.pID =".$pID);
	if ((!empty($result) && $result->num_rows == 1) || (!empty($UNCresult) && $UNCresult->num_rows == 1)){//Checks if it is in the Uncategozied album or elsewhere
	$array = $result->fetch_assoc();
		$aID = $array['aID'];
		$AlbumName = $array['AlbumName'];
		//This is for the fancy links to take back to the Uncategorized album
		if (empty($aID)){//Checks if $aID is empty. If it is, set it to 0.
			$aID=0;
		}
		if (empty($AlbumName)){//Checks if $AlbumName is empty. If it is, set it to Uncategorized.
			$AlbumName='Uncategorized';
		}	
	
	$valid = true;
	$update = false;
	$nametest = false;
	$captiontest = false;
	
	$regexTitle = "/^[a-zA-Z0-9 ]+/i";
	$regexDescription = "/^[a-zA-Z0-9 ]+/i";
	
	$newphotoname = filter_input( INPUT_POST, 'newphotoname', FILTER_SANITIZE_STRING );//The new Photo name
	$newphotoname = trim($newphotoname);
	$newphotocaption = filter_input( INPUT_POST, 'newphotocaption', FILTER_SANITIZE_STRING );//The new Photo caption
	$newphotocaption = trim($newphotocaption);
	
	if ( isset( $_POST['update'])){//If Update is pressed
		if ( isset( $_POST['newphotoname'] ) && isset( $_POST['newphotocaption'] ) ) {
			if(!preg_match($regexTitle,$newphotoname) || strlen($newphotoname) <= 0 || strlen($newphotoname) > 32){
				$valid = false;
				$nametest=true;
			} else if(!preg_match($regexDescription,$newphotocaption) || strlen($newphotocaption) <= 0 || strlen($newphotocaption) > 100){
				$valid = false;
				$captiontest=true;
			} else if ($valid){
				$mysqli->query("Update Photos
									SET PhotoName = '$newphotoname', caption = '$newphotocaption'
									WHERE pID = '$pID'");
				$update = true;
				}
		}else{
			print "<br />Please change both the title and description.";
		}
	}
	
	
	
	$result = $mysqli->query("SELECT * FROM Photos Where pID =".$pID);
	if(!empty($result) && $result->num_rows == 1){//No such albums exists
			$array = $result->fetch_assoc();
			$PhotoName = $array['PhotoName'];
			$ImageURL = $array['image_url'];
			$caption = $array['caption'];
			

				
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
	</ul></div>
	<br /><br />";
	
	echo "$PhotoName<br />";
	echo "<img src='$ImageURL' alt = 'Image'><br />";
	echo "$caption";
	
	//Update form go here
	echo '<form class="form" action="UpdatePhotos.php?pID='.$pID.'" method="post">
	Photo Name: <input type="text" name="newphotoname" />
    Photo Caption: <input type="text" name="newphotocaption" />
    <input type="submit" name="update" value="Update Photo" /></form>';
	
	if($update){
		print "<br /> Changes were successfully made.";
	}
	
	if($nametest){
		print("Photo Name must contain alphabetic letters and/or numerals between 1 and 32 characters<br />");
	}
	if($captiontest){
		print("Caption must contain alphabetic letters and/or numerals between 1 and  100 characters<br />");
	}
	
	echo "<!-- take a user back to the that specific album page -->";
	echo '<br /><div class = "fancy"><a class = "bottomlink" href="AlbumView.php?aID='.$aID.'"><b>Back to '.$AlbumName.' album</b></a></div>';
	
	echo "<!-- take a user back to the Album page -->";
	echo '<div class = "fancy"><a class = "bottomlink" href="Albums.php"><b>Back to Albums page</b></a></div>';

	echo "<!-- take a user back to the Main page -->";
	echo '<div class = "fancy"><a class = "bottomlink" href="Index.php"><b>Back to Home page</b></a></div>';
	
	$mysqli->close();
	
	}else{
		if($update){
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
					</ul></div>
					<br /><br />";
		} else if (!empty($result)){//For numbers entered larger than the amount of photos in database
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
					</ul></div>
					<br /><br />";
			print "<br /> No such photo exists. Try again. <a href = 'Albums.php'>Back to Albums page</a><br /><br />";
		}else{
			echo '<div class = "contentbody">
					<div class = "header">
					<ul class = "nav">
					<li><a href="Index.php">Home</a></li>
					<li><a href="Albums.php">Albums</a></li>
					<li><a href="Search.php">Search</a></li>
					<li><a href="SignUp.php">Sign Up</a></li>
					<li><a href="LogIn.php">Log In</a></li></ul></div>';
			echo '<br /><br /> This page is only viewable for the admin. Please log in to access this content.<br /><br /><a href="LogIn.php">Log In</a></div>';
		}
	}
}else{
	if ( isset( $_SESSION[ 'logged_user' ] ) ) {
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
					</ul></div>
					<br /><br />";
					print "<br /> No such photo exists. Try again. <a href = 'Albums.php'>Back to Albums page</a><br /><br /></div>";
	}else{//end else for admin viewing
		echo '<div class = "contentbody">
					<div class = "header">
					<ul class = "nav">
					<li><a href="Index.php">Home</a></li>
					<li><a href="Albums.php">Albums</a></li>
					<li><a href="Search.php">Search</a></li>
					<li><a href="SignUp.php">Sign Up</a></li>
					<li><a href="LogIn.php">Log In</a></li></ul></div>';
					print "<br /> No such photo exists. Try again. <a href = 'Albums.php'>Back to Albums page</a><br /><br /></div>";
	
	}//end else for public viewing
	
	
	
	}//end else
}
	
	?>
	
</body>
</html>