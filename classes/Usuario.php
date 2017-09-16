<?php 
	/**
	* Class User
	*/
	class Usuario 
	{
        public $id = "";
		public $nombre="";
		public $tipo="";
		public $token="";
		public $estado="";  //0 por aprobar, 1 aprobado , 2 rechazado
		
		function __construct($id,$nombre,$tipo,$token,$estado)
		{
			$this->id 	  = $id;
			$this->nombre = $nombre;
			$this->tipo   = $tipo;
			$this->token  = $token;
			$this->estado = $estado;
		}

	}


?>