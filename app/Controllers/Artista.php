<?php

namespace App\Controllers;

use App\Models\BeatModel;
use App\Libraries\CloudinaryService;
use CodeIgniter\Controller;

class Artista extends Controller
{
    protected $beatModel;
    protected $cloudinary;

    public function __construct()
    {
        helper(['form', 'url', 'session']);
        $this->beatModel = new BeatModel();
        $this->cloudinary = new CloudinaryService();
    }

    /**
     * Panel del artista
     */
    public function panel()
    {
        $session = session();
        $id_artista = $session->get('id');

        $beats = $this->beatModel->where('id_productor', $id_artista)
                                 ->where('estado !=', 'eliminado')
                                 ->findAll();

        return view('artista/panel', ['beats' => $beats]);
    }

    /**
     * Subir nueva canción/beat
     */
    public function subir()
    {
        return view('artista/subir');
    }

    /**
     * Guardar nueva canción
     * NOTA: Los artistas NO pueden establecer precio, sus beats son gratuitos o solo para mostrar
     */
    public function guardar()
    {
        $session = session();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'titulo'         => [
                'label' => 'Título',
                'rules' => 'required|min_length[2]|max_length[200]',
            ],
            'genero'         => [
                'label' => 'Género',
                'rules' => 'required|max_length[100]',
            ],
            'bpm'            => [
                'label' => 'BPM',
                'rules' => 'permit_empty|numeric|greater_than[0]|less_than_equal_to[999]',
            ],
            'archivo_preview'=> [
                'label' => 'Archivo de audio',
                'rules' => 'uploaded[archivo_preview]|max_size[archivo_preview,102400]|ext_in[archivo_preview,mp3,wav]|mime_in[archivo_preview,audio/mpeg,audio/mp3,audio/wav,audio/x-wav]',
            ],
            'archivo_visual' => [
                'label' => 'Archivo visual',
                'rules' => 'if_exist|max_size[archivo_visual,51200]|ext_in[archivo_visual,jpg,jpeg,png,gif,mp4]|mime_in[archivo_visual,image/jpeg,image/jpg,image/png,image/gif,video/mp4]',
            ],
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return view('artista/subir', [
                'validation' => $this->validator
            ]);
        }

        $archivoPreview = $this->request->getFile('archivo_preview');
        
