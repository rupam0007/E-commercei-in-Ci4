<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\ProductModel;

class CartController extends BaseController
{
    protected CartModel    $cartModel;
    protected ProductModel $productModel;

    public function __construct()
    {
        $this->cartModel    = new CartModel();
        $this->productModel = new ProductModel();
    }

    // ─── GET /cart ───────────────────────────────────────────────────────────────
    public function index(): string
    {
        $userId = session()->get('user_id');
        $items  = $this->cartModel->getCartItems($userId);
        $total  = $this->cartModel->getCartTotal($userId);

        return view('cart/index', compact('items', 'total'));
    }

    // ─── POST /cart/add ───────────────────────────────────────────────────────────
    public function add()
    {
        $userId    = session()->get('user_id');
        $productId = (int) $this->request->getPost('product_id');
        $quantity  = max(1, (int) ($this->request->getPost('quantity') ?? 1));

        $product = $this->productModel->find($productId);

        if (!$product || $product['stock'] < 1) {
            session()->setFlashdata('error', 'Product not available.');
            return redirect()->back();
        }

        $existing = $this->cartModel->findItem($userId, $productId);

        if ($existing) {
            $newQty = $existing['quantity'] + $quantity;
            if ($newQty > $product['stock']) {
                $newQty = $product['stock'];
            }
            $this->cartModel->update($existing['id'], ['quantity' => $newQty]);
        } else {
            $this->cartModel->insert([
                'user_id'    => $userId,
                'product_id' => $productId,
                'quantity'   => min($quantity, $product['stock']),
            ]);
        }

        session()->setFlashdata('success', 'Product added to cart!');
        return redirect()->back();
    }

    // ─── POST /cart/update ────────────────────────────────────────────────────────
    public function update()
    {
        $userId   = session()->get('user_id');
        $cartId   = (int) $this->request->getPost('cart_id');
        $quantity = max(1, (int) $this->request->getPost('quantity'));

        $item = $this->cartModel->find($cartId);

        if ($item && $item['user_id'] == $userId) {
            $product = $this->productModel->find($item['product_id']);
            $qty     = min($quantity, $product['stock']);
            $this->cartModel->update($cartId, ['quantity' => $qty]);
        }

        return redirect()->to('/cart');
    }

    // ─── GET /cart/remove/{id} ────────────────────────────────────────────────────
    public function remove(int $id)
    {
        $userId = session()->get('user_id');
        $item   = $this->cartModel->find($id);

        if ($item && $item['user_id'] == $userId) {
            $this->cartModel->delete($id);
        }

        session()->setFlashdata('success', 'Item removed.');
        return redirect()->to('/cart');
    }
}
