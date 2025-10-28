-- ============================================
-- ACTUALIZACIÓN DE BASE DE DATOS - CHOJIN BEATS
-- Fecha: 26 de Octubre, 2025
-- Descripción: Agregar roles 'super_admin' y 'artista'
-- ============================================

-- PASO 1: Modificar el campo 'tipo' para incluir los nuevos roles
-- ============================================

ALTER TABLE `usuarios` 
MODIFY COLUMN `tipo` ENUM('super_admin', 'productor', 'artista', 'comprador') 
NOT NULL DEFAULT 'comprador';


-- ============================================
-- PASO 2 (OPCIONAL): Crear el primer Super Admin
-- ============================================

-- OPCIÓN A: Convertir un usuario existente a Super Admin
-- Convertir a magdiel (ID 8) en Super Admin
UPDATE `usuarios` 
SET `tipo` = 'super_admin' 
WHERE `id` = 8;


-- OPCIÓN B: Crear un nuevo usuario Super Admin desde cero
-- Descomenta las siguientes líneas y ajusta los datos:
    
-- INSERT INTO `usuarios` 
-- (`nombre_usuario`, `correo`, `contrasena`, `tipo`, `fecha_registro`) 
-- VALUES 
-- (
--     'admin',                                                           -- Usuario
--     'admin@chojin.com',                                               -- Correo
--     '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5eo9pKHKOYc4u',  -- Contraseña: "admin123"
--     'super_admin',                                                    -- Tipo
--     NOW()                                                             -- Fecha registro
-- );


-- ============================================
-- PASO 3: Verificar los cambios
-- ============================================

-- Ver la estructura actualizada de la tabla usuarios
DESCRIBE `usuarios`;

-- Ver todos los tipos de usuario disponibles
SHOW COLUMNS FROM `usuarios` LIKE 'tipo';

-- Listar todos los usuarios y sus tipos
SELECT id, nombre_usuario, correo, tipo, fecha_registro 
FROM `usuarios` 
ORDER BY fecha_registro DESC;


-- ============================================
-- NOTAS IMPORTANTES:
-- ============================================

-- 1. La contraseña del ejemplo "admin123" está hasheada con PASSWORD_BCRYPT cost 12
--    Si quieres otra contraseña, usa este código PHP:
--    echo password_hash('tu_contraseña', PASSWORD_BCRYPT, ['cost' => 12]);

-- 2. Los tipos de usuario ahora son:
--    - super_admin: Administrador total del sistema
--    - productor:   Vende beats con precio
--    - artista:     Comparte música gratis (precio = 0)
--    - comprador:   Usuario/Fan del sitio

-- 3. Si ya tenías usuarios con tipo 'usuario', estos automáticamente
--    se quedarán como 'comprador' (valor por defecto)

-- ============================================
-- ROLLBACK (Si necesitas revertir los cambios)
-- ============================================

-- Para volver a la configuración anterior:
-- ALTER TABLE `usuarios` 
-- MODIFY COLUMN `tipo` ENUM('productor', 'comprador') 
-- NOT NULL DEFAULT 'comprador';

