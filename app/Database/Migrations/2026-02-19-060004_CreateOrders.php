<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrders extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'total_amount'     => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'status'           => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'processing', 'shipped', 'delivered', 'cancelled'],
                'default'    => 'pending',
            ],
            'shipping_name'    => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'shipping_address' => ['type' => 'TEXT', 'null' => true],
            'shipping_phone'   => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'notes'            => ['type' => 'TEXT', 'null' => true],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('orders');
    }

    public function down()
    {
        $this->forge->dropTable('orders');
    }
}
