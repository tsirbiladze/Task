<?php
declare(strict_types=1);

namespace PSA\Models;

use Phalcon\Mvc\Model;

class Products extends Model
{
    public $id;
    public $name;
    public $weight;
    public $price;
    public $created_at;
    public $updated_at;

    public function initialize()
    {
        $this->setSource("products");
    }
}
