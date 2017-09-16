<?php 
	require("../classes/Permiso.php");


    //se crea el objeto
	$permiso    = new Permiso();
	//se cambia el usuario por el parámetro 
	$id_usuario = $_GET['user'];
    $token = $_GET['token'];

	//se ejecuta la consulta
	echo $permiso->lista($id_usuario,$token);




 ?>