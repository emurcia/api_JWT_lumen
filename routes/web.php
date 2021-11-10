<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});




// rutas
$router->group(['prefix' => 'api'], function () use ($router) {

    // ruta para registrarse y loguearse sin protección
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');

    // middleware para proteger las rutas
    $router->group(['middleware' => 'auth:api'], function () use ($router) {
        // rutas protegidas y que deben accederse unicamente con token
        $router->get('/post', 'PostController@index');
        $router->post('/post', 'PostController@store');
        $router->put('products/{id}', 'PostController@update');
        $router->delete('/post', 'PostController@destroy');
        $router->post('logout', 'AuthController@logout');
        $router->post('refresh', 'AuthController@refresh');
        $router->get('products/{id}', 'PostController@show');
    });
});