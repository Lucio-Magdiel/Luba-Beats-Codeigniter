<?php

namespace App\Libraries;

use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;

/**
 * CloudinaryService
 * 
 * Servicio para gestionar uploads de archivos a Cloudinary
 * Soporta: imágenes (jpg, png, webp), audio (mp3, wav, ogg)
 */
class CloudinaryService
{
    protected $cloudinary;
    
    public function __construct()
    {
        // Cargar configuración desde .env usando método de CodeIgniter
        $config = [
            'cloud' => [
                'cloud_name' => env('cloudinary.cloudName'),
                'api_key'    => env('cloudinary.apiKey'),
                'api_secret' => env('cloudinary.apiSecret'),
            ],
            'url' => [
                'secure' => true // Usar HTTPS
            ]
        ];
        
        $this->cloudinary = new Cloudinary($config);
    }
    
    /**
     * Subir imagen (foto de perfil, banner, portada)
     * 
     * @param string $filePath Ruta temporal del archivo
     * @param string $folder Carpeta en Cloudinary (ej: 'chojin/profiles')
     * @param array $options Opciones adicionales (transformaciones, etc)
     * @return array ['success' => bool, 'url' => string, 'public_id' => string]
     */
    public function uploadImage($filePath, $folder = 'chojin/images', $options = [])
    {
        try {
            $defaultOptions = [
                'folder' => $folder,
                'resource_type' => 'image',
                'overwrite' => true,
                'unique_filename' => true,
                'transformation' => [
                    'quality' => 'auto:good', // Optimización automática
                    'fetch_format' => 'auto' // Formato automático (webp si es soportado)
                ]
            ];
            
            $uploadOptions = array_merge($defaultOptions, $options);
            
            $result = $this->cloudinary->uploadApi()->upload($filePath, $uploadOptions);
            
            return [
                'success' => true,
                'url' => $result['secure_url'],
                'public_id' => $result['public_id'],
                'width' => $result['width'] ?? null,
                'height' => $result['height'] ?? null,
                'format' => $result['format'] ?? null
            ];
            
        } catch (\Exception $e) {
            log_message('error', 'Cloudinary Upload Image Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Subir archivo de audio (beat, música)
     * 
     * @param string $filePath Ruta temporal del archivo
     * @param string $folder Carpeta en Cloudinary (ej: 'chojin/beats')
     * @param array $options Opciones adicionales
     * @return array ['success' => bool, 'url' => string, 'public_id' => string]
     */
    public function uploadAudio($filePath, $folder = 'chojin/audio', $options = [])
    {
        try {
            $defaultOptions = [
                'folder' => $folder,
                'resource_type' => 'video', // En Cloudinary, audio usa resource_type 'video'
                'overwrite' => true,
                'unique_filename' => true
            ];
            
            $uploadOptions = array_merge($defaultOptions, $options);
            
            $result = $this->cloudinary->uploadApi()->upload($filePath, $uploadOptions);
            
            return [
                'success' => true,
                'url' => $result['secure_url'],
                'public_id' => $result['public_id'],
                'duration' => $result['duration'] ?? null,
                'format' => $result['format'] ?? null,
                'bytes' => $result['bytes'] ?? null
            ];
            
        } catch (\Exception $e) {
            log_message('error', 'Cloudinary Upload Audio Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Eliminar archivo de Cloudinary
     * 
     * @param string $publicId ID público del archivo en Cloudinary
     * @param string $resourceType Tipo de recurso ('image', 'video', 'raw')
     * @return bool
     */
    public function delete($publicId, $resourceType = 'image')
    {
        try {
            $result = $this->cloudinary->uploadApi()->destroy($publicId, [
                'resource_type' => $resourceType
            ]);
            
            return $result['result'] === 'ok';
            
        } catch (\Exception $e) {
            log_message('error', 'Cloudinary Delete Error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Generar URL optimizada para imagen
     * 
     * @param string $publicId ID público del archivo
     * @param array $transformations Transformaciones (width, height, crop, etc)
     * @return string URL transformada
     */
    public function getImageUrl($publicId, $transformations = [])
    {
        try {
            $defaultTransformations = [
                'quality' => 'auto:good',
                'fetch_format' => 'auto'
            ];
            
            $options = array_merge($defaultTransformations, $transformations);
            
            return $this->cloudinary->image($publicId)->toUrl($options);
            
        } catch (\Exception $e) {
            log_message('error', 'Cloudinary Get Image URL Error: ' . $e->getMessage());
            return '';
        }
    }
    
    /**
     * Generar URL para audio
     * 
     * @param string $publicId ID público del archivo
     * @return string URL del audio
     */
    public function getAudioUrl($publicId)
    {
        try {
            return $this->cloudinary->video($publicId)
                ->toUrl(['resource_type' => 'video']);
                
        } catch (\Exception $e) {
            log_message('error', 'Cloudinary Get Audio URL Error: ' . $e->getMessage());
            return '';
        }
    }
    
    /**
     * Subir foto de perfil optimizada
     * 
     * @param string $filePath Ruta temporal del archivo
     * @param string $userId ID del usuario
     * @return array
     */
    public function uploadProfilePhoto($filePath, $userId)
    {
        return $this->uploadImage($filePath, 'chojin/profiles', [
            'public_id' => 'profile_' . $userId,
            'transformation' => [
                'width' => 400,
                'height' => 400,
                'crop' => 'fill',
                'gravity' => 'face',
                'quality' => 'auto:good',
                'fetch_format' => 'auto'
            ]
        ]);
    }
    
    /**
     * Subir banner de perfil optimizado
     * 
     * @param string $filePath Ruta temporal del archivo
     * @param string $userId ID del usuario
     * @return array
     */
    public function uploadProfileBanner($filePath, $userId)
    {
        return $this->uploadImage($filePath, 'chojin/banners', [
            'public_id' => 'banner_' . $userId,
            'transformation' => [
                'width' => 1920,
                'height' => 400,
                'crop' => 'fill',
                'quality' => 'auto:good',
                'fetch_format' => 'auto'
            ]
        ]);
    }
    
    /**
     * Subir portada de playlist
     * 
     * @param string $filePath Ruta temporal del archivo
     * @param string $playlistId ID de la playlist
     * @return array
     */
    public function uploadPlaylistCover($filePath, $playlistId)
    {
        return $this->uploadImage($filePath, 'chojin/playlists', [
            'public_id' => 'playlist_' . $playlistId,
            'transformation' => [
                'width' => 600,
                'height' => 600,
                'crop' => 'fill',
                'quality' => 'auto:good',
                'fetch_format' => 'auto'
            ]
        ]);
    }
    
    /**
     * Subir visual de beat/música
     * 
     * @param string $filePath Ruta temporal del archivo
     * @param string $beatId ID del beat
     * @return array
     */
    public function uploadBeatVisual($filePath, $beatId)
    {
        return $this->uploadImage($filePath, 'chojin/visuales', [
            'public_id' => 'beat_visual_' . $beatId,
            'transformation' => [
                'width' => 800,
                'height' => 800,
                'crop' => 'fill',
                'quality' => 'auto:good',
                'fetch_format' => 'auto'
            ]
        ]);
    }
    
    /**
     * Subir beat/música (archivo de audio)
     * 
     * @param string $filePath Ruta temporal del archivo
     * @param string $beatId ID del beat
     * @return array
     */
    public function uploadBeatAudio($filePath, $beatId)
    {
        return $this->uploadAudio($filePath, 'chojin/beats', [
            'public_id' => 'beat_' . $beatId
        ]);
    }
}
