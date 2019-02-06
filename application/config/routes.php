<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$route['default_controller'] = 'Login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
//-------logusuario--------------------------
$route['logusuario'] = "login/new_user";
//-------usuarios--------------------------
$route['salir'] = "login/salir";
//-------usuarios--------------------------
$route['registro'] = "login/registro";

$route['registro_asociado'] = "login/reg_asociado";

$route['reset'] = "login/reset_pass";
$route['resetear'] = "login/change_pass";
$route['forgot'] = "panel_admin/forgot_pass";




//-------Perfiles--------------------------
$route['MyperfilAdmin'] = "panel_admin/MyperfilAdmin";
$route['my_perfil'] = "capacitacion/Myperfil";

//-------Cartera clientes--------------------------
$route['cartera_clientes'] = "capacitacion/cartera_clientes";

//-------Historial cliente--------------------------
$route['historial_cliente'] = "capacitacion/historial_cliente";
$route['historial_cliente/(:num)'] = "capacitacion/historial_cliente/$1";


//-------carpeta_presentacion cliente--------------------------
$route['download_planilla'] = "capacitacion/download_planilla";
$route['download_planilla/(:num)'] = "capacitacion/download_planilla/$1";


//-------carpeta_presentacion cliente--------------------------
$route['carpeta_presentacion'] = "capacitacion/carpeta_presentacion";
$route['carpeta_presentacion/(:num)'] = "capacitacion/carpeta_presentacion/$1";

//-------Almacen--------------------------
$route['almacen'] = "capacitacion/almacen";
$route['almacen/(:num)'] = "capacitacion/almacen/$1";

//-------ventas--------------------------
$route['ventas'] = "capacitacion/ventas";
$route['ventas/(:num)'] = "capacitacion/ventas/$1";

/*-------------------------------------------------*/
//-------lista_ventas--------------------------
$route['lista_ventas'] = "capacitacion/mis_ventas";
$route['lista_ventas/(:num)'] = "capacitacion/mis_ventas/$1";

/*-------------------------------------------------*/

//-------downloads_doc--------------------------
$route['downloads_doc'] = "capacitacion/downloads_doc";
$route['downloads_doc/(:num)'] = "capacitacion/downloads_doc/$1";

/*-------------------------------------------------*/


//-------mis_epats--------------------------
$route['mis_epats'] = "capacitacion/mi_red";
$route['mis_epats/(:num)'] = "capacitacion/mi_red/$1";

/*-------------------------------------------------*/

//-------vencimientos--------------------------
$route['vencimientos'] = "capacitacion/vencimientos";
$route['vencimientos/(:num)'] = "capacitacion/vencimientos/$1";

/*-------------------------------------------------*/


//-------carrito--------------------------
$route['carrito'] = "capacitacion/carrito";
$route['carrito/(:num)'] = "capacitacion/carrito/$1";

/*-------------------------------------------------*/

//-------tienda--------------------------
$route['tienda'] = "capacitacion/tienda";
$route['tienda/(:num)'] = "capacitacion/tienda/$1";

/*-------------------------------------------------*/

//-------mi_billetera--------------------------
$route['mi_billetera'] = "capacitacion/mi_cartera";
$route['mi_billetera/(:num)'] = "capacitacion/mi_cartera/$1";

/*-------------------------------------------------*/
//-------mis_compras--------------------------
$route['mis_compras'] = "capacitacion/mis_compras";
$route['mis_compras/(:num)'] = "capacitacion/mis_compras/$1";

/*-------------------------------------------------*/

//-------success--------------------------
$route['success'] = "capacitacion/success";
$route['success/(:num)'] = "capacitacion/success/$1";

/*-------------------------------------------------*/
//-------pending--------------------------
$route['pending'] = "capacitacion/pending";
$route['pending/(:num)'] = "capacitacion/pending/$1";

/*-------------------------------------------------*/
//-------failure--------------------------
$route['failure'] = "capacitacion/failure";
$route['failure/(:num)'] = "capacitacion/failure/$1";

/*-------------------------------------------------*/

