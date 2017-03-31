<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'login_controller';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/******** MIS RUTAS **********/
// LOGIN
$route['login'] = 'login_controller/Acreditar';
$route['salir'] = 'login_controller/Salir';
$route['cambiarPass'] = 'login_controller/cambiarPass';
// FIN LOGIN

// RUTAS MENU
$route['Main'] = 'graficos_controller';

// RUTAS GRAFICOS
$route['GrfmetaVendedores'] = 'graficos_controller/GrfmetaVendedores';
$route['GrfmetaVendedores2'] = 'graficos_controller/GrfmetaVendedores2';

/* PEDIDOS */
$route['pedidos'] = 'pedidos_controller';

/* COBROS */
$route['cobros'] = 'cobros_controller';

/* GRUPOS */
$route['grupos'] = 'grupos_controller';
$route['nuevoGrupo'] = 'grupos_controller/nuevoGrupo';
$route['getVendedoresGrupo'] = 'grupos_controller/getVendedoresGrupo';

/* CLIENTES */
$route['Clientes'] = 'clientes_controller/Clientes';

/*USUARIOS*/
$route['Usuarios'] = 'usuario_controller'; 

// RUTA FACTURAS
$route['facturas'] = 'facturas_controller';

// RUTA REPORTES
$route['Reportes'] = 'reportes_controller';


/*RUTAS DE DATOS*/
$route['datos'] = 'datos_controller/index';


/*RUTAS MONITOREO*/
$route['monitoreo'] = 'monitoreo_controller/index';