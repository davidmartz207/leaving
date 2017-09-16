<?php 
	require("../classes/Permiso.php");


    //se crea el objeto
	$permiso    = new Permiso();
	//Se reciben los parámetros

	$data = new Permiso();
	$data->usuario    = $_GET['usuario'];
	$data->titulo     = $_GET['titulo'];
	$data->contenido  = $_GET['contenido'];
	$data->fechastr   = $_GET['fechastr'];
	$data->fechaend   = $_GET['fechaend'];
	$data->estado     = '0';




	//se ejecuta la creacion
    $permiso->crear($data);




 ?>