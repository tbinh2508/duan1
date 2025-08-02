<?php
require_once "function.php";
loadModel("Product");

$productModel = new Product();

$action = $_GET["action"] ?? "index";

switch ($action) {
    case "index":
        $products = $productModel->all();
        loadView("products/index", ["products" => $products]);
        break;

    case "create":
        loadModel("Category");
        loadModel("Brand");
        $categories = (new Category())->all();
        $brands = (new Brand())->all();
        loadView("products/form", ["categories" => $categories, "brands" => $brands]);
        break;

    case "store":
        $productModel->insert($_POST);
        header("Location: index.php?controller=product");
        break;

    case "edit":
        $id = $_GET["id"];
        $product = $productModel->find($id);
        loadModel("Category");
        loadModel("Brand");
        $categories = (new Category())->all();
        $brands = (new Brand())->all();
        loadView("products/form", ["product" => $product, "categories" => $categories, "brands" => $brands]);
        break;

    case "update":
        $id = $_POST["id"];
        $productModel->update($id, $_POST);
        header("Location: index.php?controller=product");
        break;

    case "delete":
        $id = $_GET["id"];
        $productModel->delete($id);
        header("Location: index.php?controller=product");
        break;
}
