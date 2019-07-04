<?php
include('php/skryptSesja.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
		<link rel="stylesheet" href="css/arkusz.css"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	</head>
<body <?php //if(isset($_GET['id_element'])) echo "onload='myFunction()'";?>>
		<header>
			<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
				<a href="main.php?action=start" class="navbar-brand mb-1">Magazyn</a>
				
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="navButton">
					<span class="navbar-toggler-icon"></span>
				</button>
				
				<div class="collapse navbar-collapse" id="mainmenu">
					<ul class="navbar-nav mr-auto active">
						<li class="nav-item active"><a class="nav-link" href="main.php?action=start">Start</a></li>
						<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" href="">Modyfikacja danych z bazy</a>
							<div class="dropdown-menu" role="menu"> 
								<a class="dropdown-item" href="main.php?action=dodaj">Dodaj element do bazy</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="main.php?action=modyfikuj">Modyfikuj element w bazie</a>
							</div></li></ul>
						<form class="form-inline" method="post" action="main.php?action=logout"><input type="submit" value="Wyloguj" name="logout" class="btn btn-light ml-0"/></form>
				</div>
			
			</nav>
		</header>
		
		<div class="container">
			<section class="row">
				<div class=" col-md-6 leftDiv my-5 cl">
				<?php
				
				include("php/sql.php"); 
				include('php/klasa.php');
				$mysqli = @new mysqli($host,$userName,$passwd,$dbName);
				$mysqli->set_charset('utf8');
				$_SESSION['error_msg'] = '<p align="center"> Wystąpił nieoczekiwany błąd!</p>';
				
				$onclick='validate()';
				
				if(!isset($_GET['action']))
					$action = 'start';
				else
					$action = $_GET['action'];
			
				$checked=array(true,false);
				$napis = "Elementy dla projektu:";
				
					if(!isset($_SESSION['projekt']))
						$napis.="<br />Nie wybrano żadnego projektu!<br />Wybierz aby móc wykonywać operacje na danych!";
					else{
						$napis.="<br />";
						$napis.=$_SESSION['projekt']; 
					}
					
				switch($action){
					
					case 'start':
					
					$title='Strona główna';
					$header = 'Wybierz projekt';
					$formAction = 'main.php?action=wyborProjektu';
					$value=array('existing','delete');
					$label=array('Wybierz istniejący', 'Usuń wybrany');
					break;
					
					case 'modyfikuj':
					
					$title='Modyfikuj dane z bazy danych';
					$header = 'Modyfikuj dane z bazy';
					$formAction = 'main.php?action=modyfikujDane';
					$value=array('modify','delete');
					$label=array('Modyfikuj element', 'Usuń wybrany');
					if(isset($_GET['id_element'])){
						$id_proj=$_SESSION['id_proj'];
						$id_user=$_SESSION['id'];
						$_SESSION['id_el']=$id_el = $_GET['id_element'];
						$query ="SELECT  `quantity`, `requiredQuantity`, `id_cat`,  `parametr` FROM `parts` WHERE `id_proj`=$id_proj and `id_user`=$id_user and `id`=$id_el";
						$result=$mysqli->query($query);
						$r = $result->fetch_assoc();
						$ilosc=$r['quantity']; 
						$iloscW=$r['requiredQuantity'];
						$id_cat=$r['id_cat'];
						$parametr=$r['parametr'];
						$inputValue=array($parametr,$ilosc,$iloscW);
					}
					else
						$inputValue=array(null,null,null);
					break;
					
					case 'dodaj':
					
					$title='Dodaj dane do bazy danych';
					$header = 'Dodaj dane do bazy';
					$formAction = 'main.php?action=dodajDane';
					$inputValue=array(null,null,null);
					break;
					
					case 'wyborProjektu':
					require('php/wybor.php');
					break;
					
					case 'modyfikujDane':
					require('php/mod.php');
					break;
					
					case 'dodajDane':
					require('php/dod.php');
					break;
					
					case 'logout':
					require('php/logout.php');
					break;
					
					default:
					printf("%s",$_SESSION['error_msg']);
					break;
				}
					include('php/newForm.php');
				?>
				</div>
				<div class="col-md-6 rightDiv my-5 cl">
				<?php
				include('php/contentRight.php');
				?>
				</div>
				</section>
				</div>
		<title><?php printf("%s",$title);?></title>
		
		
		<script type="text/javascript">
		
		function myFunction(){
			//onload event
		}
		
		
		function setCookie(variable, value, expires_seconds) {
		var d = new Date();
		d = new Date(d.getTime() + 1000 * expires_seconds);
		document.cookie = variable + '=' + value + '; expires=' + d.toGMTString() + ';';
		}
		
		
		function reLoad(){
			var select = document.getElementById('sel1');
			var id;
			var option;
			for (var i = 0; i < select.options.length; i++){  
					option = select.options[i];
					if(option.selected){
					id = option.value;
					break;					
					}
			}
			window.location.href = "main.php?action=modyfikuj&id_element="+id;
		}
		
		
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
	
	
	function nowyProjekt(){
		var sel1 = document.getElementById('sel').value;
		if(sel1=='newPr'){
			document.getElementById('nowy').innerHTML = 
		"<p><label for='nowy'>Wprowadź nazwę nowego projektu:</label><input type='text' name='nowy' class='form-control' id='nowy' placeholder='Nowy projekt'/></p><p><label for='nowy1'>Wprowadź opis nowego projektu:</label> <textarea maxlenght='500' placeholder='Opis projektu' class='form-control' name='opis' id='nowy1'></textarea></p> ";
		document.getElementById('pr1').disabled=true;
		document.getElementById('pr2').disabled=true;
		document.getElementById('pr1').checked=false;
		document.getElementById('pr2').checked=false;
		}
		else if(sel1=='newCat'){
			document.getElementById('nowy').innerHTML =
		"<p><label for='nowy'>Wprowadź nazwę nowej kategorii:</label><input type='text' name='nowy' class='form-control' placeholder='Nowa kategoria' id='nowy'/></p>";
		}
		else{
			document.getElementById('nowy').innerHTML = "";
			document.getElementById('pr1').disabled=false;
			document.getElementById('pr2').disabled=false;
			document.getElementById('pr1').checked=true;
		}
	}
	
	
	function validate(){
		var form = document.forms[1];
		var sel1 = form.sel.value;
		var attribute = form.getAttribute('action');
		switch(attribute){//walidacja danych w formularzu zaleznie od parametru 'action'
			case 'main.php?action=wyborProjektu':
			{
				var radio = form.pr.value;
				switch(sel1){
					case 'newPr':
					if(form.nowy1.value=='')
							form.nowy1.value='Brak opisu';
					if(form.nowy.value!='')
						form.submit();
					else
						alert("Uzupełnij pole z nazwą nowego projektu!");
					break;
					case 'null':
					alert("Wybierz własciwy projekt!");
					break;
					default:
						
							switch(radio){
							
							case 'existing':
							form.submit();
							break;
							
							case 'delete':
							if(confirm("Czy napewno chcesz usunąć ten projekt?\nTej operacji nie da się cofnąć!"))
							form.submit();
							else
								alert("Projekt nie zostanie usunięty!");
							break;
							default:
							alert('Wystąpił nieoczekiwany błąd.');
							break;
							}
					break;
				}
			}
			break;
	
			case 'main.php?action=modyfikujDane':
			{
				var radio = form.pr.value;
				if(form.parametr.value=='')
					form.parametr.value="Brak";
				
				switch(radio){
							
							case 'modify':
							switch(sel1){
								case 'newCat':
								if(form.nowy.value!=''&&form.ilosc.value>=0&&form.iloscW.value>=0&&form.ilosc.value!=''&&form.iloscW.value!='')
									form.submit();
								if(form.nowy.value=='')
									alert('Uzupełnij pole z nazwą nowej kategorii!');
								if(form.ilosc.value==''||form.iloscW.value=='')
									alert("Uzupełnij pole wyrażające ilość poprawnie!");
								break;
								case 'null':
								alert("Wybierz własciwą kategorię!");
								break;
								default:
								if(form.ilosc.value>=0&&form.iloscW.value>=0&&form.ilosc.value!=''&&form.iloscW.value!='')
									form.submit();
								else if(form.ilosc.value==''||form.iloscW.value==''||form.ilosc.value<0||form.iloscW.value<0)
									alert("Uzupełnij pole wyrażające ilość poprawnie!");
								break;
							}
							break;
							
							case 'delete':
							if(confirm("Czy napewno chcesz usunąć ten element?\nTej operacji nie da się cofnąć!"))
							form.submit();
							else
								alert("Element nie zostanie usunięty!");
							
							break;
							default:
							alert('Wystąpił nieoczekiwany błąd.');
							break;
							}
			}
			break;
			
			case 'main.php?action=dodajDane':
			{
				if(form.parametr.value=='')
					form.parametr.value="Brak";
				
				switch(sel1){
					case 'newCat':
					if(form.nowy.value!=''&&form.ilosc.value>=0&&form.iloscW.value>=0&&form.ilosc.value!=''&&form.iloscW.value!='')
						form.submit();
					if(form.nowy.value=='')
						alert('Uzupełnij pole z nazwą nowej kategorii!');
					if(form.ilosc.value==''||form.iloscW.value=='')
						alert("Uzupełnij pole wyrażające ilość poprawnie!");
					break;
					case 'null':
					alert("Wybierz własciwą kategorię!");
					break;
					default:
					if(form.ilosc.value>=0&&form.iloscW.value>=0&&form.ilosc.value!=''&&form.iloscW.value!='')
						form.submit();
					else if(form.ilosc.value==''||form.iloscW.value==''||form.ilosc.value<0||form.iloscW.value<0)
						alert("Uzupełnij pole wyrażające ilość poprawnie!");
					break;
				}	
			}
			break;
			
			default:
			alert('Wystąpił nieoczekiwany błąd.');
			break;
		}
	}
	</script>
	

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="js/bootstrap.min.js"></script>
	</body>
</html>