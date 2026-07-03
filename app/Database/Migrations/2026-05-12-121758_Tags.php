<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Tags extends Migration
{
    public function up()
    {
	    $this->forge->addField([
		    'tag_id' => [
			    'type'           => 'INT',
			    'constraint'     => 5,
			    'unsigned'       => true,
			    'auto_increment' => true,
		    ],
		    'text' => [
			    'type' => 'text'
		    ],
			'full_name' =>[
				'type' => 'text'
			],
		    'parent_id' => [
			    'type'           => 'INT',
			    'constraint'     => 5,
			    'unsigned'       => true,
		    ],
		    'color' => [
			    'type'           => 'varchar',
			    'constraint'     => 11,
		        'default'        => "#eeeeee"
		    ],
		    'is_context' => [
			    'type'           => 'TINYINT',
			    'constraint'     => 1,
			    'unsigned'       => true,
		    ],
		    'created_at' => [
			    'type'    => 'TIMESTAMP',
			    'default' => new RawSql('CURRENT_TIMESTAMP'),
		    ],
		    'updated_at' => [
			    'type'    => 'TIMESTAMP',
			    'default' => new RawSql('CURRENT_TIMESTAMP'),
		    ],
		    'updated_at' => [
			    'type'    => 'TIMESTAMP'
		    ]
	    ]);
	    $this->forge->addKey('tag_id', true);
	    $this->forge->createTable('tags');
    }

    public function down()
    {
	    $this->forge->dropTable('tags');
    }
}
