<?php

use function src\slimConfiguration;

use App\Controllers\PostgreSQL\PessoaController;
use App\Controllers\PostgreSQL\AutenticaController;
use App\Controllers\PostgreSQL\UsuarioController;
use App\Controllers\PostgreSQL\CidadeController;
use Tuupola\Middleware\JwtAuthentication;

$app = new \Slim\App(slimConfiguration());

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Credentials', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Token, X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

$app->post('/login', AutenticaController::class . ':login');

$app->get('/usuario-senha/[{id}]', UsuarioController::class . ':consultaUsuarioRest');

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

    $app->get('/usuarios', UsuarioController::class . ':listarUsuarios');
    $app->post('/usuario', UsuarioController::class . ':cadastrarUsuario');

    $app->put('/usuario-senha', UsuarioController::class . ':atualizarSenha');
    $app->get('/usuario-email/[{id}]', UsuarioController::class . ':consultaUsuarioRest');

    $app->get('/cidades', CidadeController::class . ':listarCidades');
    $app->post('/cidade', CidadeController::class . ':cadastrarCidade');
    $app->put('/cidade', CidadeController::class . ':atualizarDadosCidade');

    $app->get('/nome-rota-exemplo/[{id}]', NomeExemploClassController::class . ':nomeMetodoDaClass');
    $app->post('/nome-rota-exemplo', NomeExemploClassController::class . ':nomeMetodoDaClass');
    $app->put('/nome-rota-exemplo', NomeExemploClassController::class . ':nomeMetodoDaClass');

    $app->get('/verifica-autenticacao', function ($request, $response, $args) {
        return $response
                    ->withStatus(200);
    });
    
})
->add(
    function($request, $response, $next){
        $token = $request->getAttribute("jwt");
        $expireDate = date_format(new \DateTime($token['data_expira']), 'Y-m-d H:i:s');
        $now = new \DateTime();
        $now = date_format($now, 'Y-m-d H:i:s');
        if($expireDate < $now)
            return $response->withJson([
                                "menssage" => 'Token expirou. Favor faça login'
                            ])
                            ->withStatus(401);
        $response = $next($request, $response);
        return $response;
    }
)
->add(
    new JwtAuthentication([
        "secure" => false,
        "secret" => getenv('JWT_SECRET_KEY'),
        "attribute" => "jwt",
        "relaxed" => ["localhost", "www.nsbhospedagemweb.com"],
        "error" => function ($response, $arguments) {
            $data["status"] = "error";
            $data["message"] = $arguments["message"];
            return $response
                ->withHeader("Content-Type", "application/json")
                ->getBody()->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }
    ])
);

$app->run();