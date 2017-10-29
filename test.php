<?php
$link = new mysqli("localhost","root","P0rterteh","p3");


if ($link->connect_errno) {

    printf("Connect failed: %s\n", $link->connect_error);

    exit();

}

$loggedin=false;

session_start();

if(isset($_SESSION['user']))   // Checking whether the session is already there or true then header redirect it to the home page directly 
	{
		header("Location:playgame.php"); 
	}

else

	$action='none';

if(isset($_REQUEST["action"]))

	$action = $_REQUEST["action"];

else

	$action = "none";

if($action=='login')   // it checks whether the user clicked login button or not 

{

    $username = $_POST['username'];

    $password = $_POST['password'];

    $name = htmlentities($link->real_escape_string($username));

	$password = htmlentities($link->real_escape_string($password));

	//$password = crypt ($password,"abc123");

	$result = $link->query("SELECT * FROM user WHERE username='$name';");

	if(!$result)

		die ('Can\'t query users because: ' . $link->error);
	
	$num_rows = mysqli_num_rows($result);


	if ($num_rows > 0) {

		$row = $result->fetch_assoc();

		if($row["password"] == $password){

			$_SESSION['username']=$name;

			$sql="SELECT username FROM user WHERE username ='" . $name . "'";

			$result = $link->query($sql); //issue

			$data=mysqli_fetch_assoc($result);

			$id =$data['id'];

			$_SESSION['id']=$id;

			echo "<h2>User $name logged in!";

			$loggedin=true;

			header('Location:playgame.php');

		}

		else{
	  		echo "<h2>Invalid UserName or Password</h2";

        }

    }

   	  else{

    		echo '<h2>No users created</h2>';} 
}

?>





<!DOCTYPE html>

<html>

	<head>

		<title>Welcome</title>

		<script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
		<link href='proj3.css' type="text/css" rel="stylesheet" />
		<link href='login_style.css' type='text/css' rel='stylesheet' />

		<link href="https://fonts.googleapis.com/css?family=Volkhov" rel="stylesheet" />

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">



		<!-- Latest compiled and minified JavaScript -->

		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		

	</head>

<header>

<center>

	<nav class="navbar navbar-inverse">

		<div class="container-fluid">

			<div class="navbar-header">

				<a href="homepage.php" class="navbar-brand">Definitely Not Connect 4</a>

			</div>
		</div>

	</nav>	</header>

	<body>

	<div align='left'>

		<h2>Please login to play a game</h2>
		</br>
		</br>
		</br>
		<div id=form2>

		Login: 

		<form method="post" action="test.php" name="login">

			Username: <input type="text" name="username" /> <br><br>

			Password: <input type="password" name="password" /> <br>

			<input type="hidden" name="action" value="login" />

			<input type="Submit" value="Go"/>
		</form>
		</div>
	</div>
	<br/>
	</body>
</html>
