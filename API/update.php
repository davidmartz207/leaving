<?php 
	require("../classes/Permiso.php");


    //se crea el objeto
	$permiso    = new Permiso();
	//Se reciben los parámetros

	$data = new Permiso();
	$data->id = $_GET['id'];
	$data->usuario    = $_GET['usuario'];
	$data->estado     = $_GET['estado'];
	$data->comentario = $_GET['comentario'];

	//se ejecuta la creacion
    $permiso->actualizar($data);




 ?>