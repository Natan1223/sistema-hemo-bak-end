<?php

use function src\slimConfiguration;

use App\Controllers\PostgreSQL\NomeExemploClassController;
use App\Controllers\PostgreSQL\PessoaController;

$app = new \Slim\App(slimConfiguration());

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Credentials', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Token, X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

$app->get('/apresentacao-hemo', function ($request, $response, $args) {
    return $response
        ->withStatus(200)
        ->withjson([
            'descricao' => 'Projeto HEMO - Sistema de gerenciamento de transfusçao sanguínea',
            'versao-api' => '01.000.00'
        ]);
});

$app->group('',function() use ($app){

    #lista todas as pessoas cadastradas
    $app->get('/pessoa', PessoaController::class . ':listarPessoas');
    #cadastra uma pessoa
    $app->post('/pessoa', PessoaController::class . ':cadastrarPessoa');
    #atualizar dados de uma pessoa
    $app->put('/pessoa', PessoaController::class . ':atualizarDadosPessoa');

    $app->get('/nome-rota-exemplo/[{id}]', NomeExemploClassController::class . ':nomeMetodoDaClass');
    $app->post('/nome-rota-exemplo', NomeExemploClassController::class . ':nomeMetodoDaClass');
    $app->put('/nome-rota-exemplo', NomeExemploClassController::class . ':nomeMetodoDaClass');

    $app->get('/verifica-autenticacao', function ($request, $response, $args) {
        return $response
                    ->withStatus(200);
    });
    
});

$app->run();