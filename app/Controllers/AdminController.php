<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\ProductModel;
use App\Models\UserModel;

class AdminController extends BaseController
{
    protected ProductModel       $productModel;
    protected CategoryModel      $categoryModel;
    protected OrderModel         $orderModel;
    protected OrderItemModel     $orderItemModel;
    protected UserModel          $userModel;

    public function __construct()
    {
        $this->productModel   = new ProductModel();
        $this->categoryModel  = new CategoryModel();
        $this->orderModel     = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->userModel      = new UserModel();
    }

    // ─── Dashboard ────────────────────────────────────────────────────────────────
    public function dashboard(): string
    {
        $stats = [
            'total_products'  => $this->productModel->countAll(),
            'total_orders'    => $this->orderModel->countAll(),
            'total_users'     => $this->userModel->countAll(),
            'pending_orders'  => $this->orderModel->where('status', 'pending')->countAllResults(),
            'recent_orders'   => $this->orderModel->getAllOrders(),
        ];

        return view('admin/dashboard', compact('stats'));
    }

    // ─── Products ─────────────────────────────────────────────────────────────────
    public function products(): string
    {
        $products   = $this->productModel
            ->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->findAll();
        $categories = $this->categoryModel->findAll();

        return view('admin/products/index', compact('products', 'categories'));
    }

    public function createProduct(): string
    {
        $categories = $this->categoryModel->findAll();
        return view('admin/products/form', compact('categories'));
    }

    public function storeProduct()
    {
        $rules = [
            'name'        => 'required|min_length[2]',
            'price'       => 'required|decimal',
            'stock'       => 'required|integer',
            'category_id' => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            $categories = $this->categoryModel->findAll();
            return view('admin/products/form', [
                'categories' => $categories,
                'errors'     => $this->validator->getErrors(),
            ]);
        }

        $name = $this->request->getPost('name');
        $slug = url_title($name, '-', true);

        // Handle image upload
        $image    = $this->request->getFile('image');
        $imageName = null;
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $imageName = $image->getRandomName();
            $image->move(FCPATH . 'uploads/products', $imageName);
        }

        $this->productModel->insert([
            'category_id' => $this->request->getPost('category_id'),
            'name'        => $name,
            'slug'        => $slug,
            'description' => $this->request->getPost('description'),
            'price'       => $this->request->getPost('price'),
            'stock'       => $this->request->getPost('stock'),
            'image'       => $imageName,
            'is_active'   => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        session()->setFlashdata('success', 'Product created.');
        return redirect()->to('/admin/products');
    }

    public function editProduct(int $id): string
    {
        $product    = $this->productModel->findOrFail($id);
        $categories = $this->categoryModel->findAll();

        return view('admin/products/form', compact('product', 'categories'));
    }

    public function updateProduct(int $id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $name  = $this->request->getPost('name');
        $slug  = url_title($name, '-', true);

        $image    = $this->request->getFile('image');
        $imageName = $product['image'];
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $imageName = $image->getRandomName();
            $image->move(FCPATH . 'uploads/products', $imageName);
        }

        $this->productModel->update($id, [
            'category_id' => $this->request->getPost('category_id'),
            'name'        => $name,
            'slug'        => $slug,
            'description' => $this->request->getPost('description'),
            'price'       => $this->request->getPost('price'),
            'stock'       => $this->request->getPost('stock'),
            'image'       => $imageName,
            'is_active'   => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        session()->setFlashdata('success', 'Product updated.');
        return redirect()->to('/admin/products');
    }

    public function deleteProduct(int $id)
    {
        $this->productModel->delete($id);
        session()->setFlashdata('success', 'Product deleted.');
        return redirect()->to('/admin/products');
    }

    // ─── Orders ───────────────────────────────────────────────────────────────────
    public function orders(): string
    {
        $orders = $this->orderModel->getAllOrders();
        return view('admin/orders/index', compact('orders'));
    }

    public function updateOrderStatus(int $id)
    {
        $status = $this->request->getPost('status');
        $allowed = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];

        if (in_array($status, $allowed)) {
            $this->orderModel->update($id, ['status' => $status]);
            session()->setFlashdata('success', 'Order status updated.');
        }

        return redirect()->to('/admin/orders');
    }

    // ─── Categories ───────────────────────────────────────────────────────────────
    public function categories(): string
    {
        $categories = $this->categoryModel->findAll();
        return view('admin/categories/index', compact('categories'));
    }

    public function storeCategory()
    {
        $name = $this->request->getPost('name');
        if ($name) {
            $this->categoryModel->insert([
                'name' => $name,
                'slug' => url_title($name, '-', true),
            ]);
            session()->setFlashdata('success', 'Category added.');
        }
        return redirect()->to('/admin/categories');
    }

    public function deleteCategory(int $id)
    {
        $this->categoryModel->delete($id);
        session()->setFlashdata('success', 'Category deleted.');
        return redirect()->to('/admin/categories');
    }

    // ─── Customers ─────────────────────────────────────────────────────────────────
    public function customers(): string
    {
        $db = \Config\Database::connect();
        $customers = $db->query(
            "SELECT u.id, u.name, u.email, u.created_at,
                    COUNT(o.id) AS order_count,
                    COALESCE(SUM(o.total_amount), 0) AS total_spent
             FROM users u
             LEFT JOIN orders o ON o.user_id = u.id
             WHERE u.role = 'customer'
             GROUP BY u.id
             ORDER BY u.created_at DESC"
        )->getResultArray();

        return view('admin/customers/index', compact('customers'));
    }

    // ─── Reports ───────────────────────────────────────────────────────────────────
    public function reports(): string
    {
        $db = \Config\Database::connect();

        $totalRevenue   = $this->orderModel->selectSum('total_amount')->first()['total_amount'] ?? 0;
        $totalOrders    = $this->orderModel->countAll();
        $totalProducts  = $this->productModel->countAll();
        $totalCustomers = $this->userModel->where('role', 'customer')->countAllResults();

        $monthlyRaw = $db->query(
            "SELECT DATE_FORMAT(created_at,'%Y-%m') as month, COUNT(*) as count, SUM(total_amount) as revenue
             FROM orders WHERE created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
             GROUP BY month ORDER BY month ASC"
        )->getResultArray();

        $topProducts = $db->query(
            "SELECT products.name, SUM(order_items.quantity) as total_sold
             FROM order_items JOIN products ON products.id = order_items.product_id
             GROUP BY products.id ORDER BY total_sold DESC LIMIT 5"
        )->getResultArray();

        $lowStock = $this->productModel->where('stock <=', 10)->orderBy('stock', 'ASC')->findAll();

        return view('admin/reports/index', compact('totalRevenue', 'totalOrders', 'totalProducts', 'totalCustomers', 'monthlyRaw', 'topProducts', 'lowStock'));
    }

}