        // Validación adicional de tipo MIME
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $archivoPreview->getTempName());
        finfo_close($finfo);
        
        $mimePermitidos = ['audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/x-wav'];
        if (!in_array($mimeType, $mimePermitidos)) {
            session()->setFlashdata('error', 'El archivo de audio debe ser MP3 o WAV.');
            return redirect()->to('/artista/subir');
        }
        
        // Subir audio a Cloudinary
        $musicaId = time() . '_' . $this->request->getPost('titulo');
        $audioResult = $this->cloudinary->uploadAudio(
            $archivoPreview->getTempName(),
            'chojin/musica', // Carpeta diferente para música
            ['public_id' => 'musica_' . $musicaId]
        );
        
        if (!$audioResult['success']) {
            session()->setFlashdata('error', 'Error al subir el archivo de audio: ' . $audioResult['error']);
            return redirect()->to('/artista/subir');
        }

        $archivoVisual = $this->request->getFile('archivo_visual');
        $urlVisual = null;
        
        if ($archivoVisual && $archivoVisual->isValid()) {
            // Validación adicional de tipo MIME para visuales
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeTypeVisual = finfo_file($finfo, $archivoVisual->getTempName());
            finfo_close($finfo);
            
            $mimeVisualesPermitidos = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'video/mp4'];
            if (!in_array($mimeTypeVisual, $mimeVisualesPermitidos)) {
                session()->setFlashdata('error', 'El archivo visual debe ser JPG, PNG, GIF o MP4.');
                return redirect()->to('/artista/subir');
            }
            
            // Subir visual a Cloudinary
            $visualResult = $this->cloudinary->uploadImage(
                $archivoVisual->getTempName(),
                'chojin/visuales/musica',
                ['public_id' => 'musica_visual_' . $musicaId]
            );
            
            if ($visualResult['success']) {
                $urlVisual = $visualResult['url'];
            }
        }

        // Los artistas NO pueden poner precio, su contenido es gratuito
        $this->beatModel->insert([
            'id_productor'    => $session->get('id'),
            'tipo'            => 'musica',  // Artista siempre sube música
            'titulo'          => $this->request->getPost('titulo'),
            'genero'          => $this->request->getPost('genero'),
            'bpm'             => $this->request->getPost('bpm') ?: null,
            'mood'            => $this->request->getPost('mood'),
            'precio'          => 0.00,  // SIEMPRE 0 para artistas
            'archivo_preview' => $audioResult['url'],
            'archivo_visual'  => $urlVisual,
            'estado'          => 'publico',
            'fecha_subida'    => date('Y-m-d H:i:s'),
            'duracion'        => $this->request->getPost('duracion'),
            'nota_musical'    => $this->request->getPost('nota_musical'),
        ]);

        session()->setFlashdata('mensaje', '¡Canción subida exitosamente!');
        return redirect()->to('/artista/panel');
    }

    /**
     * Editar canción
     */
    public function editar($id)
    {
        $session = session();
        $beat = $this->beatModel->find($id);

        if (!$beat || $beat['id_productor'] != $session->get('id')) {
            session()->setFlashdata('error', 'No tienes permiso para editar esta canción.');
            return redirect()->to('/artista/panel');
        }

        return view('artista/editar', ['beat' => $beat]);
    }

    /**
     * Actualizar canción
     */
    public function actualizar($id)
    {
        $session = session();
        $beat = $this->beatModel->find($id);
        
        if (!$beat || $beat['id_productor'] != $session->get('id')) {
            session()->setFlashdata('error', 'No tienes permiso para actualizar esta canción.');
            return redirect()->to('/artista/panel');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'titulo'         => [
                'label' => 'Título',
                'rules' => 'required|min_length[2]|max_length[200]',
            ],
            'genero'         => [
                'label' => 'Género',
                'rules' => 'required|max_length[100]',
            ],
            'bpm'            => [
                'label' => 'BPM',
                'rules' => 'permit_empty|numeric|greater_than[0]|less_than_equal_to[999]',
            ],
            'archivo_preview'=> [
                'label' => 'Archivo de audio',
                'rules' => 'if_exist|max_size[archivo_preview,102400]|ext_in[archivo_preview,mp3,wav]|mime_in[archivo_preview,audio/mpeg,audio/mp3,audio/wav,audio/x-wav]',
            ],
            'archivo_visual' => [
                'label' => 'Archivo visual',
                'rules' => 'if_exist|max_size[archivo_visual,51200]|ext_in[archivo_visual,jpg,jpeg,png,gif,mp4]|mime_in[archivo_visual,image/jpeg,image/jpg,image/png,image/gif,video/mp4]',
            ],
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return view('artista/editar', [
                'beat' => $beat,
                'validation' => $this->validator
            ]);
        }

        $data = [
            'titulo'        => $this->request->getPost('titulo'),
            'genero'        => $this->request->getPost('genero'),
            'mood'          => $this->request->getPost('mood'),
            'bpm'           => $this->request->getPost('bpm') ?: null,
            'duracion'      => $this->request->getPost('duracion'),
            'nota_musical'  => $this->request->getPost('nota_musical'),
            'precio'        => 0.00,  // SIEMPRE 0 para artistas
        ];

        // Actualizar audio si se subió uno nuevo
        $archivoPreview = $this->request->getFile('archivo_preview');
        if ($archivoPreview && $archivoPreview->isValid()) {
            $musicaId = $id . '_' . time();
            $audioResult = $this->cloudinary->uploadAudio(
                $archivoPreview->getTempName(),
                'chojin/musica',
                ['public_id' => 'musica_' . $musicaId]
            );
            
            if ($audioResult['success']) {
                $data['archivo_preview'] = $audioResult['url'];
            }
        }

        // Actualizar visual si se subió uno nuevo
        $archivoVisual = $this->request->getFile('archivo_visual');
        if ($archivoVisual && $archivoVisual->isValid()) {
            $musicaId = $id . '_' . time();
            $visualResult = $this->cloudinary->uploadImage(
                $archivoVisual->getTempName(),
                'chojin/visuales/musica',
                ['public_id' => 'musica_visual_' . $musicaId]
            );
            
            if ($visualResult['success']) {
                $data['archivo_visual'] = $visualResult['url'];
            }
        }

        $this->beatModel->update($id, $data);

        session()->setFlashdata('mensaje', 'Canción actualizada correctamente.');
        return redirect()->to('/artista/panel');
    }

    /**
     * Ocultar canción
     */
    public function esconder($id)
    {
        $session = session();
        $beat = $this->beatModel->find($id);
        
        if (!$beat || $beat['id_productor'] != $session->get('id')) {
            session()->setFlashdata('error', 'No tienes permiso para ocultar esta canción.');
            return redirect()->to('/artista/panel');
        }

        $this->beatModel->update($id, ['estado' => 'oculto']);
        session()->setFlashdata('mensaje', 'Canción ocultada.');
        return redirect()->to('/artista/panel');
    }

    /**
     * Publicar canción
     */
    public function publicar($id)
    {
        $session = session();
        $beat = $this->beatModel->find($id);
        
        if (!$beat || $beat['id_productor'] != $session->get('id')) {
            session()->setFlashdata('error', 'No tienes permiso para publicar esta canción.');
            return redirect()->to('/artista/panel');
        }

        $this->beatModel->update($id, ['estado' => 'publico']);
        session()->setFlashdata('mensaje', 'Canción publicada nuevamente.');
        return redirect()->to('/artista/panel');
    }

    /**
     * Eliminar canción
     */
    public function eliminar($id)
    {
        $session = session();
        $beat = $this->beatModel->find($id);
        
        if (!$beat || $beat['id_productor'] != $session->get('id')) {
            session()->setFlashdata('error', 'No tienes permiso para eliminar esta canción.');
            return redirect()->to('/artista/panel');
        }

        $this->beatModel->update($id, ['estado' => 'eliminado']);
        session()->setFlashdata('mensaje', 'Canción eliminada.');
        return redirect()->to('/artista/panel');
    }
}
