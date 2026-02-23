<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\ProductModel;

class OrderController extends BaseController
{
    protected CartModel      $cartModel;
    protected OrderModel     $orderModel;
    protected OrderItemModel $orderItemModel;
    protected ProductModel   $productModel;

    public function __construct()
    {
        $this->cartModel      = new CartModel();
        $this->orderModel     = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->productModel   = new ProductModel();
    }

    // ─── GET /checkout ───────────────────────────────────────────────────────────
    public function checkoutForm(): string
    {
        $userId = session()->get('user_id');
        $items  = $this->cartModel->getCartItems($userId);

        if (empty($items)) {
            session()->setFlashdata('error', 'Your cart is empty.');
            return redirect()->to('/cart')->send() ?: '';
        }

        $total = $this->cartModel->getCartTotal($userId);
        return view('orders/checkout', compact('items', 'total'));
    }

    // ─── POST /checkout ───────────────────────────────────────────────────────────
    public function checkout()
    {
        $userId = session()->get('user_id');
        $items  = $this->cartModel->getCartItems($userId);

        if (empty($items)) {
            session()->setFlashdata('error', 'Your cart is empty.');
            return redirect()->to('/cart');
        }

        $rules = [
            'shipping_name'    => 'required|min_length[2]',
            'shipping_address' => 'required|min_length[5]',
            'shipping_phone'   => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            $total = $this->cartModel->getCartTotal($userId);
            return view('orders/checkout', [
                'items'  => $items,
                'total'  => $total,
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $total = $this->cartModel->getCartTotal($userId);

        // ── Create order ─────────────────────────────────────────────────────────
        $orderId = $this->orderModel->insert([
            'user_id'          => $userId,
            'total_amount'     => $total,
            'status'           => 'pending',
            'shipping_name'    => $this->request->getPost('shipping_name'),
            'shipping_address' => $this->request->getPost('shipping_address'),
            'shipping_phone'   => $this->request->getPost('shipping_phone'),
            'notes'            => $this->request->getPost('notes'),
        ], true);

        // ── Save order items + reduce stock ───────────────────────────────────────
        foreach ($items as $item) {
            $this->orderItemModel->insert([
                'order_id'   => $orderId,
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
            ]);

            $product = $this->productModel->find($item['product_id']);
            $this->productModel->update($item['product_id'], [
                'stock' => max(0, $product['stock'] - $item['quantity']),
            ]);
        }

        // ── Clear cart ────────────────────────────────────────────────────────────
        $this->cartModel->clearCart($userId);

        session()->setFlashdata('success', 'Order placed successfully!');
        return redirect()->to('/orders/' . $orderId);
    }

    // ─── GET /orders ─────────────────────────────────────────────────────────────
    public function index(): string
    {
        $userId = session()->get('user_id');
        $orders = $this->orderModel->getUserOrders($userId);

        return view('orders/index', compact('orders'));
    }

    // ─── GET /orders/{id} ─────────────────────────────────────────────────────────
    public function show(int $id): string
    {
        $userId = session()->get('user_id');
        $order  = $this->orderModel->find($id);

        if (!$order || ($order['user_id'] != $userId && session()->get('user_role') !== 'admin')) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $items = $this->orderItemModel->getItemsForOrder($id);

        return view('orders/show', compact('order', 'items'));
    }
}
