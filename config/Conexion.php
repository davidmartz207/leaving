<?php 
	/**
	* Clase de conexion al archivo
	*/
	class Conexion
	{

		public $archivo="../database/archivo.txt";


		function __construct($archivo='../database/archivo.txt')
		{
			$this->archivo = $archivo;
		}
        //metodo para abrir la lectura del archivo
	    public  function abrirLectura(){
           return fopen($this->archivo, 'r');
        }

        //metodo para obtener una linea del archivo
        public  function obtenerLinea($archivo){ 
           return fgets($archivo);
        }

        //metodo para escribir una linea del archivo
        public  function escribirLinea($linea){ 
          $archivo =  fopen($this->archivo, 'a+');
          return  fwrite($archivo,$linea);

        }

        //metodo para actualizar el archivo
        public  function actualizarLinea($linea){ 
          $archivo =  fopen($this->archivo, 'w');
          return  fwrite($archivo,$linea);
          
        }

        //metodo para cerrar el archivo
        public  function cerrarLectura($archivo){ 
           return fclose($archivo);
        }

    }


 ?>