#puntos a considerar
--Se recomienda colocar en servidor y otorgar permisos de lectura y escritura.

--Solo hay dos usuarios estáticos estan en la clase Permiso directamente configurados.
id usuario 1 - GERENTE
id usuario 2 - EMPLEADO

--La base de datos se encuentra ubicada en la carpeta database, el archivo archivo.txt

--Ruta para guardar elementos
http://localhost/leaving/API/create.php?usuario=2&titulo=reposo&contenido=reposo por enfermedad&fechastr=04-08-92&fechaend=05-09-92

--Cada usuario puede revisar el estatus de su solicitud en la misma lista, campo estado está inmerso en el proceso de listado
0-por aprobar
1-Aprobado
2-Rechazado


--Ruta para listar permisos propios

http://localhost/leaving/API/list.php?user=1&token=


--Ruta para listar permisos ajenos de la gerencia con token.

http://localhost/leaving/API/list.php?user=1&token=123456

--ejemplo ruta para actualizar elementos
http://localhost/leaving/API/update.php?id=3&usuario=2&estado=2&comentario=rechazado hasta traer constancias