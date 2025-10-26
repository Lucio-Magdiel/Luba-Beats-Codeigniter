<?php

/**
 * SCRIPT DE MIGRACIÓN A CLOUDINARY
 * 
 * Este script migra archivos existentes desde public/uploads/ a Cloudinary
 * 
 * USO:
 * 1. Configura primero tus credenciales en el archivo .env
 * 2. Ejecuta: php spark migrate:cloudinary
 * 
 * IMPORTANTE: Este script NO elimina los archivos locales automáticamente
 * Primero verifica que todo funcione en Cloudinary antes de borrar
 */

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Libraries\CloudinaryService;
use App\Models\BeatModel;
use App\Models\UsuarioModel;

class MigrateCloudinary extends BaseCommand
{
    protected $group       = 'Cloudinary';
    protected $name        = 'migrate:cloudinary';
    protected $description = 'Migra archivos locales de uploads/ a Cloudinary';
    
    public function run(array $params)
    {
        $cloudinary = new CloudinaryService();
        $beatModel = new BeatModel();
        $usuarioModel = new UsuarioModel();
        
        CLI::write('========================================', 'green');
        CLI::write('MIGRACIÓN DE ARCHIVOS A CLOUDINARY', 'green');
        CLI::write('========================================', 'green');
        CLI::newLine();
        
        // Contador de éxitos/errores
        $stats = [
            'beats_audio' => ['success' => 0, 'error' => 0],
            'beats_visual' => ['success' => 0, 'error' => 0],
            'perfiles' => ['success' => 0, 'error' => 0],
            'banners' => ['success' => 0, 'error' => 0],
        ];
        
        // 1. MIGRAR BEATS Y MÚSICA
        CLI::write('1. Migrando archivos de audio...', 'yellow');
        $beats = $beatModel->findAll();
        
        foreach ($beats as $beat) {
            // Audio
            if ($beat['archivo_preview'] && strpos($beat['archivo_preview'], 'uploads/') === 0) {
                $filePath = ROOTPATH . 'public/' . $beat['archivo_preview'];
                
                if (file_exists($filePath)) {
                    $tipo = $beat['tipo'] === 'beat' ? 'beats' : 'musica';
                    $result = $cloudinary->uploadAudio($filePath, 'chojin/' . $tipo, [
                        'public_id' => $tipo . '_' . $beat['id']
                    ]);
                    
                    if ($result['success']) {
                        $beatModel->update($beat['id'], ['archivo_preview' => $result['url']]);
                        $stats['beats_audio']['success']++;
                        CLI::write("  ✓ Audio #{$beat['id']}: {$beat['titulo']}", 'green');
                    } else {
                        $stats['beats_audio']['error']++;
                        CLI::write("  ✗ Error Audio #{$beat['id']}: {$result['error']}", 'red');
                    }
                }
            }
            
            // Visual
            if ($beat['archivo_visual'] && strpos($beat['archivo_visual'], 'uploads/') === 0) {
                $filePath = ROOTPATH . 'public/' . $beat['archivo_visual'];
                
                if (file_exists($filePath)) {
                    $result = $cloudinary->uploadBeatVisual($filePath, $beat['id']);
                    
                    if ($result['success']) {
                        $beatModel->update($beat['id'], ['archivo_visual' => $result['url']]);
                        $stats['beats_visual']['success']++;
                    } else {
                        $stats['beats_visual']['error']++;
                        CLI::write("  ✗ Error Visual #{$beat['id']}: {$result['error']}", 'red');
                    }
                }
            }
        }
        
        CLI::newLine();
        
        // 2. MIGRAR FOTOS DE PERFIL
        CLI::write('2. Migrando fotos de perfil...', 'yellow');
        $usuarios = $usuarioModel->findAll();
        
        foreach ($usuarios as $usuario) {
            // Foto de perfil
            if ($usuario['foto_perfil'] && strpos($usuario['foto_perfil'], 'uploads/') === 0) {
                $filePath = ROOTPATH . 'public/' . $usuario['foto_perfil'];
                
                if (file_exists($filePath)) {
                    $result = $cloudinary->uploadProfilePhoto($filePath, $usuario['id']);
                    
                    if ($result['success']) {
                        $usuarioModel->update($usuario['id'], ['foto_perfil' => $result['url']]);
                        $stats['perfiles']['success']++;
                        CLI::write("  ✓ Perfil: {$usuario['nombre_usuario']}", 'green');
                    } else {
                        $stats['perfiles']['error']++;
                        CLI::write("  ✗ Error Perfil {$usuario['nombre_usuario']}: {$result['error']}", 'red');
                    }
                }
            }
            
            // Banner
            if ($usuario['banner'] && strpos($usuario['banner'], 'uploads/') === 0) {
                $filePath = ROOTPATH . 'public/' . $usuario['banner'];
                
                if (file_exists($filePath)) {
                    $result = $cloudinary->uploadProfileBanner($filePath, $usuario['id']);
                    
                    if ($result['success']) {
                        $usuarioModel->update($usuario['id'], ['banner' => $result['url']]);
                        $stats['banners']['success']++;
                    } else {
                        $stats['banners']['error']++;
                        CLI::write("  ✗ Error Banner {$usuario['nombre_usuario']}: {$result['error']}", 'red');
                    }
                }
            }
        }
        
        CLI::newLine();
        CLI::write('========================================', 'green');
        CLI::write('RESUMEN DE MIGRACIÓN', 'green');
        CLI::write('========================================', 'green');
        CLI::write("Audios: {$stats['beats_audio']['success']} ✓  {$stats['beats_audio']['error']} ✗", 'white');
        CLI::write("Visuales: {$stats['beats_visual']['success']} ✓  {$stats['beats_visual']['error']} ✗", 'white');
        CLI::write("Perfiles: {$stats['perfiles']['success']} ✓  {$stats['perfiles']['error']} ✗", 'white');
        CLI::write("Banners: {$stats['banners']['success']} ✓  {$stats['banners']['error']} ✗", 'white');
        CLI::newLine();
        
        $total_success = array_sum(array_column($stats, 'success'));
        $total_error = array_sum(array_column($stats, 'error'));
        
        CLI::write("TOTAL: {$total_success} archivos migrados exitosamente", 'green');
        if ($total_error > 0) {
            CLI::write("       {$total_error} archivos con errores", 'red');
        }
        
        CLI::newLine();
        CLI::write('¡Migración completada!', 'green');
        CLI::write('Verifica que todo funcione correctamente antes de eliminar archivos locales.', 'yellow');
    }
}
