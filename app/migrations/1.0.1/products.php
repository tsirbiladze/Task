<?php

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Migrations\Mvc\Model\Migration;

class ProductsMigration_101 extends Migration
{
    public function morph()
    {
        $this->morphTable('products', [
                'columns' => [
                    new Column(
                        'id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'autoIncrement' => true,
                            'primary' => true,
                        ]
                    ),
                    new Column(
                        'name',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'size' => 255,
                            'notNull' => true,
                        ]
                    ),
                    new Column(
                        'weight',
                        [
                            'type' => Column::TYPE_DECIMAL,
                            'size' => 10,
                            'scale' => 2,
                            'notNull' => true,
                        ]
                    ),
                    new Column(
                        'price',
                        [
                            'type' => Column::TYPE_DECIMAL,
                            'size' => 10,
                            'scale' => 2,
                            'notNull' => true,
                        ]
                    ),
                    new Column(
                        'created_at',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'notNull' => true,
                        ]
                    ),
                    new Column(
                        'updated_at',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'notNull' => true,
                        ]
                    ),
                ],
            ]
        );
    }

    public function up()
    {
    }

    public function down()
    {
    }
}
