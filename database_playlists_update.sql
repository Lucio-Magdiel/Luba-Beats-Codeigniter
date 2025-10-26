-- =====================================================
-- Script: Actualización de Playlists
-- Fecha: 2025-10-26
-- Descripción: Agregar columnas faltantes
-- =====================================================

USE chojin_bd;

-- Actualizar tabla playlists
ALTER TABLE playlists 
ADD COLUMN IF NOT EXISTS descripcion TEXT AFTER nombre,
ADD COLUMN IF NOT EXISTS imagen_portada VARCHAR(255) DEFAULT NULL AFTER descripcion,
ADD COLUMN IF NOT EXISTS es_publica TINYINT(1) DEFAULT 1 AFTER imagen_portada,
ADD COLUMN IF NOT EXISTS fecha_actualizacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER fecha;

-- Renombrar columna fecha a fecha_creacion
ALTER TABLE playlists 
CHANGE COLUMN fecha fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP;

-- Actualizar tabla playlist_beats
ALTER TABLE playlist_beats
ADD COLUMN IF NOT EXISTS orden INT(11) DEFAULT 0 AFTER id_beat,
ADD COLUMN IF NOT EXISTS fecha_agregado DATETIME DEFAULT CURRENT_TIMESTAMP AFTER orden;

-- Verificar cambios
DESCRIBE playlists;
DESCRIBE playlist_beats;

SELECT 'Tablas actualizadas correctamente' AS resultado;
