<?php 

session_start();

include('connect.php');

$login = $_POST['login'];
$senha = $_POST['senha'];

$SQLa = "SELECT * FROM funcionario WHERE nome = '".$login."' AND senha = '".$senha."'";
$resulta = mysql_query($SQLa);
$lista = mysql_fetch_array($resulta);

if(sizeof($lista)>0){
	
	$_SESSION["id"] = $lista['idfuncionario']; 

}




?>