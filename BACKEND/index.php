<?php
use Slim\Factory\AppFactory;
use App\Models\ProductModel;

require __DIR__ . '/vendor/autoload.php';

// Configuration de la base de données
$pdo = new PDO('mysql:host=localhost;dbname=your_database', 'username', 'password');

// Création de l'app
$app = AppFactory::create();

// Injection de dépendance
$productModel = new ProductModel($pdo);

// Route pour obtenir les produits
$app->get('/products', function ($request, $response) use ($productModel) {
    $products = $productModel->getProducts();
    return $response->withJson($products);
});

$app->run();
