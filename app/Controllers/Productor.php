<?php

namespace App\Controllers;

use App\Models\BeatModel;
use App\Libraries\CloudinaryService;
use CodeIgniter\Controller;

class Productor extends Controller
{
    protected $beatModel;
    protected $cloudinary;

    public function __construct()
    {
        helper(['form', 'url', 'session']);
        $this->beatModel = new BeatModel();
        $this->cloudinary = new CloudinaryService();
    }

    public function panel()
    {
        $session = session();
        $id_productor = $session->get('id');

        $beats = $this->beatModel->where('id_productor', $id_productor)
                                 ->where('estado !=', 'eliminado')
                                 ->findAll();

        return view('productor/panel', ['beats' => $beats]);
    }

    public function subir()
    {
        return view('productor/subir');
    }

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
                'rules' => 'required|numeric|greater_than[0]|less_than_equal_to[999]',
            ],
            'precio'         => [
                'label' => 'Precio',
                'rules' => 'required|decimal|greater_than_equal_to[0]',
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
            return view('productor/subir', [
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
            return redirect()->to('/productor/subir');
        }
        
        // Subir audio a Cloudinary
        $beatId = time() . '_' . $this->request->getPost('titulo');
        $audioResult = $this->cloudinary->uploadBeatAudio(
            $archivoPreview->getTempName(),
            $beatId
        );
        
        if (!$audioResult['success']) {
            session()->setFlashdata('error', 'Error al subir el archivo de audio: ' . $audioResult['error']);
            return redirect()->to('/productor/subir');
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
                return redirect()->to('/productor/subir');
            }
            
            // Subir visual a Cloudinary
            $visualResult = $this->cloudinary->uploadBeatVisual(
                $archivoVisual->getTempName(),
                $beatId
            );
            
            if ($visualResult['success']) {
                $urlVisual = $visualResult['url'];
            }
        }

        $this->beatModel->insert([
            'id_productor'    => $session->get('id'),
            'tipo'            => 'beat',  // Productor siempre sube beats
            'titulo'          => $this->request->getPost('titulo'),
            'genero'          => $this->request->getPost('genero'),
            'bpm'             => $this->request->getPost('bpm'),
            'mood'            => $this->request->getPost('mood'),
            'precio'          => $this->request->getPost('precio'),
            'archivo_preview' => $audioResult['url'],
            'archivo_visual'  => $urlVisual,
            'estado'          => 'publico',
            'fecha_subida'    => date('Y-m-d H:i:s'),
            'duracion'        => $this->request->getPost('duracion'),
            'nota_musical'    => $this->request->getPost('nota_musical'),
        ]);

        session()->setFlashdata('mensaje', '¡Beat subido exitosamente!');
        return redirect()->to('/productor/panel');
    }

    public function editar($id)
    {
        $session = session();
        $beat = $this->beatModel->find($id);

        if (!$beat || $beat['id_productor'] != $session->get('id')) {
            session()->setFlashdata('error', 'No tienes permiso para editar este beat.');
            return redirect()->to('/productor/panel');
        }

        return view('productor/editar', ['beat' => $beat]);
    }

    public function actualizar($id)
    {
        $session = session();
        $beat = $this->beatModel->find($id);
        
        if (!$beat || $beat['id_productor'] != $session->get('id')) {
            session()->setFlashdata('error', 'No tienes permiso para actualizar este beat.');
            return redirect()->to('/productor/panel');
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
                'rules' => 'required|numeric|greater_than[0]|less_than_equal_to[999]',
            ],
            'precio'         => [
                'label' => 'Precio',
                'rules' => 'required|decimal|greater_than_equal_to[0]',
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
            return view('productor/editar', [
                'beat' => $beat,
                'validation' => $this->validator
            ]);
        }

        $data = [
            'titulo'        => $this->request->getPost('titulo'),
            'genero'        => $this->request->getPost('genero'),
            'mood'          => $this->request->getPost('mood'),
            'bpm'           => $this->request->getPost('bpm'),
            'precio'        => $this->request->getPost('precio'),
            'duracion'      => $this->request->getPost('duracion'),
            'nota_musical'  => $this->request->getPost('nota_musical')
        ];

        // Actualizar audio si se subió uno nuevo
        $archivoPreview = $this->request->getFile('archivo_preview');
        if ($archivoPreview && $archivoPreview->isValid()) {
            $beatId = $id . '_' . time();
            $audioResult = $this->cloudinary->uploadBeatAudio(
                $archivoPreview->getTempName(),
                $beatId
            );
            
            if ($audioResult['success']) {
                $data['archivo_preview'] = $audioResult['url'];
            }
        }

        // Actualizar visual si se subió uno nuevo
        $archivoVisual = $this->request->getFile('archivo_visual');
        if ($archivoVisual && $archivoVisual->isValid()) {
            $beatId = $id . '_' . time();
            $visualResult = $this->cloudinary->uploadBeatVisual(
                $archivoVisual->getTempName(),
                $beatId
            );
            
            if ($visualResult['success']) {
                $data['archivo_visual'] = $visualResult['url'];
            }
        }

        $this->beatModel->update($id, $data);

        session()->setFlashdata('mensaje', 'Beat actualizado correctamente.');
        return redirect()->to('/productor/panel');
    }

    public function esconder($id)
    {
        $session = session();
        $beat = $this->beatModel->find($id);
        
        if (!$beat || $beat['id_productor'] != $session->get('id')) {
            session()->setFlashdata('error', 'No tienes permiso para ocultar este beat.');
            return redirect()->to('/productor/panel');
        }

        $this->beatModel->update($id, ['estado' => 'oculto']);
        session()->setFlashdata('mensaje', 'Beat ocultado.');
        return redirect()->to('/productor/panel');
    }

    public function publicar($id)
    {
        $session = session();
        $beat = $this->beatModel->find($id);
        
        if (!$beat || $beat['id_productor'] != $session->get('id')) {
            session()->setFlashdata('error', 'No tienes permiso para publicar este beat.');
            return redirect()->to('/productor/panel');
        }

        $this->beatModel->update($id, ['estado' => 'publico']);
        session()->setFlashdata('mensaje', 'Beat publicado nuevamente.');
        return redirect()->to('/productor/panel');
    }

    public function eliminar($id)
    {
        $session = session();
        $beat = $this->beatModel->find($id);
        
        if (!$beat || $beat['id_productor'] != $session->get('id')) {
            session()->setFlashdata('error', 'No tienes permiso para eliminar este beat.');
            return redirect()->to('/productor/panel');
        }

        $this->beatModel->update($id, ['estado' => 'eliminado']);
        session()->setFlashdata('mensaje', 'Beat eliminado.');
        return redirect()->to('/productor/panel');
    }
}
