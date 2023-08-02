<?php

namespace PSA\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Numeric;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\Regex as RegexValidator;

class ProductsForm extends Form
{
    public function initialize($entity = null, $options = null)
    {
        $id = new Hidden('id');
        $this->add($id);

        // Add product name field
        $name = new Text('name');
        $name->addValidator(new PresenceOf(['message' => 'Name is required']));
        $this->add($name);

        // Add product weight field
        $weight = new Text('weight');
        $weight->addValidator(new PresenceOf(['message' => 'Weight is required']));
        // $weight->addValidator(new Numericality(['message' => 'Weight must be a numeric value', 'allowFloat' => true]));
        $this->add($weight);

        // Add product price field
        $price = new Text('price');
        $price->addValidator(new PresenceOf(['message' => 'Price is required']));
        // $price->addValidator(new Numericality(['message' => 'Price must be a numeric value', 'allowFloat' => true]));
        $this->add($price);

        // CSRF
        $csrf = new Hidden('csrf');
        $csrf->addValidator(new Identical([
            'value' => $this->security->getSessionToken(),
            'message' => 'CSRF validation failed'
        ]));
        $this->add($csrf);

        // Add submit button
        $this->add(new Submit('Save Product'));
    }

    public function getCsrf()
    {
        return $this->security->getToken();
    }
}
