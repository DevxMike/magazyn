<?php
session_start();
if(!isset($_SESSION['zalogowany']))
{
	header('Location:index.php');//przeniesienie na strone logowania
	exit();
}
?>