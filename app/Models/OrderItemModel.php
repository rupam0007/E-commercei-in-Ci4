<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table         = 'order_items';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['order_id', 'product_id', 'quantity', 'price'];
    protected $useTimestamps = true;

    public function getItemsForOrder(int $orderId): array
    {
        return $this->select('order_items.*, products.name, products.image')
            ->join('products', 'products.id = order_items.product_id')
            ->where('order_items.order_id', $orderId)
            ->findAll();
    }
}
