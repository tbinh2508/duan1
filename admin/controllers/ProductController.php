<?php
require_once 'function.php';
loadModel("Product");

$action = $_GET['action'] ?? 'index';
$productModel = new Product();

switch ($action) {
    case 'index':
        $products = $productModel->all();
        loadView("products/index", ["products" => $products]);
        break;

    case 'create':
        loadModel("Brand");
        loadModel("Category");
        $brands = (new Brand())->all();
        $categories = (new Category())->all();
        loadView("products/form", ["brands" => $brands, "categories" => $categories]);
        break;

    case 'store':
        $productModel->insert($_POST);
        header("Location: index.php?controller=product");
        break;

    case 'edit':
        $id = $_GET['id'];
        $product = $productModel->find($id);
        loadModel("Brand");
        loadModel("Category");
        $brands = (new Brand())->all();
        $categories = (new Category())->all();
        loadView("products/form", compact('product', 'brands', 'categories'));
        break;

    case 'update':
        $id = $_GET['id'];
        $productModel->update($id, $_POST);
        header("Location: index.php?controller=product");
        break;

    case 'delete':
        $id = $_GET['id'];
        $productModel->delete($id);
        header("Location: index.php?controller=product");
        break;
}

