<?php 
session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Info 2300 Project Three - Search</title>
		<link rel="stylesheet" type="text/css" href="CSS/CSS.css">
		<link href='http://fonts.googleapis.com/css?family=Arizonia' rel='stylesheet' type='text/css'>
	</head>
	
<body>
<?php 
	if (! isset( $_SESSION[ 'logged_user' ] ) ) {//If user is not logged in
	echo '<div class = "contentbody">
	<div class = "header">
	<ul class = "nav">
	     	<li><a href="Index.php">Home</a></li>
			<li><a href="Albums.php">Albums</a></li>
			<li><div class="activepage"><a href="Search.php">Search</a></div></li>
			<li><a href="SignUp.php">Sign Up</a></li>
			<li><a href="LogIn.php">Log In</a></li>
	</ul></div>';
	}else{//User is logged in
	echo "<div class = 'contentbody'>
	<div class = 'header'>
	<ul class = 'navlarge'>
	     	<li><a href='Index.php'>Home</a></li>
	     	<li><a href='AddPhoto.php'>Add Photo</a></li>
			<li><a href='AddAlbum.php'>Add Album</a></li>
			<li><a href='Albums.php'>Albums</a></li>
			<li><div class='activepage'><a href='Search.php'>Search</a></div></li>
			<li><a href='SignUp.php'>Sign Up</a></li>
			<li><a href='LogOut.php'>Log Out</a></li>
	</ul></div>";}
	
	?>
	
	
	<!-- Search goes here-->
			<br />
			
				<form id="profile" action="Search.php" method="post">
					Photo Title:&nbsp;&nbsp;<input type="text" name="photoTitle"><br /><br />
					Photo Keyword:&nbsp;&nbsp;<input type="text" name="photoKeyword"><br /><br />
					Album Name:&nbsp;&nbsp;<input type="text" name="albumTitle"><br /><br />
					Album Keyword:&nbsp;&nbsp;<input type="text" name="albumKeyword"><br /><br />
					<input type="submit" name="search" value="Search" />
				</form>
			<br />
			
	<?php
	
	require_once "config.php";
	$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );

	if (mysqli_connect_error() ){
        die("Can't connect to database: " . $mysqli->error);
    }
	
	if ( isset( $_POST['search'])){
		$photoTitle = filter_input( INPUT_POST, 'photoTitle', FILTER_SANITIZE_STRING );//The photo title
		$photoKeyword = filter_input( INPUT_POST, 'photoKeyword', FILTER_SANITIZE_STRING );//The photo keyword
		$albumTitle = filter_input( INPUT_POST, 'albumTitle', FILTER_SANITIZE_STRING );//The album title
		$albumKeyword = filter_input( INPUT_POST, 'albumKeyword', FILTER_SANITIZE_STRING );//The album keyword
		
		if (!empty($photoTitle) || !empty($photoKeyword) || !empty($albumTitle) || !empty($albumKeyword)){
		$query = "SELECT * FROM Relationships INNER JOIN Albums on Albums.aID = Relationships.aID INNER JOIN Photos on Relationships.pID = Photos.pID WHERE";
		if (!empty($photoTitle)){
			$query.= " PhotoName LIKE '%$photoTitle%' ";
			if (!empty($photoKeyword) || !empty($albumTitle) || !empty($albumKeyword)){
				$query.= "OR";
			}
		}
		if (!empty($photoKeyword)){
			$query.= " caption LIKE '%$photoKeyword%' ";
			if (!empty($albumTitle) || !empty($albumKeyword)){
				$query.= "OR";
			}
		}
		if (!empty($albumTitle)){
			$query.= " AlbumName LIKE '%$albumTitle%' ";
			if (!empty($albumKeyword)){
				$query.= "OR";
			}
		}
		if (!empty($albumKeyword)){
			$query.= " AlbumDescription LIKE '%$albumKeyword%'";
		}

		$result = $mysqli->query($query);
		
		if($result && $result->num_rows > 0){
			while($array = $result->fetch_assoc()){
				$PhotoName = $array['PhotoName'];
				$AlbumName = $array['AlbumName'];
				$caption = $array['caption'];
				$AlbumDescription = $array['AlbumDescription'];
				$image_url = $array['image_url'];
				$aID = $array['aID'];
				
				print" <p>Photo Name: $PhotoName<br />
						<p> Belongs to album: <a href = 'AlbumView?aID=$aID'>$AlbumName </a></p>
						<img src='$image_url' alt = 'Image'>
						<p>$caption </p><hr>";
				}//end while
			}//end result exists and greater than 0
			else{
				print "No search results found. Please try again.";//No results found because no entries in database
			}//end else
		}//end if empty
		else{
			print "No search results found. Please enter the search queries.";//No results found because no search entries
		}//end else
	}//end isset search
	
	$mysqli->close();
	
	?>
	
	<!-- take a user back to the main page -->
	<div class = "fancy"><a class = "bottomlink" href="Index.php"><b>Back to Home page</b></a></div>
	
	</div>

</body>
</html>