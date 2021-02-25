<?php

	//define("BASE_URL", "http://localhost/sistema_wsr/");
	//cambiar la ruta para subirlo a un hossting
	const BASE_URL = "http://localhost/sistema_wsr"; 

	//zona horaria
	date_default_timezone_set('America/Mexico_City');

	//Datos de la base de datos MySql
	const DB_HOST = "localhost";
	const DB_NAME = "sistemawsr";
	const DB_USER = "root";
	const DB_PASSWORD = "";
	const DB_CHARSET = "utf8"; 

	//Deliminadores decimal y millar Ej. 24,1989.00
	const SPD = ".";
	const SPM = ",";

	//Simbola de moneda
	const SMONEY = "$";

	//Datos envio de correo
	const NOMBRE_REMITENTE = "Sistema WSR";
	const EMAIL_REMITENTE = "no-reply@abelosh.com";
	const NOMBRE_EMPESA = "WSR Integral";
	const WEB_EMPRESA = "www.wsrintegral.com";

	const CAT_SLIDER = "1,2,3";
	const CAT_BANNER = "4,5,6";
	
?>