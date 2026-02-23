<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table         = 'cart';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['user_id', 'product_id', 'quantity'];
    protected $useTimestamps = true;

    public function getCartItems(int $userId): array
    {
        return $this->select('cart.*, products.name, products.price, products.image, products.stock')
            ->join('products', 'products.id = cart.product_id')
            ->where('cart.user_id', $userId)
            ->findAll();
    }

    public function getCartTotal(int $userId): float
    {
        $items = $this->getCartItems($userId);
        return array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $items));
    }

    public function getCartCount(int $userId): int
    {
        return (int) $this->where('user_id', $userId)->countAllResults();
    }

    public function findItem(int $userId, int $productId): ?array
    {
        return $this->where('user_id', $userId)->where('product_id', $productId)->first();
    }

    public function clearCart(int $userId): void
    {
        $this->where('user_id', $userId)->delete();
    }
}
