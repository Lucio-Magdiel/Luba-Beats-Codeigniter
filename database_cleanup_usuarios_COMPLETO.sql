-- =================================================================
-- SCRIPT DE LIMPIEZA COMPLETA: ELIMINAR TODOS LOS USUARIOS EXCEPTO MAGDIEL
-- Usuario a preservar: magdiel (ID: 8)
-- =================================================================

USE chojin_bd;

-- -----------------------------------------------------------------
-- PASO 1: AGREGAR CASCADE A TABLA BEATS (YA COMPLETADO)
-- -----------------------------------------------------------------
-- Este paso ya fue ejecutado exitosamente. Beats ahora tiene CASCADE.

-- -----------------------------------------------------------------
-- PASO 2: AGREGAR CASCADE A TABLA PLAYLISTS
-- -----------------------------------------------------------------
SELECT '=== AGREGANDO CASCADE A PLAYLISTS ===' AS '';

-- Eliminar el constraint existente
ALTER TABLE playlists DROP FOREIGN KEY playlists_ibfk_1;

-- Agregar el constraint con CASCADE
ALTER TABLE playlists 
ADD CONSTRAINT playlists_ibfk_1 
FOREIGN KEY (id_usuario) REFERENCES usuarios(id) 
ON DELETE CASCADE 
ON UPDATE CASCADE;

-- Verificar que se aplicó correctamente
SELECT '=== VERIFICACIÓN: PLAYLISTS CON CASCADE ===' AS '';
SHOW CREATE TABLE playlists\G

-- -----------------------------------------------------------------
-- PASO 3: VERIFICAR DATOS ANTES DE ELIMINAR
-- -----------------------------------------------------------------
SELECT '=== USUARIOS ACTUALES (ANTES DE ELIMINAR) ===' AS '';
SELECT id, nombre_usuario, correo, tipo, 
(SELECT COUNT(*) FROM usuarios) AS total_usuarios 
FROM usuarios 
ORDER BY id;

SELECT '=== BEATS POR USUARIO ===' AS '';
SELECT u.id, u.nombre_usuario, u.tipo, COUNT(b.id) AS total_beats,
(SELECT COUNT(*) FROM playlists WHERE id_usuario = u.id) AS total_playlists
FROM usuarios u 
LEFT JOIN beats b ON b.id_productor = u.id 
GROUP BY u.id, u.nombre_usuario, u.tipo
ORDER BY total_beats DESC;

-- -----------------------------------------------------------------
-- PASO 4: ELIMINAR TODOS LOS USUARIOS EXCEPTO MAGDIEL (ID: 8)
-- -----------------------------------------------------------------
SELECT '=== ELIMINANDO USUARIOS (EXCEPTO MAGDIEL ID=8) ===' AS '';

-- Esta línea eliminará automáticamente:
-- - Todos sus beats (gracias a CASCADE en beats)
-- - Todas sus playlists (gracias a CASCADE en playlists)
-- - Todos los playlist_items de sus playlists (gracias a CASCADE existente)
DELETE FROM usuarios WHERE id != 8;

-- -----------------------------------------------------------------
-- PASO 5: VERIFICAR RESULTADOS
-- -----------------------------------------------------------------
SELECT '=== USUARIOS RESTANTES (DESPUÉS DE ELIMINAR) ===' AS '';
SELECT id, nombre_usuario, correo, tipo, 
(SELECT COUNT(*) FROM usuarios) AS total_usuarios 
FROM usuarios;

SELECT '=== BEATS RESTANTES ===' AS '';
SELECT COUNT(*) AS total_beats FROM beats;

SELECT '=== PLAYLISTS RESTANTES ===' AS '';
SELECT COUNT(*) AS total_playlists FROM playlists;

SELECT '=== FAVORITOS RESTANTES ===' AS '';
SELECT COUNT(*) AS total_favoritos FROM favoritos;

SELECT '=== ¡LIMPIEZA COMPLETA EXITOSA! ===' AS '';
