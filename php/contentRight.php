<?php
if(isset($napis))
	printf("<h2>%s</h2>",$napis);//heading w prawym panelu
$id_user=$_SESSION['id'];
if(isset($_SESSION['id_proj']))
	$id_proj = $_SESSION['id_proj'];
switch($action){
	case 'start':
	if(isset($_SESSION['projekt'])&&isset($_SESSION['id_proj'])){
	$query="SELECT `description` FROM `projects` WHERE `id_proj`=$id_proj and `id_user`=$id_user";
	$result = $mysqli->query($query);
	$r = $result->fetch_assoc();
	$opis=$r['description'];
	printf("<br /><p align='center'>%s</p>",$opis);
	$query ="SELECT `name`, `quantity`, `requiredQuantity`, `id_cat`, `parametr` FROM `parts` WHERE `id_proj`=$id_proj and `id_user`=$id_user";
	$result1=$mysqli->query($query);
	if($result1->num_rows>0){
	echo"<br /><table class='table table-sm table-dark tab-txt mx-auto'>
		<thead>
			<tr>
			<th scope='col'>#</th>
			<th scope='col'>Element</th>
			<th scope='col'>Ilosc</th>
			<th scope='col'>Potrzebnych</th>
			<th scope='col'>Kategoria</th>
			</tr>
		</thead>
		<tbody>";
	$i=1;
	while($r1=$result1->fetch_assoc()){
		
		if($r1['quantity']<$r1['requiredQuantity'])
			$klasa='bg-danger';
		else if($r1['quantity']==$r1['requiredQuantity'])
			$klasa='bg-warning';
		else $klasa='';
		
		if($r1['parametr']!='Brak'){
			$nazwa = $r1['name']." ".$r1['parametr'];
		}
		else
			$nazwa = $r1['name'];
		
	printf("
		<tr class='%s'>
		<td>%u</td>
		<td>%s</td>
		<td>%u</td>
		<td>%u</td>
		<td>%s</td></tr>",$klasa,$i,$nazwa,$r1['quantity'],$r1['requiredQuantity'],$r1['name']);
	$i++;
	}
			echo"</tbody>
			</table>";
	}
	else echo "<p align='center'>Brak elementów!</p>";
	}
	break;
	
	case 'modyfikuj':
	if(isset($_SESSION['id_proj'])&&$_SESSION['projekt']){
	$form = new Formularz();
	$query = "SELECT `id`, concat(`name`,' ',`parametr`) FROM `parts` WHERE `id_user`=$id_user AND `id_proj`=$id_proj";
	$result = $mysqli->query($query);
	echo"<br /> <p>";
	if(isset($_GET['id_element']))
	$form->select('sel1','Wybierz element do modyfikacji:',$result->num_rows,$result,'form-control',null,null,'onchange="reLoad()"multiple','sel1',$_GET['id_element'],$_GET['id_element']);
	else
		$form->select('sel1','Wybierz element do modyfikacji:',$result->num_rows,$result,'form-control',null,null,'onchange="reLoad()"multiple','sel1',null,null);
	echo "</p>";
	}
	break;
	
	case 'dodaj':
	if(isset($_SESSION['projekt'])&&isset($_SESSION['id_proj'])){
	$query ="SELECT `name`, `quantity`, `requiredQuantity`, `id_cat`, `parametr` FROM `parts` WHERE `id_proj`=$id_proj and `id_user`=$id_user";
	$result1=$mysqli->query($query);
	if($result1->num_rows>0){
	echo"<br /><table class='table table-sm table-dark tab-txt mx-auto'>
		<thead>
			<tr>
			<th scope='col'>#</th>
			<th scope='col'>Element</th>
			<th scope='col'>Ilosc</th>
			<th scope='col'>Potrzebnych</th>
			<th scope='col'>Kategoria</th>
			</tr>
		</thead>
		<tbody>";
	$i=1;
	while($r1=$result1->fetch_assoc()){
		if($r1['parametr']!='Brak'){
			$nazwa = $r1['name']." ".$r1['parametr'];
		}
		else
			$nazwa = $r1['name'];
	printf("
		<tr>
		<td>%u</td>
		<td>%s</td>
		<td>%u</td>
		<td>%u</td>
		<td>%s</td></tr>",$i,$nazwa,$r1['quantity'],$r1['requiredQuantity'],$r1['name']);
	$i++;
	}
			echo"</tbody>
			</table>";
	}
	else echo "<br /><p align='center'>Brak elementów!</p>";
	}
	break;
	
	default:
	printf("%s",$_SESSION['error_msg']);
	break;
}
?>