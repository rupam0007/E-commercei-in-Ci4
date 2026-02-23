<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table          = 'users';
    protected $primaryKey     = 'id';
    protected $allowedFields  = ['name', 'email', 'password', 'role', 'phone', 'address'];
    protected $useTimestamps  = true;
    protected $hiddenFields   = ['password'];

    protected $beforeInsert   = ['hashPassword'];
    protected $beforeUpdate   = ['hashPassword'];

    protected function hashPassword(array $data): array
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_BCRYPT);
        }
        return $data;
    }

    public function findByEmail(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }
}