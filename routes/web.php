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


//exibindo todos os dados da tabela
$router->get('/usuarios','UsuarioController@mostrarTodosUsuarios');

//inserindo dados na tabela
$router->post('/usuario/cadastrar','UsuarioController@cadastrarUsuario');

//buscar somente 1 valor na tabela,usei o id para isso
$router->get('/usuario/{id}','UsuarioController@mostrarUmUsuario');

//atualizar dado na tabela
$router->put('/usuario/{id}/atualizar','UsuarioController@atualizarUsuario');

//deletar registro
$router->delete('/usuario/{id}/deletar','UsuarioController@deletarUsuario');

//login
$router->post('/usuario/login','UsuarioController@usuarioLogin');




