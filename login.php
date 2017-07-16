<?php

session_start();

$username = $_POST['username'];

$password = $_POST['password'];
$user='root';
$pass='';
$db='login';

if($username&&$password){
$connect =new mysqli('localhost',$user,$pass,$db) or die("Couldn't connect to database");

$result =$connect->query("SELECT * FROM users WHERE username='$username'");


$numrows = $result->num_rows;

if($numrows!==0)
{
	while($row =$result->fetch_assoc())
	{
	  $dbusername =$row['username'];
	  $dbpassword =$row['password'];

		
	}
	if($username==("admin")&&$password==("admin1234"))
	{
		@$_SESSION['username'] = $username;
		@$_SESSION['password'] = $password;
		header("location:admin.php");
	}
	elseif($username==$dbusername&&$password==$dbpassword)
	{
		echo"you are logged in";
		@$_SESSION['username'] = $username;
	}
	else
		echo"your password is incorrect";


}
else
 die("That user doesn't exists"); 


}
else 
	die("please enter a username and password");
?>