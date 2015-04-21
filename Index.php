<?php 
session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Info 2300 Project Three - Index</title>
		<link rel="stylesheet" type="text/css" href="CSS/CSS.css">
		<link href='http://fonts.googleapis.com/css?family=Arizonia' rel='stylesheet' type='text/css'>
	</head>
	
<body>
<?php if (! isset( $_SESSION[ 'logged_user' ] ) ) {//If user is not logged in
	echo "<div class = 'contentbody'>
	<div class = 'header'>
	<ul class = 'nav'>
	     	<li><div class='activepage'><a href='Index.php'>Home</a></div></li>
			<li><a href='Albums.php'>Albums</a></li>
			<li><a href='Search.php'>Search</a></li>
			<li><a href='SignUp.php'>Sign Up</a></li>
			<li><a href='LogIn.php'>Log In</a></li>
	</ul></div>";
	
	}else{//User is logged in
	echo "<div class = 'contentbody'>
	<div class = 'header'>
	<ul class = 'navlarge'>
	     	<li><div class='activepage'><a href='Index.php'>Home</a></div></li>
	     	<li><a href='AddPhoto.php'>Add Photo</a></li>
			<li><a href='AddAlbum.php'>Add Album</a></li>
			<li><a href='Albums.php'>Albums</a></li>
			<li><a href='Search.php'>Search</a></li>
			<li><a href='SignUp.php'>Sign Up</a></li>
			<li><a href='LogOut.php'>Log Out</a></li>
	</ul></div>";}
	
	echo "<div class = 'fancy'><div>
		<h1>Photo Galleria</h1>
	</div>

	<div>
		<h3>Welcome to Photo Galleria. Here you will find an assortment of images and albums of various things. Enjoy! </h3>
		<br />
		<br />
		<br />
		<br />
	</div>

	</div>
	
	</div>";
	
	?>

</body>
</html>