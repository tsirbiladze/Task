<?php

use Phalcon\Db\Column;
use Phalcon\Db\Exception;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class EmailConfirmationsMigration_101
 */
class EmailConfirmationsMigration_101 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     * @throws Exception
     */
    public function morph(): void
    {
        $this->morphTable('email_confirmations', [
            'columns' => [
                new Column(
                    'id',
                    [
                        'type' => Column::TYPE_INTEGER,
                        'unsigned' => true,
                        'notNull' => true,
                        'autoIncrement' => true,
                        'size' => 10,
                        'first' => true
                    ]
                ),
                new Column(
                    'userID',
                    [
                        'type' => Column::TYPE_INTEGER,
                        'unsigned' => true,
                        'notNull' => true,
                        'size' => 10,
                        'after' => 'id'
                    ]
                ),
                new Column(
                    'code',
                    [
                        'type' => Column::TYPE_CHAR,
                        'notNull' => true,
                        'size' => 32,
                        'after' => 'userID'
                    ]
                ),
                new Column(
                    'createdAt',
                    [
                        'type' => Column::TYPE_DATETIME,
                        'default' => "current_timestamp()",
                        'notNull' => false,
                        'after' => 'code'
                    ]
                ),
                new Column(
                    'modifiedAt',
                    [
                        'type' => Column::TYPE_DATETIME,
                        'default' => "current_timestamp()",
                        'notNull' => false,
                        'after' => 'createdAt'
                    ]
                ),
                new Column(
                    'confirmed',
                    [
                        'type' => Column::TYPE_TINYINTEGER,
                        'unsigned' => true,
                        'notNull' => true,
                        'size' => 3,
                        'after' => 'modifiedAt'
                    ]
                ),
            ],
            'indexes' => [
                new Index('PRIMARY', ['id'], 'PRIMARY'),
                new Index('email_confirmations_fk', ['userID'], ''),
            ],
            'options' => [
                'TABLE_TYPE' => 'BASE TABLE',
                'AUTO_INCREMENT' => '1',
                'ENGINE' => 'InnoDB',
                'TABLE_COLLATION' => 'utf8mb4_general_ci',
            ],
        ]);
    }

    /**
     * Run the migrations
     *
     * @return void
     */
    public function up(): void
    {
    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down(): void
    {
    }
}
