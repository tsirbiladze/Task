<?php
declare(strict_types=1);

namespace PSA\Controllers;

use PSA\Models\Products;
use Phalcon\Http\Response;
use Phalcon\Tag;
use PSA\Forms\ProductsForm;
use PSA\Controllers\ControllerBase;


/**
 * ProductsController
 * CRUD to manage products
 */
class ProductsController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateBefore('private');
        $this->tag->setTitle('Products');
    }

    public function indexAction()
    {
        // css and javascript
        $datatable = new \PSA\Helpers\Datatables;
        $this->view->css = $datatable->css();
        $js = $datatable->jsData();
        $js .= "<script type='text/javascript' language='javascript'>
        function deleteProduct(id) {
            $.post('/products/delete/' + id, function(data){
                $('#modal-delete').html(data);
            })
        }
        </script>";
        $this->view->js = $js;
        
        $this->view->breadcrumbs = "
        <li class='breadcrumb-item'><a href='/dashboard'><i class='fas fa-fw fa-tachometer-alt'></i> Dashboard</a></li>
        <li class='breadcrumb-item active'><i class='fas fa-box'></i> Products</li>
        ";
        $products = Products::find();
        $this->view->products = $products;
    }


    public function deleteAction($id)
    {
        if ($this->request->getPost('delete')) {
            $product = Products::findFirstById($id);
            if (!$product) {
                $this->flashSession->error("Product was not found");
                return $this->response->redirect('/products');
            }
            
            if (!$this->security->checkToken($this->security->getTokenKey(), $this->request->getPost('csrf'))) {
                $this->flashSession->error('CSRF validation failed');
                return $this->response->redirect('/products');
            }

            if (!$product->delete()) {
                if ($product->getMessages()) {
                    foreach ($product->getMessages() as $message) {
                        $this->flashSession->error((string) $message);
                    }
                } else {
                    $this->flashSession->error("An error has occurred");
                }
            } else {
                $this->flashSession->success("Product was deleted");
            }
            return $this->response->redirect('/products');
        }

        $this->view->disable();
        $resData = "Oops! Something went wrong. Please try again later.";

        $response = new \Phalcon\Http\Response();
        $response->setStatusCode(400, "Bad Request");

        if ($this->request->isPost() && $this->request->isAjax()) {
            $form = new \PSA\Forms\ProductsForm();
            $resData = '<form method="post" action="/products/delete/' . $id . '">';
            $resData .= '<div class="modal-body">';
            $resData .= '<label>Are you sure you want to delete the product?!</label>';
            $resData .= '</div>';
            $resData .= '<div class="modal-footer">';
            $resData .= \Phalcon\Tag::submitButton(['name' => 'delete', 'class' => 'btn btn btn-danger btn-sm', 'value' => 'Delete']);
            $resData .= $form->render('id');
            $resData .= $form->render('csrf', ['value' => $form->getCsrf()]);
            $resData .= '</div>';
            $resData .= '</form>';
            $response->setStatusCode(200);
        }

        $response->setJsonContent($resData);
        $response->send();
        exit;
    }


    public function createAction()
    {
        $form = new \PSA\Forms\ProductsForm();

        if ($this->request->isPost()) {
            if ($form->isValid($this->request->getPost()) == false) {
                foreach ($form->getMessages() as $message) {
                    $this->flashSession->error((string)$message);
                }
                return $this->response->redirect('/products/create');
            } else {
                $product = new Products([
                    'name' => $this->request->getPost('name', 'striptags'),
                    'weight' => $this->request->getPost('weight'),
                    'price' => $this->request->getPost('price'),
                    'created_at' => (new \DateTime())->format('Y-m-d H:i:s'),
                    'updated_at' => (new \DateTime())->format('Y-m-d H:i:s'),
                ]);
                

                if (!$product->save()) {
                    foreach ($product->getMessages() as $message) {
                        $this->flashSession->error((string)$message);
                    }
                    return $this->response->redirect('/products/create');
                }

                $this->flashSession->success("Product was created successfully");
                return $this->response->redirect('/products');
            }
        }

        $this->view->breadcrumbs = "
        <li class='breadcrumb-item'><a href='/dashboard'><i class='fas fa-fw fa-tachometer-alt'></i> Dashboard</a></li>
        <li class='breadcrumb-item'><a href='/products'><i class='fas fa-box'></i> Products</a></li>
        <li class='breadcrumb-item active'><i class='fas fa-plus-circle'></i> Create</li>
        ";
        $this->view->form = $form;
    }

    public function editAction($id)
    {
        $product = Products::findFirstById($id);

        if (!$product) {
            $this->flash->error("Product was not found.");
            return $this->dispatcher->forward([
                'action' => 'index'
            ]);
        }

        $form = new \PSA\Forms\ProductsForm($product, ['edit' => 1]);

        if ($this->request->isPost()) {
            if ($form->isValid($this->request->getPost()) == false) {
                foreach ($form->getMessages() as $message) {
                    $this->flashSession->error((string)$message);
                }
            } else {
                $product->name = $this->request->getPost('name', 'striptags');
                $product->weight = $this->request->getPost('weight');
                $product->price = $this->request->getPost('price');
                $product->updated_at = (new \DateTime())->format('Y-m-d H:i:s');

                if (!$product->save()) {
                    foreach ($product->getMessages() as $message) {
                        $this->flashSession->error((string)$message);
                    }
                } else {
                    $this->flashSession->success("Product was updated successfully.");
                }
            }
        }

        $this->view->breadcrumbs = "
        <li class='breadcrumb-item'><a href='/dashboard'><i class='fas fa-fw fa-tachometer-alt'></i> Dashboard</a></li>
        <li class='breadcrumb-item'><a href='/products'><i class='fas fa-box'></i> Products</a></li>
        <li class='breadcrumb-item active'><i class='fas fa-edit'></i> Edit</li>
        ";

        $this->view->product = $product;
        $this->view->form = $form;
    }

}
