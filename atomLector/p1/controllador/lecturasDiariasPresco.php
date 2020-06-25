<?php 
session_start();
require("../../../conection/conexion.php");

$verIntentos = ("SELECT * from  registroLectDiaria where idUsuario=:idUsuario and idLectura
	=:idLectura");
$buscar = $dbConn->prepare($verIntentos);
$buscar->bindParam(':idUsuario', $_SESSION["idUsuario"], PDO::PARAM_INT); 
$buscar->bindParam(':idLectura',$_POST['idLectura'], PDO::PARAM_INT);
$buscar->execute();
$intentos=$buscar->rowCount();


if($intentos==0){
$intentosNuevo=$intentos+1;


echo 'idUsuario'.$_SESSION["idUsuario"]."<br>";
echo "Id Lectura: ".$_POST['idLectura']."<br>";
echo "fecha: ".$_POST['fecha']."<br>";
echo "hora: ".$_POST['hora']."<br>";
echo "intento: ".$intentosNuevo."<br>";





$sql3 = ("INSERT INTO  registroLectDiaria (idUsuario,idLectura,fecha,hora,intento) VALUES (:idUsuario,:idLectura,:fecha,:hora,:intento)");
$actualizar = $dbConn->prepare($sql3);
$actualizar->bindParam(':idUsuario', $_SESSION["idUsuario"], PDO::PARAM_INT); 
$actualizar->bindParam(':idLectura',$_POST['idLectura'], PDO::PARAM_INT);
$actualizar->bindParam(':fecha',$_POST['fecha'], PDO::PARAM_STR);
$actualizar->bindParam(':hora', $_POST['hora'], PDO::PARAM_STR);
$actualizar->bindParam(':intento', $intentosNuevo, PDO::PARAM_STR);

$actualizar->execute();

header("location:../mostrarLect1.php?idLectura=".$_POST['idLectura'].'&gradoB='.$_POST['grado']);
}else{
header("location:../mostrarLect1.php?idLectura=".$_POST['idLectura'].'&gradoB='.$_POST['grado']);
	
}




 ?>
