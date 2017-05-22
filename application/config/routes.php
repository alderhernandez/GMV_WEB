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
$route['Main'] = 'main_controller';
$route['ajaxGrafica']='pedidos_controller/ajaxGrafica';
$route['ajaxGraficaColum']='pedidos_controller/ajaxGraficaColum';

/* PEDIDOS */
$route['pedidos'] = 'pedidos_controller';
$route['detallepedido/(:any)'] = 'pedidos_controller/detallePedido/$1';
$route['ajaxDetallePedido']='pedidos_controller/cabeceraPedido';
$route['ajaxPedido/(:any)']='pedidos_controller/DetallePedido/$1';
$route['ajaxUpdatePedido/(:any)/(:any)']='pedidos_controller/UpdateEstado/$1/$2';
$route['ajaxPedidoComen/(:any)']='pedidos_controller/ajaxPedidoComen/$1';

/* COBROS */
$route['cobros'] = 'cobros_controller';
$route['searchCobros/(:any)/(:any)']='cobros_controller/searchCobros/$1/$2';
$route['searchCobros']='cobros_controller/searchCobros';

/* GRUPOS */
$route['grupos'] = 'grupos_controller';
$route['nuevoGrupo'] = 'grupos_controller/nuevoGrupo';
$route['getVendedoresGrupo/(:any)'] = 'grupos_controller/getVendedoresGrupo/$1';
$route['getVendedoresGrupoAct/(:any)'] = 'grupos_controller/getVendedoresGrupoAct/$1';
$route['editarGrupo'] = 'grupos_controller/editarGrupo';

/* CLIENTES */
$route['Clientes'] = 'clientes_controller/Clientes';

/*USUARIOS*/
$route['Usuarios'] = 'usuario_controller'; 

/*AGENDA*/
$route['agenda'] = 'agenda_controller';
$route['ajaxCalendario/(:any)'] = 'agenda_controller/ajaxCalendario/$1';
$route['guardarComentario'] = 'agenda_controller/guardarComentario';
$route['traerComentario'] = 'agenda_controller/traerComentario';

/*CARGA DATOS*/
$route['carga'] = 'datos_controller';
$route['subirPlan'] = 'datos_controller/subirPlan';

// RUTA REPORTES
$route['Reportes'] = 'reportes_controller';


/*RUTAS DE DATOS*/
$route['datos'] = 'datos_controller/index';


/*RUTAS MONITOREO*/
$route['monitoreo'] = 'monitoreo_controller/index';