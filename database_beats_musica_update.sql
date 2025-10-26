-- =====================================================
-- Script: Separación de Beats y Música
-- Fecha: 2025-10-26
-- Descripción: Agrega columna 'tipo' para diferenciar
--              beats (productores) de música (artistas)
-- =====================================================

USE chojin_bd;

-- 1. Agregar columna 'tipo' a la tabla beats
ALTER TABLE beats 
ADD COLUMN tipo ENUM('beat', 'musica') NOT NULL DEFAULT 'beat' 
AFTER id_productor;

-- 2. Actualizar registros existentes según el rol del usuario
-- Los beats de productores mantienen tipo='beat'
-- Los tracks de artistas se marcan como tipo='musica'

UPDATE beats b
INNER JOIN usuarios u ON b.id_productor = u.id
SET b.tipo = 'musica'
WHERE u.rol = 'artista';

-- 3. Los beats de productores y super_admin quedan como 'beat' (ya es default)
-- No necesita UPDATE adicional

-- 4. Verificar los cambios
SELECT 
    b.id,
    b.titulo,
    b.tipo,
    u.username,
    u.rol,
    b.precio
FROM beats b
INNER JOIN usuarios u ON b.id_productor = u.id
ORDER BY b.tipo, b.id;

-- =====================================================
-- RESUMEN DE CAMBIOS:
-- =====================================================
-- ✅ Columna 'tipo' agregada (beat/musica)
-- ✅ Música de artistas marcada automáticamente
-- ✅ Beats de productores marcados por defecto
-- ✅ Listo para separación en vistas
-- =====================================================

-- NOTA: La música de artistas debería tener precio = 0.00
-- Si quieres ajustar eso automáticamente, descomenta:

-- UPDATE beats 
-- SET precio = 0.00 
-- WHERE tipo = 'musica';
