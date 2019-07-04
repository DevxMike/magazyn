<?php
	if(isset($_SESSION['projekt'])){
		$projekt=$_SESSION['projekt'];
		$id_user=$_SESSION['id'];
		$parametr = $_POST['parametr'];
		$ilosc = $_POST['ilosc'];
		$iloscW = $_POST['iloscW'];
		$id_proj = $_SESSION['id_proj'];

	switch($_POST['kategoria']){
	case 'newCat':
	$nowa_cat = $_POST['nowy'];
	$query ="INSERT INTO `categories`(`id_cat`, `name`, `id_user`) VALUES (null,'$nowa_cat',$id_user)";
	$mysqli->query($query);
	$result=$mysqli->query("SELECT `id_cat` FROM `categories` WHERE `name`='$nowa_cat' and `id_user`=$id_user");
	$r = $result->fetch_assoc();
	$id_cat = $r['id_cat'];
	$result->close();
	$query = "INSERT INTO `parts`(`id`, `name`, `quantity`, `requiredQuantity`, `id_cat`, `id_proj`, `parametr`, `id_user`) VALUES (null,'$nowa_cat',$ilosc,$iloscW,$id_cat,$id_proj,'$parametr',$id_user)";
	$mysqli->query($query);

	break;
	
	default:
	$kategoria = $_POST['kategoria'];
	$query = "SELECT  `name` FROM `categories` WHERE `id_cat`=$kategoria";
	$result = $mysqli->query($query);
	$r = $result->fetch_assoc();
	$nazwa = $r['name'];
	$result->close();
	$query = "INSERT INTO `parts`(`id`, `name`, `quantity`, `requiredQuantity`, `id_cat`, `id_proj`, `parametr`, `id_user`) VALUES (null,'$nazwa',$ilosc,$iloscW,$kategoria,$id_proj,'$parametr',$id_user)";
	$mysqli->query($query);

	break;
}
}
$_POST = array();
header('location:main.php?action=dodaj');
?>