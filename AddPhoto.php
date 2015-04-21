<?php 
session_start(); //If we ARE Logged In?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Info 2300 Project Three - Add Photo</title>
		<link rel="stylesheet" type="text/css" href="CSS/CSS.css">
		<link href='http://fonts.googleapis.com/css?family=Arizonia' rel='stylesheet' type='text/css'>
	</head>
	
<body>
	<div class = "contentbody">
	<div class = 'header'>
	<ul class = "navlarge">
	     	<li><a href="Index.php">Home</a></li>
	     	<li><div class="activepage"><a href="AddPhoto.php">Add Photo</a></div></li>
			<li><a href="AddAlbum.php">Add Album</a></li>
			<li><a href="Albums.php">Albums</a></li>
			<li><a href="Search.php">Search</a></li>
			<li><a href="SignUp.php">Sign Up</a></li>
			<li><a href="LogOut.php">Log Out</a></li>
	</ul></div>

		<!-- Adding Photos goes here-->
		<br />
		<form id="upload" action="AddPhoto.php" method="post" enctype="multipart/form-data">
				<label for="newPhoto">Photo To Upload:&nbsp;&nbsp;</label><input type="file" name="newPhoto" id="newPhoto"><br />
				<label for="title">Photo Title:&nbsp;&nbsp;</label><input type="text" name="title" id="title" placeholder="Name of Photo"><br />
				<textarea name="description" rows="5" cols="34" placeholder="Please Describe The Photo"></textarea><br />
				Select Date Taken:&nbsp;&nbsp;
				<input type="date" name="date" min="1900-01-01" max = "2020-12-31"><br />
				
				Choose Album:&nbsp;&nbsp;
				<select name="currentAlbums">
					<?php 
					
					require_once "config.php";
					$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );

					if (mysqli_connect_error() ){
						die("Can't connect to database: " . $mysqli->error);
					}
					
					$Albumquery = $mysqli->query("SELECT * FROM Albums");
					if($Albumquery && $Albumquery->num_rows > 0){
						while($Albumqueryarray = $Albumquery->fetch_assoc()){
							$AlbumName = $Albumqueryarray['AlbumName'];
							$theaID = $Albumqueryarray['aID'];
							echo "<option value = '$theaID'>$AlbumName</option>";
							}
							echo "</select>";
						}
						
					$mysqli->close();
					
					?>
				
				<input id="uploadButton" type="submit" name="upload" value="Upload" />
		</form>
		
		<?php
		$valid = true;
		require_once "config.php";
		$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );

		if (mysqli_connect_error() ){
			die("Can't connect to database: " . $mysqli->error);
		}
		
			//Check to see if a file was uploaded using the "single file" form
			if ( ! empty( $_FILES['newPhoto'] ) ) {
			
			// Auto-increment the pID myself
			$maxpID = $mysqli->query("SELECT MAX(pID) as pID FROM Photos");
				if($maxpID && $maxpID->num_rows > 0){
					$maxpIDarray = $maxpID->fetch_assoc();
						$maximumpID = $maxpIDarray['pID'];
				}
			$pID = $maximumpID+1;
			
			$regexTitle = "/^[a-zA-Z0-9 ]+/i";
			$regexDescription = "/^[a-zA-Z0-9 ]+/i";
			$regexYear = "/^[0-9]{4}$/i";
	
			$newPhoto = $_FILES['newPhoto'];
			$Title = $_POST["title"];
			$Title = trim($Title);
			$aID = $_POST["currentAlbums"];
			$Description = $_POST["description"];
			$Description = trim($Description);
			$originalName = $newPhoto['name'];
			
			$date = $_POST["date"];
			$year = substr($date,0,4);
			$month = substr($date,5,2);
			$day = substr($date,8,2);
			
			if ($year < 1900 || $year > 2020 || $month < 1 || $month > 12 || $day < 1 || $day > 31){
				print("Please enter a valid year, month, and day.");
				$valid = false;
			} else if(!preg_match($regexTitle,$Title) || strlen($Title) <= 0 || strlen($Title) > 32){
				print("Photo Title must contain alphabetic letters and/or numerals between 1 and 32 characters");
				$valid = false;
			} else if(!preg_match($regexDescription,$Description) || strlen($Description) <= 0 || strlen($Description) > 100){
				print("Description must contain alphabetic letters and/or numerals between 1 and  100 characters");
				$valid = false;
			} else if ($valid){
			// Check if the uploaded file is a PNG, JPG, or GIF AND less than 2.5 MB	
			if( (( $_FILES['newPhoto']['type'] == "image/jpeg" ) || ( $_FILES['newPhoto']['type'] == "image/gif" ) || ( $_FILES['newPhoto']['type'] == "image/png" )) 
						&& ( $_FILES['newPhoto']['size'] < 2621440 ) ){
				
				//If there is no error
				if ( $newPhoto['error'] == 0 ) {
					
					$path_parts = pathinfo($_FILES["newPhoto"]["name"]);
					$image_path = $path_parts['filename'].'_'.microtime().'.'.$path_parts['extension'];
					
					move_uploaded_file( $_FILES['newPhoto']['tmp_name'], "Images/".$image_path);
					//$_SESSION['photos'][] = $originalName;
					print("<p>The file $originalName was uploaded successfully.</p>");
					
					$mysqli->query("INSERT INTO Photos (pID, PhotoName, caption, image_url, date_taken)
										VALUES( '$pID', '$Title', '$Description', 'Images/$image_path', '$date' )");
					if ( $aID != 0) {
						$mysqli->query("INSERT INTO Relationships (pID, aID)
										VALUES( '$pID', '$aID')");
					}
					
					$mysqli->query("Update Albums
									SET date_modified = CURDATE()
									WHERE aID = '$aID'");
					//require_once 'resize.php';
					//save_thumbnail( "Images/$originalName", "thumbnails/$originalName", 200 );
				} else {
					print("<br /><p>Error: The file $originalName was not uploaded.</p>");
				}
			} else {
				print("<br /><p>Error: Invalid file. Please upload only images (JPG or PNG) and gifs under 2.5MB.</p>");
			}
		}
	}
		$mysqli->close();
		
	?>
	
	<br />
	<br />
	<br />
	
	<!-- take a user back to the main page -->
	<div class = "fancy"><a class = "bottomlink" href="Index.php"><b>Back to Home page</b></a></div>
	
	</div>
	
</body>
</html>