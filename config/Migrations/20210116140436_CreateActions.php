<?php
use Migrations\AbstractMigration;

class CreateActions extends AbstractMigration
{

    public function up()
    {

        $this->table('actions', ['id' => false, 'primary_key' => ['']])
            ->addColumn('id', 'biginteger', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('name_en', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('name', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('sort_no', 'biginteger', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->create();
    }

    public function down()
    {

        $this->dropTable('actions');
    }
}

