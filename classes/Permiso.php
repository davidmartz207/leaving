<?php 
	require("../config/includeClass.php");

	/**
	* Permisos
	*/
	class Permiso 
	{

		public $id;
		public $usuario;
		public $titulo;
		public $contenido;
		public $comentario;
		public $fechastr;
		public $fechaend;
		public $estado;
		public $gerente;
		public $empleado;

		function __construct($id="",$usuario="",$titulo="",$contenido="",$comentario="",$fechastr="",$fechaend="",$estado="")
		{
			$this->id = $id;
			$this->usuario = $usuario;
			$this->titulo = $titulo;
			$this->contenido = $contenido;
			$this->comentario = $comentario;
			$this->fechastr = $fechastr;
			$this->fechaend = $fechaend;
			$this->estado = $estado;


		}
		

		//método para listar los permisos con filtros
		public function lista($id,$token=""){

			//Un usuario gerente , tipo 1 , no depende de nadie y está activo.
			$gerente = new Usuario(1,'Juan',1,'123456',1);

			//Un usuario Empleado , tipo 2 , depende de tipo 1 y está activo.
			$empleado = new Usuario(2,'Pedro',2,'',1);


   		    //Conexión a archivo que guarda los registros
	        $archivo = new Conexion();
			//valida que se pase id de usuario
			if (empty($id)) {
				return "Error en parámetros, no se encuentra ID";
			}

			//abre la conexión al fichero
			$fichero = $archivo->abrirLectura();
			$arraydatos =[];
			while (!feof($fichero)) {
	    		$datos  = $archivo->obtenerLinea($fichero);
	    		$arraydatos[]  = explode(',', $datos);
			}

    		$archivo->cerrarLectura($fichero);
    		//se arma array para salida de datos json
    		$arrayJson = [];
    		for ($i=0; $i < count($arraydatos) ; $i++) { 

       		    $permiso = new Permiso();

    			$permiso->id = $arraydatos[$i][0];
    			$permiso->usuario = $arraydatos[$i][1];
    			$permiso->titulo = $arraydatos[$i][2];
    			$permiso->contenido = $arraydatos[$i][3];  			
    			$permiso->comentario = $arraydatos[$i][4];
    			$permiso->fechastr = $arraydatos[$i][5];
    			$permiso->fechaend = $arraydatos[$i][6];
    			switch ((integer)$arraydatos[$i][7]) {
    				case 0:
    					$permiso->estado = "Por aprobar";
    					break;
    				case 1:
						$permiso->estado="Aceptado";     
						break;
    				case 2:
    					$permiso->estado="Rechazado";
    					break;
    			}

				//la lista de los permisos propios
    			if (empty($token)) {
    				if ((integer)$permiso->usuario == (integer)$id) {
    				
    					$arrayJson[] = $permiso;
    			
    				}  				
    			}else{
    				//la lista de permisos  ajenos si es gerente
    				if ($gerente->token == $token && (integer)$id == $gerente->id && (integer)$permiso->usuario !== (integer)$id) {
     					
     					$arrayJson[] = $permiso;

    				}
    			}
			}
    		
    		return json_encode($arrayJson);

		}

		//método para crear los permisos
		public function crear($data){
   		    //Conexión a archivo que guarda los registros
	        $archivo = new Conexion();

	        //validacion
	        $error=0;
	        if (empty($data->usuario)) {
	        	$error=1;
	        	echo "todos los campos son obligatorios USUARIO";
	        }elseif (empty($data->titulo)) {
	        	$error=1;
	        	echo "todos los campos son obligatorios TITULO";
	        }elseif (empty($data->contenido)) {
	        	$error=1;
	        	echo "todos los campos son obligatorios CONTENIDO";
	        }elseif (empty($data->fechastr)) {
	        	$error=1;
	        	echo "todos los campos son obligatorios FECHA";
	        }elseif (empty($data->fechaend)) {
        		$error=1;
	        	echo "todos los campos son obligatorios FECHA FIN";
	        }elseif ((integer)$data->estado <0 || (integer)$data->estado > 2) {
	        	$error=1;
	        	echo "Valor incorrecto para el estado";
	        }elseif ((integer)$data->usuario < 1 || (integer)$data->usuario >2) {
	        	echo "Valor incorrecto para el usuario";
	        }


	        if ($error == 1) {
	        	return false;
	        }
			//leemos el archivo para obtener el último id
			$fichero = $archivo->abrirLectura();
			$arraydatos =[];
			while (!feof($fichero)) {
	    		$datos  = $archivo->obtenerLinea($fichero);
	    		$arraydatos[]  = explode(',', $datos);
			}

    		$fichero = $archivo->cerrarLectura($fichero);

    		//obtenemos el ultimo id
    		for ($i=0; $i < count($arraydatos) ; $i++) { 
       		    $permiso = new Permiso();
    			$permiso->id = $arraydatos[$i][0];
       		}

       	    $nuevoid=(integer)$permiso->id+1;


       	    //se procede a guardar

   			$linea  = "\n".$nuevoid.",";//.","$data->comentario.",".$data->fecha_Crc.",".$data->fecha_Act,$data->estado;
   			$linea .= $data->usuario.",";
   			$linea .= $data->titulo.",";
   			$linea .= $data->contenido.",";
   			$linea .= $data->comentario.",";
   			$linea .= $data->fechastr.",";
   			$linea .= $data->fechaend.",";
        	$linea .= $data->estado;


   			if ($archivo->escribirLinea($linea)) {
   				echo "¡¡Guardado Exitosamente!!";
   			}

		}

		//metodo para actualizar los estatus de los permisos
		public function actualizar($data){
   		    //Conexión a archivo que guarda los registros
	        $archivo = new Conexion();

	        //validacion
	        $error=0;
	        if(empty($data->id)){
	        	$error=1;
	        	echo "todos los campos son obligatorios ID";
	        }elseif (empty($data->usuario)) {
	        	$error=1;
	        	echo "todos los campos son obligatorios USUARIO";
	        }elseif (empty($data->comentario)) {
	        	$error=1;
	        	echo "todos los campos son obligatorios COMENTARIO";
	        }elseif (empty($data->estado)) {
	        	$error=1;
	        	echo "todos los campos son obligatorios ESTADO";
	        }elseif ((integer)$data->estado <0 || (integer)$data->estado > 2) {
	        	$error=1;
	        	echo "Valor incorrecto para el estado";
	        }


	        if ($error == 1) {
	        	return false;
	        }

  			//leemos el archivo para obtener el registro
			$fichero = $archivo->abrirLectura();
			$arraydatos =[];
			while (!feof($fichero)) {
	    		$datos  = $archivo->obtenerLinea($fichero);
	    		$arraydatos[]  = explode(',', $datos);
			}

    		$fichero = $archivo->cerrarLectura($fichero);

    		//obtenemos el registro con el  id
    		for ($i=0; $i < count($arraydatos) ; $i++) { 
       		    $permiso = new Permiso();
       		    if ((integer)$data->id == (integer)$arraydatos[$i][0] && (integer)$data->usuario == (integer)$arraydatos[$i][1]) {
       		    	$error=0;
    				$permiso->id = $arraydatos[$i][0];
    				$permiso->usuario = $arraydatos[$i][1];
     				$permiso->titulo = $arraydatos[$i][2];
    				$permiso->contenido = $arraydatos[$i][3];
    				$permiso->comentario = $arraydatos[$i][4];
    				$permiso->fechastr = $arraydatos[$i][5];
    				$permiso->fechaend = $arraydatos[$i][6];
    				$permiso->estado = $arraydatos[$i][7] ;
    				break;
       			}else{
       				$error=1;
       			}
       		}


       		if ($error == 1) {
       			echo "El id no concuerda para el usuario";
       			return false;
       		}

        	//se recorre el array para actualizar
    		for ($i=0; $i < count($arraydatos) ; $i++) { 
       		    if ((integer)$data->id == (integer)$arraydatos[$i][0] && (integer)$data->usuario == (integer)$arraydatos[$i][1]) {
       		    	$arraydatos[$i][4] = $data->comentario;
    				$arraydatos[$i][7] = $data->estado;
    				break;
       			}
       		}

       		$linea="";
       		//generamos el nuevo contenido para el archivo ya actualizado
    		for ($i=0; $i < count($arraydatos) ; $i++) {   
    				$linea .= trim($arraydatos[$i][0].",");
    				$linea .= trim($arraydatos[$i][1].",");
    				$linea .= trim($arraydatos[$i][2].",");
    				$linea .= trim($arraydatos[$i][3].",");
    				$linea .= trim($arraydatos[$i][4].",");
    				$linea .= trim($arraydatos[$i][5].",");
    				$linea .= trim($arraydatos[$i][6].",");
    				$linea .= trim($arraydatos[$i][7])."\n";
       		}

   			if ($archivo->actualizarLinea(trim($linea))) {
   				echo "¡¡Actualizado Exitosamente!!";
   			}
		}

	}



 ?>