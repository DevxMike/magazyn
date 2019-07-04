<?php
session_start();
if(!isset($_POST['userName'])||!isset($_POST['passwd'])||isset($_COOKIE['errlog'])) 
{
	header('location:./index.php');
	exit();
}

require_once "sql.php"; 
require_once('klasa.php');
$connection = @new mysqli($host,$userName,$passwd,$dbName);
if($connection->connect_errno!=0)
{
	echo "Error".$connection->connect_errno; //obsluga bledu przy laczeniu do bazy
}
else
{
	$userName=$_POST['userName'];
	$password = $_POST['passwd'];
	if(isset($userName)&&isset($password)){
		
		$userName=htmlentities($userName,ENT_QUOTES,"UTF-8");
		$password=htmlentities($password,ENT_QUOTES,"UTF-8");
		$result = @$connection->query(sprintf("SELECT * FROM `users` WHERE BINARY `userName`='%s' AND BINARY `password`='%s'",
		mysqli_real_escape_string($connection,$userName),
		mysqli_real_escape_string($connection,$password)));
		if($result->num_rows>0&&!isset($_COOKIE['errlog']))
		{
			
			$_SESSION['zalogowany']=true;
			$r=$result->fetch_assoc();
			$_SESSION['user'] = $r['user'];
			$_SESSION['id'] = $r['id'];
			unset($_SESSION['blad']);
		    unset($_COOKIE['errlog']);
			$_SESSION['bezbledu']=true;
			$result->close();
		       header("location:main.php");
		}
		else
		{
			setcookie('errlog','true',time()+5);
			$_SESSION['blad']=true;
			header('location:./index.php');
		}
	}		
	else{
		
		setcookie('errlog','true',time()+5);
		$_SESSION['blad']=true;
		header('location:./index.php');
	}
	$_POST=array();
	$connection->close();
}
	
?>