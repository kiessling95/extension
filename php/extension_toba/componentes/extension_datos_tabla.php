<?php

class extension_datos_tabla extends toba_datos_tabla {

    protected $res;

    function dblink_designa() {
        $res = toba::db('designa')->get_parametros();
        //'host=localhost user=extension password=Exten.2019 dbname=designa'
        
	$host = "host={$res['profile']}";
	$base = "dbname={$res['base']}";
	$usuario = "user={$res['usuario']}";
	$clave = "password={$res['clave']}";

        return "$host $usuario $clave  $base ";
        
    }

}

?>