<?php

namespace App\Models;

use CodeIgniter\Model;

class MagicLinkModel extends Model
{
    protected $table      = 'magic_links';
    protected $primaryKey = 'id';
    
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    
    protected $allowedFields = ['email', 'token', 'expires_at', 'used_at', 'created_at'];
    
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    
    protected $validationRules = [
        'email' => 'required|valid_email',
        'token' => 'required|min_length[32]',
        'expires_at' => 'required',
    ];
    
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
    /**
     * Crear un nuevo magic link
     */
    public function createMagicLink(string $email): ?string
    {
        $token = bin2hex(random_bytes(32));
        
        $data = [
            'email'      => $email,
            'token'      => $token,
            'expires_at' => date('Y-m-d H:i:s', strtotime('+15 minutes')),
            'created_at' => date('Y-m-d H:i:s'),
        ];
        
        if ($this->insert($data)) {
            return $token;
        }
        
        return null;
    }
    
    /**
     * Verificar y marcar como usado un magic link
     */
    public function verifyToken(string $token): ?array
    {
        $link = $this->where('token', $token)
                     ->where('used_at', null)
                     ->where('expires_at >', date('Y-m-d H:i:s'))
                     ->first();
        
        if ($link) {
            // Marcar como usado
            $this->update($link['id'], ['used_at' => date('Y-m-d H:i:s')]);
            return $link;
        }
        
        return null;
    }
    
    /**
     * Limpiar tokens expirados (ejecutar periódicamente)
     */
    public function cleanExpiredTokens(): int
    {
        return $this->where('expires_at <', date('Y-m-d H:i:s'))
                    ->delete();
    }
}
