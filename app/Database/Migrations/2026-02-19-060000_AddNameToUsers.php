<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNameToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'id',
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'name',
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'phone',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['name', 'phone', 'address']);
    }
}
