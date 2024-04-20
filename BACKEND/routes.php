<?php
use Slim\App;

return function (App $app) {
    $app->get('/api/hello/{name}', function ($request, $response, array $args) {
        $name = $args['name'];
        $response->getBody()->write("Hello, $name");
        return $response;
    });
};

$app->post('/login', function ($request, $response, array $args) {
    $params = (array)$request->getParsedBody();
    $username = $params['username'];
    $password = $params['password'];
    
    // Ici, vous intégreriez la logique pour vérifier les identifiants
    $user = authenticateUser($username, $password);
    if ($user) {
        $token = createToken($user); // Fonction fictive pour créer un JWT
        $response = $response->withJson(['token' => $token]);
    } else {
        $response = $response->withStatus(401)->withJson(['error' => 'Invalid credentials']);
    }

    return $response;
});

$app->post('/register', function ($request, $response) {
    $params = $request->getParsedBody();
    $user = createUser($params);
    if ($user) {
        return $response->withJson(['message' => 'User created successfully', 'user' => $user]);
    } else {
        return $response->withStatus(400)->withJson(['error' => 'Failed to create user']);
    }
});


$app->put('/account/{id}', function ($request, $response, array $args) {
    $userId = $args['id'];
    $params = $request->getParsedBody();
    $user = updateUser($userId, $params);
    if ($user) {
        return $response->withJson(['message' => 'User updated successfully', 'user' => $user]);
    } else {
        return $response->withStatus(400)->withJson(['error' => 'Failed to update user']);
    }
});


$app->get('/products', function ($request, $response, array $args) {
    $products = getProductsFromDatabase(); 
    return $response->withJson($products);
});
