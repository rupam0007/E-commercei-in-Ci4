<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // ── Admin User ────────────────────────────────────────────────────────────
        $existing = $this->db->table('users')->where('email', 'admin@shopci.com')->get()->getFirstRow();
        if (!$existing) {
            $this->db->table('users')->insert([
                'name'       => 'Admin',
                'email'      => 'admin@shopci.com',
                'password'   => password_hash('admin123', PASSWORD_BCRYPT),
                'role'       => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        // ── Sample Categories ─────────────────────────────────────────────────────
        $categories = [
            ['name' => 'Electronics',   'slug' => 'electronics'],
            ['name' => 'Clothing',       'slug' => 'clothing'],
            ['name' => 'Books',          'slug' => 'books'],
            ['name' => 'Home & Living',  'slug' => 'home-living'],
        ];

        foreach ($categories as $cat) {
            $exists = $this->db->table('categories')->where('slug', $cat['slug'])->get()->getFirstRow();
            if (!$exists) {
                $this->db->table('categories')->insert(array_merge($cat, [
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]));
            }
        }

        // ── Sample Products ────────────────────────────────────────────────────────
        $electronicsId = $this->db->table('categories')->where('slug', 'electronics')->get()->getFirstRow('array')['id'] ?? 1;
        $clothingId    = $this->db->table('categories')->where('slug', 'clothing')->get()->getFirstRow('array')['id'] ?? 2;
        $booksId       = $this->db->table('categories')->where('slug', 'books')->get()->getFirstRow('array')['id'] ?? 3;

        $products = [
            ['category_id' => $electronicsId, 'name' => 'Wireless Headphones',  'slug' => 'wireless-headphones',  'price' => 79.99,  'stock' => 50, 'description' => 'Premium sound quality with active noise cancellation.'],
            ['category_id' => $electronicsId, 'name' => 'Mechanical Keyboard',  'slug' => 'mechanical-keyboard',  'price' => 129.99, 'stock' => 30, 'description' => 'Tactile switches, RGB backlight, compact tenkeyless layout.'],
            ['category_id' => $electronicsId, 'name' => 'USB-C Hub 7-in-1',     'slug' => 'usb-c-hub-7-in-1',     'price' => 34.99,  'stock' => 80, 'description' => 'Expand your laptop ports with 4K HDMI, USB 3.0, SD card reader.'],
            ['category_id' => $clothingId,    'name' => 'Classic White T-Shirt', 'slug' => 'classic-white-tshirt', 'price' => 19.99,  'stock' => 120, 'description' => '100% organic cotton, unisex fit, pre-shrunk.'],
            ['category_id' => $clothingId,    'name' => 'Slim Fit Jeans',        'slug' => 'slim-fit-jeans',       'price' => 49.99,  'stock' => 60, 'description' => 'Stretch denim, available in multiple washes.'],
            ['category_id' => $booksId,       'name' => 'Clean Code',            'slug' => 'clean-code',            'price' => 35.00,  'stock' => 25, 'description' => 'A bestselling guide to writing better software.'],
            ['category_id' => $booksId,       'name' => 'The Pragmatic Programmer', 'slug' => 'pragmatic-programmer', 'price' => 42.00, 'stock' => 20, 'description' => 'From journeyman to master — your career companion.'],
        ];

        foreach ($products as $product) {
            $exists = $this->db->table('products')->where('slug', $product['slug'])->get()->getFirstRow();
            if (!$exists) {
                $this->db->table('products')->insert(array_merge($product, [
                    'is_active'  => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]));
            }
        }

        echo "  Admin seeder completed.\n";
        echo "  Admin credentials: admin@shopci.com / admin123\n";
    }
}
