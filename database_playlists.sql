-- =====================================================
-- Script: Sistema de Playlists
-- Fecha: 2025-10-26
-- Descripción: Tablas para playlists públicas/privadas
-- =====================================================

USE chojin_bd;

-- 1. Tabla de Playlists
CREATE TABLE IF NOT EXISTS playlists (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT(11) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    imagen_portada VARCHAR(255) DEFAULT NULL,
    es_publica TINYINT(1) DEFAULT 1,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE,
    INDEX idx_usuario (id_usuario),
    INDEX idx_publica (es_publica)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Tabla de relación Playlist-Beats
CREATE TABLE IF NOT EXISTS playlist_beats (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    id_playlist INT(11) NOT NULL,
    id_beat INT(11) NOT NULL,
    orden INT(11) DEFAULT 0,
    fecha_agregado DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_playlist) REFERENCES playlists(id) ON DELETE CASCADE,
    FOREIGN KEY (id_beat) REFERENCES beats(id) ON DELETE CASCADE,
    UNIQUE KEY unique_playlist_beat (id_playlist, id_beat),
    INDEX idx_playlist (id_playlist),
    INDEX idx_beat (id_beat)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Crear playlists de ejemplo
-- Playlist pública del productor chojin
INSERT INTO playlists (id_usuario, nombre, descripcion, es_publica) 
SELECT id, 'Mis Mejores Beats', 'Colección de beats más populares', 1
FROM usuarios WHERE nombre_usuario = 'chojin' LIMIT 1;

-- Playlist privada
INSERT INTO playlists (id_usuario, nombre, descripcion, es_publica) 
SELECT id, 'Work in Progress', 'Beats en desarrollo', 0
FROM usuarios WHERE nombre_usuario = 'chojin' LIMIT 1;

-- 4. Agregar algunos beats a la playlist pública
INSERT INTO playlist_beats (id_playlist, id_beat, orden)
SELECT p.id, b.id, 1
FROM playlists p
CROSS JOIN beats b
WHERE p.nombre = 'Mis Mejores Beats' 
AND b.titulo = 'Yoru x Uchi'
LIMIT 1;

INSERT INTO playlist_beats (id_playlist, id_beat, orden)
SELECT p.id, b.id, 2
FROM playlists p
CROSS JOIN beats b
WHERE p.nombre = 'Mis Mejores Beats' 
AND b.titulo = 'Diamantes'
LIMIT 1;

-- =====================================================
-- RESUMEN:
-- =====================================================
-- ✅ Tabla playlists creada
-- ✅ Tabla playlist_beats creada (relación muchos a muchos)
-- ✅ Playlists de ejemplo agregadas
-- ✅ Sistema listo para crear/editar playlists
-- =====================================================

-- Verificar creación
SELECT 
    p.id,
    p.nombre,
    p.descripcion,
    u.nombre_usuario AS creador,
    CASE WHEN p.es_publica = 1 THEN 'Pública' ELSE 'Privada' END AS visibilidad,
    COUNT(pb.id_beat) AS total_beats
FROM playlists p
INNER JOIN usuarios u ON p.id_usuario = u.id
LEFT JOIN playlist_beats pb ON p.id = pb.id_playlist
GROUP BY p.id
ORDER BY p.fecha_creacion DESC;
