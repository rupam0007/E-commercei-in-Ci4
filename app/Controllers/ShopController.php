<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;

class ShopController extends BaseController
{
    protected ProductModel  $productModel;
    protected CategoryModel $categoryModel;

    public function __construct()
    {
        $this->productModel  = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    // ─── GET / ───────────────────────────────────────────────────────────────────
    public function home(): string
    {
        $featured   = $this->productModel->where('is_active', 1)->orderBy('id', 'DESC')->limit(8)->findAll();
        $categories = $this->categoryModel->findAll();

        return view('shop/home', [
            'featured'   => $featured,
            'categories' => $categories,
        ]);
    }

    // ─── GET /shop ────────────────────────────────────────────────────────────────
    public function index(): string
    {
        $categoryId = (int) $this->request->getGet('category');
        $search     = $this->request->getGet('q');
        $categories = $this->categoryModel->findAll();

        $builder = $this->productModel->where('is_active', 1);

        if ($categoryId > 0) {
            $builder = $builder->where('category_id', $categoryId);
        }
        if ($search) {
            $builder = $builder->like('name', $search);
        }

        $products = $builder->paginate(12);
        $pager    = $this->productModel->pager;

        return view('shop/index', compact('products', 'pager', 'categories', 'categoryId', 'search'));
    }

    // ─── GET /shop/{slug} ─────────────────────────────────────────────────────────
    public function show(string $slug): string
    {
        $product = $this->productModel
            ->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->where('products.slug', $slug)
            ->where('products.is_active', 1)
            ->first();

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $related = $this->productModel
            ->where('category_id', $product['category_id'])
            ->where('id !=', $product['id'])
            ->where('is_active', 1)
            ->limit(4)
            ->findAll();

        return view('shop/product', compact('product', 'related'));
    }
}
