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

<?php if ( isset( $_SESSION[ 'logged_user' ] ) ) { ?>
<div class = 'contentbody'>
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
	<?php
	$aID = filter_input( INPUT_GET, 'aID', FILTER_SANITIZE_NUMBER_INT );
	
	require_once "config.php";
	$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );

	if (mysqli_connect_error() ){
        die("Can't connect to database: " . $mysqli->error);
    }
	
	$fancycheck = false;
	$delete = true;
	
	$result = $mysqli->query("SELECT AlbumName FROM Albums Where aID =".$aID);
	if(!empty($result) && $result->num_rows == 1){//No such albums exists
			$array = $result->fetch_assoc();
			$AlbumName = $array['AlbumName'];
			
	$update = false;
	
	$valid = true;
	$regexTitle = "/^[a-zA-Z0-9 ]+/i";
	$regexDescription = "/^[a-zA-Z0-9 ]+/i";
	
	$titletest = false;
	$descriptiontest = false;
	
	$newalbumTitle = filter_input( INPUT_POST, 'newalbumtitle', FILTER_SANITIZE_STRING );//The new Album name
	$newalbumTitle = trim($newalbumTitle);
	$newalbumdescription = filter_input( INPUT_POST, 'newalbumdescription', FILTER_SANITIZE_STRING );//The new Album description
	$newalbumdescription = trim($newalbumdescription);
	
	if ( isset( $_POST['update'])){//If Update is pressed
		if ( isset( $_POST['newalbumtitle'] ) && isset( $_POST['newalbumdescription'] ) ) {
			if(!preg_match($regexTitle,$newalbumTitle) || strlen($newalbumTitle) <= 0 || strlen($newalbumTitle) > 32){
				$valid = false;
				$titletest = true;
			} else if(!preg_match($regexDescription,$newalbumdescription) || strlen($newalbumdescription) <= 0 || strlen($newalbumdescription) > 100){
				$valid = false;
				$descriptiontest = true;
			} else if ($valid){
				$mysqli->query("Update Albums
									SET AlbumName = '$newalbumTitle', AlbumDescription = '$newalbumdescription', date_modified = CURDATE()
									WHERE AlbumName = '$AlbumName'");
				$update = true;
				}
		}else{
			print "<br />Please change both the title and description.";
		}
	}
	
	if ( isset( $_POST['delete'])){//Else Delete is pressed
			$mysqli->query("Delete FROM Albums
						WHERE AlbumName = '$AlbumName'");
			$delete = false;
	}
	
	if ($delete){
	echo '<form class="form" action="UpdateAlbums.php?aID='.$aID.'" method="post">';
		?>
	<h1>Update Album: <?php 
	if ($update){
		echo $newalbumTitle;
	} else {
		echo $AlbumName; 
	}
	?></h1>
    <p>Album Title: <br /><input type="text" name="newalbumtitle" /></p>
    <p>Album Description: <br/><textarea name="newalbumdescription" row=5 cols=30></textarea></p>
    <p><input type="submit" name="update" value="Update Album" /></p>
	
	<?php
	if ($update){
		print "<br /> Changes were successfully made.";
	}
	if ($titletest){
		print("Album Title must contain alphabetic letters and/or numerals between 1 and 32 characters");
	}
	if ($descriptiontest){
		print("Description must contain alphabetic letters and/or numerals between 1 and  100 characters");
	}
	?>
	
    <hr>
    <h3>Delete Album</h3>
    <p>Click to delete this album from the archives. Note that the photos in this album will not be deleted, and can still be
    viewed in the uncategorized photos page!</p>
    <p><input type="submit" name="delete" value="Delete Album" /></p>
</form>

	<?php
		} else {
			print "<br /> Deletion was successful.<br /><br />";		
			
		}
	} else {
		print "<br /> No such album exists. Try again.<br /><br />";
		$fancycheck = true;
	}
		
	$mysqli->close();
	if(!$fancycheck){
		if($delete){
			echo "<!-- take a user back to the that specific album page -->";//Don't include if deletion is success
			echo '<div class = "fancy"><a class = "bottomlink" href="AlbumView.php?aID='.$aID.'"><b>Back to '.$AlbumName.' album</b></a></div>';
		}
	}
	?>
	
	<!-- take a user back to the Album page -->
<div class = "fancy"><a class = "bottomlink" href="Albums.php"><b>Back to Albums page</b></a></div>

	<!-- take a user back to the Main page -->
<div class = "fancy"><a class = "bottomlink" href="Index.php"><b>Back to Home page</b></a></div>

	</div>
<?php
}else{
	echo '<div class = "contentbody">
	<div class = "header">
	<ul class = "nav">
	     	<li><a href="Index.php">Home</a></li>
			<li><a href="Albums.php">Albums</a></li>
			<li><a href="Search.php">Search</a></li>
			<li><a href="SignUp.php">Sign Up</a></li>
			<li><a href="LogIn.php">Log In</a></li>
	</ul></div>';
	echo '<br /><br /> This page is only viewable for the admin. Please log in to access this content.<br /><br /><a href="LogIn.php">Log In</a></div>';
	}
	?>
</body>
</html>