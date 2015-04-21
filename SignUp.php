<?php 
session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Info 2300 Project Three - Sign Up</title>
		<link rel="stylesheet" type="text/css" href="CSS/CSS.css">
		<link href='http://fonts.googleapis.com/css?family=Arizonia' rel='stylesheet' type='text/css'>
	</head>
	
<body>
<?php if (! isset( $_SESSION[ 'logged_user' ] ) ) {//If user is not logged in
	echo '<div class = "contentbody">
	<div class = "header">
	<ul class = "nav">
	     	<li><a href="Index.php">Home</a></li>
			<li><a href="Albums.php">Albums</a></li>
			<li><a href="Search.php">Search</a></li>
			<li><div class="activepage"><a href="SignUp.php">Sign Up</a></div></li>
			<li><a href="LogIn.php">Log In</a></li>
	</ul></div>';
	}else{//User is logged in
	echo "<div class = 'contentbody'><div class = 'header'>
	<ul class = 'navlarge'>
	     	<li><a href='Index.php'>Home</a></li>
	     	<li><a href='AddPhoto.php'>Add Photo</a></li>
			<li><a href='AddAlbum.php'>Add Album</a></li>
			<li><a href='Albums.php'>Albums</a></li>
			<li><a href='Search.php'>Search</a></li>
			<li><div class='activepage'><a href='SignUp.php'>Sign Up</a></div></li>
			<li><a href='LogOut.php'>Log Out</a></li>
	</ul></div>";}
	
	?>
	
	<!-- Sign Up goes here-->
	<!--Sign Up page credit to Alice Shan, although it is not implemented-->
        <p>Create an account to obtain unrestricted access to all administrative actions, and contribute to the archives yourself!</p>
        <p>**For both usernames and passwords, please limit yourself to uppercase and lowercase letters and numbers**</p>
        
        
		<form class="form" action="SignUp.php" method="post">
		Username:&nbsp;&nbsp;<input type="text" name="username" /><br/>
		Password:&nbsp;&nbsp;<input type="password" name="password" /><br /><br />
		<input type="submit" name="submit" value="Create Account" onclick = "return showMessage()" />
		<script type = "text/javascript">
			function showMessage() {
				alert ("This feature will be implemented at a later time. Thank you for using my website!");
			return true;
		}
		</script>
		</form>
		<noscript>This feature will be implemented at a later time. Thank you for using my website!</noscript>
		<br />
		<br />
	
	<!-- take a user back to the main page -->
	<div class = "fancy"><a class = "bottomlink" href="Index.php"><b>Back to Home page</b></a></div>
	
	</div>
	
</body>
</html>