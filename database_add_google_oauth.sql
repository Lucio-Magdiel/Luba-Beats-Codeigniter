-- =====================================================
-- Agregar campo para Google OAuth
-- LubaBeats Beta
-- =====================================================

USE chojin_bd;

-- Agregar columna verificado_google si no existe
ALTER TABLE usuarios 
ADD COLUMN IF NOT EXISTS verificado_google TINYINT(1) DEFAULT 0 AFTER bio;

-- Verificar la estructura
DESCRIBE usuarios;

SELECT 'Campo verificado_google agregado exitosamente' AS mensaje;
