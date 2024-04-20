<?php
use Slim\Factory\AppFactory;
use App\Auth\Auth;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

$app->post('/login', function ($request, $response) {
    $params = (array)$request->getParsedBody();
    $username = $params['username'];
    $password = $params['password'];

    if ($user = Auth::authenticateUser($username, $password)) {
        $token = Auth::createToken($user);
        return $response->withJson(['token' => $token]);
    } else {
        return $response->withStatus(401)->withJson(['error' => 'Invalid credentials']);
    }
});

$app->run();
