<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');
$routes->get('/', 'Catalogo::index'); // Muestra el catálogo público

// Prueba
$routes->get('dbtest', 'DbTest::index');

// Rutas de autenticación (sin protección CSRF en GET, con CSRF en POST)
$routes->get('auth/login', 'Auth::login');
$routes->post('auth/procesar_login', 'Auth::procesar_login');
$routes->get('auth/registro', 'Auth::registro');
$routes->post('auth/procesar_registro', 'Auth::procesar_registro');
$routes->get('auth/logout', 'Auth::logout');

// Completar perfil (OAuth y Magic Link)
$routes->get('auth/completar-perfil', 'Auth::completarPerfil');
$routes->post('auth/procesar-completar-perfil', 'Auth::procesarCompletarPerfil');

// Google OAuth
$routes->get('auth/google', 'Auth::loginWithGoogle');
$routes->get('auth/google/callback', 'Auth::googleCallback');

// Magic Link
$routes->post('auth/send-magic-link', 'Auth::sendMagicLink');
$routes->get('auth/verify-magic-link/(:any)', 'Auth::verifyMagicLink/$1');


// ==========================================
// RUTAS DE SUPER ADMIN (Protegidas con filtro 'superadmin')
// ==========================================
$routes->group('admin', ['filter' => 'superadmin'], function($routes) {
    $routes->get('dashboard', 'Admin::dashboard');
    $routes->get('usuarios', 'Admin::usuarios');
    $routes->match(['get', 'post'], 'editar-usuario/(:num)', 'Admin::editarUsuario/$1');
    $routes->get('eliminar-usuario/(:num)', 'Admin::eliminarUsuario/$1');
    $routes->get('beats', 'Admin::beats');
    $routes->get('eliminar-beat/(:num)', 'Admin::eliminarBeat/$1');
    $routes->post('cambiar-estado-beat/(:num)', 'Admin::cambiarEstadoBeat/$1');
});


// ==========================================
// RUTAS DE PRODUCTOR (Protegidas con filtro 'productor')
// ==========================================
$routes->group('productor', ['filter' => 'productor'], function($routes) {
    $routes->get('panel', 'Productor::panel');
    $routes->get('subir', 'Productor::subir');
    $routes->post('guardar', 'Productor::guardar');
    $routes->get('editar/(:num)', 'Productor::editar/$1');
    $routes->post('editar/(:num)', 'Productor::actualizar/$1');
    $routes->post('actualizar/(:num)', 'Productor::actualizar/$1');
    $routes->get('esconder/(:num)', 'Productor::esconder/$1');
    $routes->get('eliminar/(:num)', 'Productor::eliminar/$1');
    $routes->get('publicar/(:num)', 'Productor::publicar/$1');
    $routes->match(['get', 'post'], 'editar/(:num)', 'Productor::editar/$1');
});


// ==========================================
// RUTAS DE ARTISTA (Protegidas con filtro 'artista')
// ==========================================
$routes->group('artista', ['filter' => 'artista'], function($routes) {
    $routes->get('panel', 'Artista::panel');
    $routes->get('subir', 'Artista::subir');
    $routes->post('guardar', 'Artista::guardar');
    $routes->get('editar/(:num)', 'Artista::editar/$1');
    $routes->post('editar/(:num)', 'Artista::actualizar/$1');
    $routes->post('actualizar/(:num)', 'Artista::actualizar/$1');
    $routes->get('esconder/(:num)', 'Artista::esconder/$1');
    $routes->get('eliminar/(:num)', 'Artista::eliminar/$1');
    $routes->get('publicar/(:num)', 'Artista::publicar/$1');
});


// ==========================================
// RUTAS DEL CATÁLOGO (Públicas)
// ==========================================
$routes->get('catalogo', 'Catalogo::index');
$routes->get('catalogo/beats', 'Catalogo::beats');        // Nueva: Solo beats
$routes->get('catalogo/musica', 'Catalogo::musica');      // Nueva: Solo música
$routes->get('catalogo/detalle/(:num)', 'Catalogo::detalle/$1');

// Favoritos (Protegidos con filtro 'auth')
$routes->group('catalogo', ['filter' => 'auth'], function($routes) {
    $routes->get('agregar_favorito/(:num)', 'Catalogo::agregar_favorito/$1');
    $routes->get('quitar_favorito/(:num)', 'Catalogo::quitar_favorito/$1');
    $routes->post('agregar_favorito/(:num)', 'Catalogo::agregar_favorito/$1');
    $routes->post('quitar_favorito/(:num)', 'Catalogo::quitar_favorito/$1');
    $routes->get('mis_favoritos', 'Catalogo::mis_favoritos');
});


// ==========================================
// RUTAS DE USUARIO (Protegidas con filtro 'auth')
// ==========================================
$routes->group('usuario', ['filter' => 'auth'], function($routes) {
    $routes->get('catalogo', 'Usuario::catalogo');
    
    // Perfil privado
    $routes->get('mi-perfil', 'Usuario::miPerfil');
    $routes->post('actualizar-perfil', 'Usuario::actualizarPerfil');
    
    // Playlists
    $routes->get('playlists', 'Usuario::misPlaylists');
    $routes->post('playlist/crear', 'Usuario::crearPlaylist');
    $routes->get('playlist/editar/(:num)', 'Usuario::editarPlaylist/$1');
    $routes->post('playlist/actualizar/(:num)', 'Usuario::actualizarPlaylist/$1');
    $routes->post('playlist/eliminar/(:num)', 'Usuario::eliminarPlaylist/$1');
    
    // Agregar/quitar beats de playlist (AJAX)
    $routes->post('playlist/agregar-beat', 'Usuario::agregarBeatPlaylist');
    $routes->post('playlist/quitar-beat', 'Usuario::quitarBeatPlaylist');
    $routes->post('playlist/reordenar', 'Usuario::reordenarPlaylist');
});


// ==========================================
// RUTAS DE PERFIL PÚBLICO
// ==========================================
$routes->get('perfil/(:alpha)', 'Perfil::ver/$1');
$routes->get('perfil/(:alpha)/playlist/(:num)', 'Perfil::verPlaylist/$1/$2');


// ==========================================
// API (AJAX)
// ==========================================
$routes->get('api/playlists/usuario', 'Api::playlistsUsuario', ['filter' => 'auth']);


// Contacto
$routes->get('contacto', 'Home::contacto');
$routes->post('contacto', 'Home::enviarContacto');

// Ruta para el perfil de Magdiel
$routes->get('magdiel', 'Magdiel::index');

// Página Acerca de
$routes->get('about', 'About::index');
$routes->get('acerca-de', 'About::index'); // Alias en español
