<?php

/**
 * Note to module developers:
 *  Keeping a module specific language file like this
 *  in this external folder is not a good practise for
 *  portability - I do not advice you to do this for
 *  your own modules since they are non-default.
 *  Instead, simply put your language files in
 *  application/modules/yourModule/language/
 *  You do not need to change any code, the system
 *  will automatically look in that folder too.
 */

$lang['item_store'] = "Tienda de objetos";
$lang['cant_afford'] = "¡No puedes permitirte esto!";
$lang['go_back'] = "Volver";
$lang['error_offline'] = "Lo sentimos, pero el reino al que estábamos intentando acceder parece estar fuera de línea. Tus puntos han sido restaurados. Por favor, inténtalo de nuevo más tarde.";
$lang['error_character'] = "No podemos enviarte los objetos ya que no tienes un personaje. Tus puntos han sido restaurados.";
$lang['error_character_exists'] = "El personaje introducido no existe.";
$lang['error_character_not_mine'] = "El personaje introducido no te pertenece.";
$lang['error_character_not_offline'] = "El personaje introducido no está desconectado. Por favor, desconecta al personaje del juego e inténtalo de nuevo.";
$lang['error_no_console'] = "Lo sentimos, pero el reino para el que fue diseñado este objeto no admite comandos de consola. Por favor, informa a un administrador.";
$lang['checkout'] = "Pagar";
$lang['buying'] = "Estás comprando";
$lang['total_of'] = "por un total de";
$lang['vp'] = "PV";
$lang['dp'] = "PD";
$lang['no_character'] = "No tienes ningún personaje";
$lang['sort_by'] = "Ordenar por";
$lang['default'] = "Predeterminado";
$lang['name'] = "Nombre";
$lang['price'] = "Precio";
$lang['item_quality'] = "Calidad del objeto";
$lang['all_items'] = "Todos los objetos";
$lang['poor'] = "Pobre";
$lang['common'] = "Común";
$lang['uncommon'] = "Poco común";
$lang['rare'] = "Raro";
$lang['epic'] = "Épico";
$lang['legendary'] = "Legendario";
$lang['artifact'] = "Artefacto";
$lang['heirloom'] = "Reliquia";
$lang['filter'] = "Filtrar por nombre...";
$lang['cart'] = "Carrito";
$lang['items'] = "objetos";
$lang['empty_cart'] = "Tu carrito está vacío";
$lang['checkout'] = "Pagar";
$lang['max'] = "Maximizar todos los grupos";
$lang['min'] = "Minimizar todos los grupos";
$lang['hide'] = "Ocultar grupo";
$lang['show'] = "Mostrar grupo";
$lang['loading'] = "Cargando...";
$lang['want_to_buy'] = "¿Estás seguro de que quieres comprar estos objetos?";
$lang['yes'] = "Sí";
$lang['free_items'] = "No puedes comprar objetos que cuestan 0 PV o PD.";
$lang['return'] = "Volver";
$lang['groups'] = "Grupos";
$lang['new_group'] = "Nuevo grupo";
$lang['group_name'] = "Nombre del grupo";
$lang['group_icon'] = "Icono del grupo";
$lang['group_order'] = "Orden del grupo";
$lang['group_order_tip'] = "Especifique un orden, se ordenará de forma ascendente por orden de grupo";
$lang['submit_group'] = "Enviar grupo";
$lang['refund'] = "Reembolsar";
$lang['to'] = "a";
$lang['failed_orders_week'] = "Pedidos fallidos de la última semana";
$lang['failed_orders_desc'] = "Los pedidos que aparecen aquí han fallado debido a un error del sistema. Si el error no ocurrió inmediatamente, es posible que algunos artículos se hayan entregado. Debe investigar manualmente si se debe reembolsar al usuario.";
$lang['last_successful_orders'] = "Últimos 10 pedidos exitosos";
$lang['search_by_username'] = "Buscar por nombre de usuario";
$lang['search'] = "Buscar";
$lang['items'] = "Artículos";
$lang['store'] = "Tienda";
$lang['add_group'] = "Añadir grupo";
$lang['edit_group'] = "Editar grupo";
$lang['add_item'] = "Añadir artículo";
$lang['title_cant_be_empty'] = "El título no puede estar vacío";
$lang['invalid_item_id'] = "ID de artículo inválido";
$lang['invalid_item'] = "Artículo inválido";
$lang['group_cant_be_empty'] = "El grupo no puede estar vacío";
$lang['no_item_with_id'] = "No hay artículo con el ID ";
$lang['no_id'] = "Sin ID";
$lang['order_cant_be_empty'] = "¡El número de orden no puede estar vacío!";
$lang['orders'] = "Pedidos";
$lang['unknown'] = "Desconocido";
$lang['unknown_account'] = "Cuenta desconocida";
$lang['no_matches'] = "Sin coincidencias";
$lang['bad_id'] = "ID incorrecto";
$lang['invalid_order'] = "Pedido inválido";
$lang['return_to_items'] = "Volver a los artículos";
$lang['new_item'] = "Nuevo artículo";
$lang['edit_item'] = "Editar artículo";
$lang['item_type'] = "Tipo de artículo";
$lang['item'] = "Artículo";
$lang['console_command'] = "Comando de consola";
$lang['query'] = "Consulta";
$lang['description_short'] = "Descripción (muy corta; se muestra debajo del nombre del artículo)";
$lang['need_character'] = "Necesita personaje";
$lang['require_offline'] = "Requerir desconectado";
$lang['make_user_select_character'] = "Hacer que el usuario seleccione un personaje";
$lang['make_sure_character_offline'] = "Asegurarse de que el personaje seleccionado esté desconectado";
$lang['command'] = "Comando";
$lang['account_name'] = "Nombre de cuenta";
$lang['character_name'] = "Nombre de personaje";
$lang['account_id'] = "ID de cuenta";
$lang['character_id'] = "ID de personaje";
$lang['realm_id'] = "ID de reino";
$lang['database'] = "Base de datos";
$lang['cms'] = "CMS";
$lang['realm_characters'] = "Reino (personajes)";
$lang['realmd_accounts'] = "Reino (cuentas/auth/inicio de sesión)";
$lang['sql_query'] = "Consulta SQL";
$lang['query_example_tooltip'] = "Ejemplo de consulta: UPDATE characters SET level = 80 WHERE guid = {CHARACTER}";
$lang['name_multiple_items'] = "Nombre (solo obligatorio para múltiples artículos)";
$lang['name_multiple_items_placeholder'] = "Se añadirá automáticamente si solo especifica un ID de artículo";
$lang['item_id'] = "ID del artículo (Consejo: separe los IDs con , (coma) para añadir varios como uno)";
$lang['count'] = "Cantidad (Consejo: Por ejemplo, introduzca 20 para 20x. Separe los IDs con , (coma))";
$lang['description_placeholder'] = "Por ejemplo, 'Cabeza (Placa)'";
$lang['icon_name'] = "Nombre del icono";
$lang['icon_placeholder'] = "Se añadirá automáticamente si lo deja vacío y solo especifica un ID de artículo";
$lang['submit_command'] = "Enviar comando";
$lang['submit_query'] = "Enviar consulta";
$lang['submit_item'] = "Enviar artículo";
$lang['edit_group_button'] = "Editar grupo";
$lang['icon'] = "Icono";
$lang['name'] = "Nombre";
$lang['description'] = "Descripción";
$lang['group'] = "Grupo";
$lang['price'] = "Precio";
$lang['actions'] = "Acciones";
$lang['edit'] = "Editar";
$lang['delete'] = "Eliminar";
$lang['search'] = "Buscar";
$lang['create_item'] = "Crear artículo";
$lang['create_group'] = "Crear grupo";
$lang['order_number'] = "Orden #";
$lang['realm'] = "Reino";
$lang['item_group'] = "Grupo de artículos";
$lang['none'] = "Ninguno";
$lang['vp_price'] = "Precio VP";
$lang['dp_price'] = "Precio DP";
