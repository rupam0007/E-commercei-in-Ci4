<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table         = 'orders';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['user_id', 'total_amount', 'status', 'shipping_name', 'shipping_address', 'shipping_phone', 'notes'];
    protected $useTimestamps = true;

    public function getUserOrders(int $userId): array
    {
        return $this->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll();
    }

    public function getAllOrders(): array
    {
        return $this->select('orders.*, users.name as customer_name, users.email as customer_email')
            ->join('users', 'users.id = orders.user_id')
            ->orderBy('orders.created_at', 'DESC')
            ->findAll();
    }
}
