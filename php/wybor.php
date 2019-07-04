<?php
$id_user=$_SESSION['id'];
switch($_POST['projekt']){
	case 'newPr':
	$_SESSION['projekt']=$projekt=$_POST['nowy'];
	$opis=$_POST['opis'];
	$query = "INSERT INTO `projects`(`id_proj`, `name`, `data_utworzenia`, `id_user`, `description`) VALUES (null,'$projekt',null,$id_user,'$opis')";
	$mysqli->query($query);
	$query="SELECT `id_proj` FROM `projects` WHERE `id_user`=$id_user AND `name`='$projekt'";
	$result=$mysqli->query($query);
	$r = $result->fetch_assoc();
	$_SESSION['id_proj'] = $r['id_proj'];
	break;

	default:
	switch($_POST['pr']){
	
	case 'existing':
	$_SESSION['id_proj']=$id_projektu = $_POST['projekt'];
	$query ="SELECT `name` FROM `projects` WHERE `id_user`=$id_user AND `id_proj`=$id_projektu";
	$result=$mysqli->query($query);
	$r=$result->fetch_assoc();
	$_SESSION['projekt'] = $r['name'];
	break;
	
	case 'delete':
	$id_projektu = $_POST['projekt'];
	$query = "DELETE FROM `parts` WHERE `id_user`=$id_user and `id_proj`=$id_projektu";
	$mysqli->query($query);
	$query="DELETE FROM `projects` WHERE `id_user`=$id_user and `id_proj`=$id_projektu";
	$mysqli->query($query);
	unset($_SESSION['projekt']);
	unset($_SESSION['id_proj']);
	break;
	}
break;
}
$_POST=array();
header('location:main.php');
?>