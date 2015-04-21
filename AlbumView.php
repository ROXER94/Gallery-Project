<?php 
session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Info 2300 Project Three - Album Viewing</title>
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
			<li><a href="LogIn.php">Log In</a></li>
	</ul></div>';
	}else{//User is logged in
	$update = true;
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
	</ul></div>";
	//Update Albums go here
	}	
	
	require_once "config.php";
	$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );

	if (mysqli_connect_error() ){
        die("Can't connect to database: " . $mysqli->error);
    }
	
	else{		
		$aID = filter_input( INPUT_GET, 'aID', FILTER_SANITIZE_NUMBER_INT );
		if ( isset( $_POST['delete'])){
			$pID = $_POST['pID'];
			$mysqli->query("DELETE FROM Photos
							WHERE pID = '$pID'");
			print "<br /> Deletion was successful.<br />";
			}
		
		if ( $aID == 0 ){
			//Each photo div of uncategorized album
			$UNCresult  = $mysqli->query("SELECT * FROM Photos WHERE Photos.pID NOT IN (SELECT pID FROM Relationships)");
			if($UNCresult && $UNCresult->num_rows > 0){
				while($array = $UNCresult->fetch_assoc()){
					$pID = $array['pID'];
					$UNCPhotoName = $array['PhotoName'];
					$UNCcaption = $array['caption'];
					$UNCimage_url = $array['image_url'];
					$UNCdate_taken = $array['date_taken'];
				print"<div class='box'>
						<p>Photo Name: $UNCPhotoName<br />
						<div class = 'overlay'>
						<p>$UNCcaption<br />
						Date Taken: $UNCdate_taken</p>
						</div>
						<img src='$UNCimage_url' alt = 'Image'></div>";
				if ($update){
					print '<form id="delete" name="delete" action="AlbumView.php?aID='.$aID.'" method="post">
						<input type="hidden" name="pID" value = "'.$pID.'" >
						<input type="submit" name="delete" value="Delete this photo" /></form>';
					print "<br /><a href = 'UpdatePhotos.php?pID=$pID'>Update photo</a></p>";
					}
				print "<hr>";
				}
			} else {
				print "<p>All photos in the database belong to an album =P</p>";
			}
		} else {

		//Album div Header
		$atitle = $mysqli->query("SELECT * FROM Relationships INNER JOIN Albums on Albums.aID = Relationships.aID INNER JOIN Photos on Relationships.pID = Photos.pID WHERE Albums.aID =".$aID);
		if($atitle && $atitle->num_rows > 0){
			$atitlearray = $atitle->fetch_assoc();
				$AlbumName = $atitlearray['AlbumName'];
				$date_created = $atitlearray['date_created'];
				$date_modified = $atitlearray['date_modified'];
				print "<p>Album Name: $AlbumName<br />
							 Date Created: $date_created<br />
							 Date Modified: $date_modified";
							if ($update){
							 print "<br /><a href = 'UpdateAlbums.php?aID=$aID'>Update Album</a></p>";
							 }else{
								print "</p>";
							}
		}				
		
		//Each photo div	
		$result = $mysqli->query("SELECT * FROM Relationships INNER JOIN Albums on Albums.aID = Relationships.aID INNER JOIN Photos on Relationships.pID = Photos.pID WHERE Albums.aID =".$aID);
		if($result && $result->num_rows > 0){
			while($array = $result->fetch_assoc()){
				$pID = $array['pID'];
				$PhotoName = $array['PhotoName'];
				$caption = $array['caption'];
				$image_url = $array['image_url'];
				$date_taken = $array['date_taken'];
				print"<div class='box'>
						<p>Photo Name: $PhotoName<br />
						<div class = 'overlay'>
						<p>$caption<br />
						Date Taken: $date_taken</p>
						</div>
						<img src='$image_url' alt = 'Image'></div>";
				if ($update){
					print '<form id="delete" name="delete" action="AlbumView.php?aID='.$aID.'" method="post">
						<input type="hidden" name="pID" value = "'.$pID.'" >
						<input type="submit" name="delete" value="Delete this photo" /></form>';
					print "<br /><a href = 'UpdatePhotos.php?pID=$pID'>Update photo</a></p>";
					}
				print"<hr>";
				}
			}else {
				if ($update){
				print "<br /><a href = 'UpdateAlbums.php?aID=$aID'>Update Album</a></p>";
				}
				print "<p>There are no photos currently in this album >.<</p>";
			}
		}
	}
	
		$mysqli->close();
		
	?>
	
	<!-- take a user back to the Album page -->
<div class = "fancy"><a class = "bottomlink" href="Albums.php"><b>Back to Albums page</b></a></div>

	<!-- take a user back to the Main page -->
<div class = "fancy"><a class = "bottomlink" href="Index.php"><b>Back to Home page</b></a></div>

</div>

</body>
</html>