<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Diaries extends Migration
{
    public function up()
    {
	    $this->forge->addField([
		    'diary_id' => [
			    'type'           => 'INT',
			    'constraint'     => 5,
			    'unsigned'       => true,
			    'auto_increment' => true,
		    ],
		    'text' => [
			    'type'       => 'text'
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
	    $this->forge->addKey('diary_id', true);
	    $this->forge->createTable('diaries');
    }

    public function down()
    {
	    $this->forge->dropTable('diaries');
    }
}
