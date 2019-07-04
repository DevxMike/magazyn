<?php
require_once('php/klasa.php');
session_start(); //start sesji
if(isset($_SESSION['zalogowany'])&&$_SESSION['zalogowany'] == true)
{
	header('Location: main.php');
	exit();
} //sprawdzenie czy user zalogowany
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
		<link rel="stylesheet" href="css/arkusz.css"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
		<title>Logowanie</title>
	</head>
<body>
		<div class="container mt-5">
			<section class="col-md-4 mx-auto"><br /> <br />
			<h1 align="center">Zaloguj się do magazynu</h1><br /> <br />
			<form align="center" class="form-inline-block" method="post" action="index.php?action=zaloguj">
			<?php
			$form = new Formularz();
				$form->poleTekstowe('form-control','userName','text','login',null, true,'Podaj login:');
				$form->poleTekstowe('form-control','passwd','password','hasło',null, true,'Podaj hasło:');
				//$form->submit('zaloguj', 'Zaloguj', 'btn btn-light');
				echo "<br />";
				$form->baton('zaloguj', 'Zaloguj', 'form-control', 'validate()');
			?>
			</form>
			<?php
					if(isset($_GET['action'])&&$_GET['action']=='zaloguj')
					{
						require('php/logowanie.php');
					}
					if(isset($_SESSION['blad']))
					{
						$blad = '<br /><p align="center"><span style = "color:red">Nieprawidłowy login lub haslo.</span></p>';
						printf("%s",$blad);
					}
			?>
			</section>
		</div>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="script.js" type="text/javascript"></script>
	<script type="text/javascript">
	
	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') 
				c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) 
				return c.substring(nameEQ.length,c.length);
		}
		return null;
	}
	
	function validate(){
		if(readCookie('errlog')==null)
			document.forms[0].submit();	
	}
	
	</script>
	</body>