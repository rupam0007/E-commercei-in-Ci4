<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table         = 'products';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['category_id', 'name', 'slug', 'description', 'price', 'stock', 'image', 'is_active'];
    protected $useTimestamps = true;

    public function getActiveProducts(int $categoryId = 0, int $perPage = 12): array
    {
        $builder = $this->where('is_active', 1);
        if ($categoryId > 0) {
            $builder = $builder->where('category_id', $categoryId);
        }
        return [
            'products' => $builder->paginate($perPage),
            'pager'    => $this->pager,
        ];
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)->where('is_active', 1)->first();
    }

    public function withCategory(): array
    {
        return $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->where('products.is_active', 1)
            ->findAll();
    }
}
