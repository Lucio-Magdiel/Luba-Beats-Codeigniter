-- =====================================================
-- Script: Limpieza de Usuarios
-- Fecha: 2025-10-28
-- Descripción: Elimina todos los usuarios excepto magdiel
--              y agrega CASCADE para eliminación automática
-- =====================================================

USE chojin_bd;

-- =====================================================
-- PASO 1: Agregar CASCADE a la tabla beats
-- =====================================================

-- Eliminar la foreign key actual
ALTER TABLE beats DROP FOREIGN KEY beats_ibfk_1;

-- Agregar la foreign key CON cascade
ALTER TABLE beats 
ADD CONSTRAINT beats_ibfk_1 
FOREIGN KEY (id_productor) 
REFERENCES usuarios(id) 
ON DELETE CASCADE 
ON UPDATE CASCADE;

-- Verificar el cambio
SHOW CREATE TABLE beats;

-- =====================================================
-- PASO 2: Verificar usuarios antes de eliminar
-- =====================================================

SELECT 
    id,
    nombre_usuario,
    correo,
    tipo,
    COUNT(*) OVER() as total_usuarios
FROM usuarios
ORDER BY id;

-- =====================================================
-- PASO 3: Contar beats y playlists por usuario
-- =====================================================

SELECT 
    u.id,
    u.nombre_usuario,
    u.tipo,
    COUNT(DISTINCT b.id) as total_beats,
    COUNT(DISTINCT p.id) as total_playlists
FROM usuarios u
LEFT JOIN beats b ON u.id = b.id_productor
LEFT JOIN playlists p ON u.id = p.id_usuario
WHERE u.id != 8  -- Excluir a magdiel
GROUP BY u.id, u.nombre_usuario, u.tipo
ORDER BY total_beats DESC;

-- =====================================================
-- PASO 4: ELIMINAR todos los usuarios excepto magdiel
-- =====================================================

-- ⚠️ ADVERTENCIA: Esto eliminará PERMANENTEMENTE:
-- - Todos los usuarios (excepto magdiel ID:8)
-- - Todos sus beats (gracias al CASCADE)
-- - Todas sus playlists (gracias al CASCADE)
-- - Todos los items de sus playlists (gracias al CASCADE)

DELETE FROM usuarios 
WHERE id != 8;

-- =====================================================
-- PASO 5: Verificar resultado
-- =====================================================

SELECT 
    id,
    nombre_usuario,
    correo,
    tipo,
    fecha_registro
FROM usuarios;

SELECT COUNT(*) as total_beats_restantes FROM beats;
SELECT COUNT(*) as total_playlists_restantes FROM playlists;

-- =====================================================
-- RESUMEN FINAL
-- =====================================================

SELECT 
    'LIMPIEZA COMPLETADA' as status,
    (SELECT COUNT(*) FROM usuarios) as usuarios_restantes,
    (SELECT COUNT(*) FROM beats) as beats_restantes,
    (SELECT COUNT(*) FROM playlists) as playlists_restantes;

-- =====================================================
-- NOTAS IMPORTANTES:
-- =====================================================
-- ✅ Solo quedará el usuario: magdiel (ID: 8)
-- ✅ Solo quedarán los beats de magdiel
-- ✅ Solo quedarán las playlists de magdiel
-- ✅ Se agregó CASCADE para futuras eliminaciones
-- ⚠️ ESTA ACCIÓN NO SE PUEDE DESHACER
-- =====================================================
