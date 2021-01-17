<?php
use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{
    public function up()
    {

        $this->table('admin_phrases')
            ->addColumn('background_id', 'biginteger', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('chapter_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('no', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('character_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('object_usage', 'biginteger', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('speaker_name', 'string', [
                'default' => null,
                'limit' => 256,
                'null' => true,
            ])
            ->addColumn('speaker_color', 'string', [
                'default' => null,
                'limit' => 256,
                'null' => true,
            ])
            ->addColumn('sentence_color', 'string', [
                'default' => null,
                'limit' => 256,
                'null' => true,
            ])
            ->addColumn('sentence', 'string', [
                'default' => null,
                'limit' => 1000,
                'null' => true,
            ])
            ->addColumn('sentence_translate', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('sentence_kana', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('html', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('css', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('js', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('backgrounds', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('name', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('body_color', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('html', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('css', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('is_sum', 'tinyinteger', [
                'default' => '0',
                'limit' => 4,
                'null' => false,
            ])
            ->addIndex(
                [
                    'id',
                ]
            )
            ->create();

        $this->table('chapters')
            ->addColumn('content_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('no', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 256,
                'null' => false,
            ])
            ->create();

        $this->table('character_parts', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('character_id', 'biginteger', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('type', 'tinyinteger', [
                'default' => null,
                'limit' => 4,
                'null' => true,
            ])
            ->addColumn('parts_category_no', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('parts_no', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('parts_css', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('characters')
            ->addColumn('content_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('organization_id', 'biginteger', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('rank_id', 'biginteger', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 256,
                'null' => false,
            ])
            ->addColumn('name_color', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('foreign_color', 'string', [
                'default' => null,
                'limit' => 256,
                'null' => false,
            ])
            ->addColumn('picture', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('dir', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('type', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('size', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('html', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('css', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('html_speak', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('css_speak', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('css_body', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('contents')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 200,
                'null' => false,
            ])
            ->addColumn('prefix', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('thumbnail_html', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('thumbnail_css', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('thumbnail_background_color', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('copy', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('summary', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('icons', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('name', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('background_color', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('html', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('css', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('items')
            ->addColumn('order_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('item_name', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('item_price', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('logos', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('name', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('background_color', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('html', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('css', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('object_parts', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('object_id', 'biginteger', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('parts_category_no', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('parts_no', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('parts_css', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('object_templates', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('name', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('class_name', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('width', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('height', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->create();

        $this->table('objects', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('template_id', 'biginteger', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('content_id', 'biginteger', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('character_id', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('object_usage', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 256,
                'null' => true,
            ])
            ->addColumn('html', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('css', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('orders')
            ->addColumn('order_date', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('organizations')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 200,
                'null' => false,
            ])
            ->create();

        $this->table('part_categories', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('object_type', 'smallinteger', [
                'default' => null,
                'limit' => 6,
                'null' => true,
            ])
            ->addColumn('template_id', 'smallinteger', [
                'default' => null,
                'limit' => 6,
                'null' => true,
            ])
            ->addColumn('name', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('class_name', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('sort_no', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('z_index', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->create();

        $this->table('parts')
            ->addColumn('object_type', 'tinyinteger', [
                'default' => null,
                'limit' => 4,
                'null' => true,
            ])
            ->addColumn('template_id', 'tinyinteger', [
                'default' => null,
                'limit' => 4,
                'null' => true,
            ])
            ->addColumn('html', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('css', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('parts_category_no', 'integer', [
                'default' => null,
                'limit' => 4,
                'null' => true,
            ])
            ->addColumn('parts_no', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->create();

        $this->table('phrases')
            ->addColumn('background_id', 'biginteger', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('chapter_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('no', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('character_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('object_usage', 'biginteger', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('speaker_name', 'string', [
                'default' => null,
                'limit' => 256,
                'null' => true,
            ])
            ->addColumn('speaker_color', 'string', [
                'default' => null,
                'limit' => 256,
                'null' => true,
            ])
            ->addColumn('sentence_color', 'string', [
                'default' => null,
                'limit' => 256,
                'null' => true,
            ])
            ->addColumn('sentence', 'string', [
                'default' => null,
                'limit' => 1000,
                'null' => true,
            ])
            ->addColumn('sentence_translate', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('sentence_kana', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('html', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('css', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('js', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('ranks', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('organization_id', 'biginteger', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('badge_right_id', 'biginteger', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('badge_left_id', 'biginteger', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('name', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('sort_no', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->create();

        $this->table('tests', ['id' => false, 'primary_key' => ['']])
            ->addColumn('value', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->create();

        $this->table('words')
            ->addColumn('name', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('meaning', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('type', 'tinyinteger', [
                'default' => null,
                'limit' => 4,
                'null' => false,
            ])
            ->create();
    }

    public function down()
    {
        $this->dropTable('admin_phrases');
        $this->dropTable('backgrounds');
        $this->dropTable('chapters');
        $this->dropTable('character_parts');
        $this->dropTable('characters');
        $this->dropTable('contents');
        $this->dropTable('icons');
        $this->dropTable('items');
        $this->dropTable('logos');
        $this->dropTable('object_parts');
        $this->dropTable('object_templates');
        $this->dropTable('objects');
        $this->dropTable('orders');
        $this->dropTable('organizations');
        $this->dropTable('part_categories');
        $this->dropTable('parts');
        $this->dropTable('phrases');
        $this->dropTable('ranks');
        $this->dropTable('tests');
        $this->dropTable('words');
    }
}
