<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| Configuración de Funcionamiento
| -------------------------------------------------------------------
| Este arhivo contiene la configuración Ncai Auth for CI.
|
| Puedes modificar el comportamiento del sistema de login en este
| archivo, tanto las direcciones de redireccionamiento, como activar
| o desactivar algunas características importantes.
|
| Las opciones que requieren librerías o configuraciones especiales
| para poder funcionar, tienen el nombre de esa librería o configuración
| entre corchetes [].
|
| Autor: Matías Navarro Carter
| Licencia: MIT
|
|
*/

// Opciones Generales
$config['auto_install_db'] = true;

// Opciones de Usuario
$config['activate_plan_module'] = false; // Módulo de plan. TODO
$config['plan_default_value'] = 1; // 0 es sin plan. TODO

// Opciones de Inicio de Sesión
$config['smart_redirect'] = true;   // Debe ser configurado en cada controlador.
$config['logged_in_controller'] = 'app';

// Opciones de Registro
$config['activate_registration'] = true;
$config['register_with_name'] = false;
$config['register_with_username'] = false;
$config['register_with_terms'] = false;
$config['activation_email'] = true;     // Eńvía un email de confirmación para el registro.
$config['default_permissions'] = USER;  // Puedes elegir entre USER, ADMIN o SADMIN.
$config['send_welcome_email'] = false;  // Depende de activation email.

// Opciones de Seguridad
$config['use_salt'] = true;
$config['save_last_login'] = true;
$config['csrf_protection'] = true;
$config['hidden_login'] = false;
$config['save_failed_attempt'] = true; // Esto guarda los intentos fallidos. Necesario para que el bloqueo funcione.
$config['attempts_to_block'] = 4; // El cero desactiva el bloqueo por intentos fallidos.
$config['failed_attempt_expire'] = 600; // Tiempo (en segundos) para que el intento de login fallido no se tome en cuenta.
$config['blocking_time'] = 30; // Tiempo de espera (en segundos) para desbloquear cuenta bloqueada.
$config['password_reset'] = true; // Activa la opción de recuperar clave si el usuario la olvida. [mail]

/*
| -------------------------------------------------------------------
| Configuración de Personalización
| -------------------------------------------------------------------
| Esto es lo que hace que tu 
|
|
*/
$config['app_name'] = 'Ncai Auth System for CI';
$config['app_motto'] = 'Te ahorramos el trabajo pesado.';
$config['company_address'] = 'Huérfanos 1055, Oficina 503. Santiago, Chile.';
$config['app_url'] = base_url();
$config['email_body_background_color'] = '#FFFFFF';
$config['email_body_font_color'] = '#4E4E4E';
$config['email_header_background_color'] = '#F2F2F2';
$config['email_header_font_color'] = '#4E4E4E';
$config['email_footer_background_color'] = '#F2F2F2';
$config['email_footer_font_color'] = '#4E4E4E';
$config['email_font_color'] = '#4E4E4E';
$config['email_brand_color'] = '#EA3A17';
$config['email_container_background_color'] = '#F2F2F2';
$config['app_logo_url'] = 'assets/img/email/logo.png'; // 191 x 60 pixels for the best result. Transparent Background PNG.
$config['email_social_style'] = 'dark'; // Tienes light, dark, y brand.
$config['email_social_links'] = [
    [ 'name'  => 'facebook', 'url'   => '#' ],
    [ 'name'  => 'twitter', 'url'   => '#' ],
    [ 'name'  => 'instagram', 'url'   => '#' ]
];

// Texto Email Activación
$config['email_activation_subject'] = 'Activación de Cuenta';
$config['email_activation_title'] = 'Por favor, activa tu cuenta.';
$config['email_activation_paragraphs'] = [
    'p1' => 'Estimado Usuario:',
    'p2' => '¡Gracias por registrarte con nosotros! Por favor, activa tu cuenta presionando el enlace más abajo.',
    'p3' => 'Muchas gracias por preferirnos,',
    'p4' => 'Ncai SpA'
];
$config['email_activation_button_text'] = 'Activar Cuenta';


// Texto Email Bienvenida
$config['email_welcome_subject'] = 'Bienvenido';
$config['email_welcome_title'] = '';
$config['email_welcome_paragraphs'] = [
    'p1' => '',
    'p2' => ''
];
$config['email_welcome_button_text'] = '';

// Texto Email Cambio Contraseña
$config['email_passchange_subject'] = 'Cambio de Contraseña';
$config['email_passchange_title'] = '¡Ooops!';
$config['email_passchange_paragraphs'] = [
    'p1' => 'Estás recibiendo este email porque alguien ha solicitado restaurar la contraseña asociada a tu cuenta de correo.',
    'p2' => 'Si no has sido tú quien ha hecho esto, entonces no hagas nada.',
    'p3' => 'Si, por el contrario, has sido tú quien ha solicitado este cambio, puedes llevarlo a cabo haciendo click en el link de más abajo.',
    'p4' => 'Muchas gracias por preferirnos.',
];
$config['email_passchange_button_text'] = 'Cambiar Contraseña';