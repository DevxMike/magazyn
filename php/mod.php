<?php
if(isset($_SESSION['projekt'])){
	
	$id_user=$_SESSION['id'];
	$projekt=$_SESSION['projekt'];
	$id_el = $_SESSION['id_el'];
	$id_proj = $_SESSION['id_proj'];
	unset($_SESSION['id_el']);
	$radio = $_POST['pr'];
	
	switch($radio){
	
	case 'delete':
	
	$query="DELETE FROM `parts` WHERE `id`=$id_el";
	$mysqli->query($query);
	break;
	
	case 'modify':
	
	$select = $_POST['kategoria'];
	
		switch($select){
			
			case 'newCat':
			
			$nazwa = $_POST['nowy'];
			$query = "INSERT INTO `categories`(`id_cat`, `name`, `id_user`) VALUES (null,'$nazwa',$id_user)";
			$mysqli->query($query);
			$query = "SELECT `id_cat` FROM `categories` WHERE `name`='$nazwa' and `id_user`=$id_user";
			$result = $mysqli->query($query);
			$r = $result->fetch_assoc();
			$id_cat = $r['id_cat'];
			$ilosc=$_POST['ilosc'];
			$iloscW=$_POST['iloscW'];
			$parametr=$_POST['parametr'];
			$query = "UPDATE `parts` SET `name`='$nazwa',`quantity`=$ilosc,`requiredQuantity`=$iloscW,`id_cat`=$id_cat,`parametr`='$parametr' WHERE `id`=$id_el";
			echo $query;
			$mysqli->query($query);
			break;
			
			default:
			
			$query = "SELECT `name` FROM `categories` WHERE `id_cat`=$select";
			$result = $mysqli->query($query);
			$r = $result->fetch_assoc();
			$nazwa = $r['name'];
			$id_cat = $select;
			$ilosc=$_POST['ilosc'];
			$iloscW=$_POST['iloscW'];
			$parametr=$_POST['parametr'];
			$query = "UPDATE `parts` SET `name`='$nazwa',`quantity`=$ilosc,`requiredQuantity`=$iloscW,`id_cat`=$select,`parametr`='$parametr' WHERE `id`=$id_el";
			$mysqli->query($query);
			break;
		}
	break;
	}
}
$_POST=array();
header('Location:main.php?action=modyfikuj')
?>