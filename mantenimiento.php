<?php
//la conexion
include("conexion.php");

$cod = $_POST["txtcodigo"];
$edad = $_POST["txtedad"];
$nom = $_POST["txtnombre"];
$tel = $_POST["txttelefono"];

	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['limpiardatos']))
	{
		header("Location: principal.php");
	}

if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['grabardatos']))
	//esta de insertar
	{
	$sqlgrabar = "INSERT INTO clientes(codigo, nombre, edad, telefono) values ('$cod','$nom','$edad','$tel')";

if(mysqli_query($conn,$sqlgrabar))
{
	header("Location: principal.php");
}else 
{
	echo "Error: " .$sql."<br>".mysql_error($conn);
}
		
		
	}
	
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['modificardatos']))
	//esta parte es de actualizar
	{
			$sqlmodificar = "UPDATE clientes SET nombre='$nom',edad='$edad',telefono='$tel' WHERE codigo=$cod";

if(mysqli_query($conn,$sqlmodificar))
{
	header("Location: principal.php");
}else 
{
	echo "Error: " .$sql."<br>".mysql_error($conn);
}
		
		
	}
	
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['eliminardatos']))
	//esta de eliminar
	{
			$sqleliminar = "DELETE FROM clientes WHERE codigo=$cod";

if(mysqli_query($conn,$sqleliminar))
{
	header("Location: principal.php");
}else 
{
	echo "Error: " .$sql."<br>".mysql_error($conn);
}
		
		
	}

?>