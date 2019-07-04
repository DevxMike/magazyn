<h2>
<?php 
printf("%s",$header); 
?>
</h2> 
<form action=
'<?php 
printf("%s",$formAction); 
?>' 
align="center" class="form-inline-block" method="post"><br /><br />
<p>
<?php  
$id_user=$_SESSION['id'];
$form = new Formularz(); 
if($action=='start'){
	$tekst = 'Wybierz projekt:';
	$stOP = "<option value='null'>---Wybierz projekt---</option>";
	$lsOP = "<option value='newPr'>Nowy projekt</option>";
	$name='projekt';
	$query = "SELECT `id_proj`, `name` FROM `projects` WHERE `id_user`=$id_user";
}
else{
	$tekst = 'Wybierz kategorie:';
	$stOP = "<option value='null'>---Wybierz kategorie---</option>";
	$lsOP = "<option value='newCat'>Nowa kategoria</option>";
	$name='kategoria';
	$query = "SELECT `id_cat`, `name` FROM `categories` WHERE `id_user`=$id_user";
}
$result = $mysqli->query($query);
if($action=='modyfikuj'&&isset($_GET['id_element']))
$form->select($name,$tekst,$result->num_rows,$result,'form-control',$stOP,$lsOP,"onchange='nowyProjekt()'",'sel',$id_cat,$_GET['id_element']);
else
	$form->select($name,$tekst,$result->num_rows,$result,'form-control',$stOP,$lsOP,"onchange='nowyProjekt()'",'sel',null,null);
	$result->close();
?>
</p>
<div id='nowy'></div>
<?php if($action!='start'){
echo"<p>";
$form->poleTekstowe('form-control','parametr','text','Parametr',$inputValue[0], false,'Podaj parametr elementu:');
echo "</p><p>";
$form->poleTekstowe('form-control','ilosc','number','Ilość elementów',$inputValue[1], false,'Podaj ilość dostępnych elementów:');
echo "</p><p>";
$form->poleTekstowe('form-control','iloscW','number','Wymagana ilość elementów',$inputValue[2], false,'Podaj wymaganą ilość elementów:');
}
if($action != 'dodaj'){
	$id=array('pr1','pr2');
	echo "<br /><p>";
	for($i=0;$i<2; $i++){
		$form->radio('pr',$id[$i],$value[$i],$label[$i],$checked[$i]);
		echo "<br />";
	}
	echo "</p>";
}
else
	echo "<br />";
echo"<p>";
$form->baton('baton', 'Prześlij', 'form-control', $onclick);
echo "</p>";
$form->__destruct();
?>
</form>