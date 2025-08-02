<?php
$controller = $_GET["controller"] ?? "product";
require_once "controllers/" . ucfirst($controller) . "Controller.php";
