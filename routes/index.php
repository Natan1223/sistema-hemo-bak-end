<?php

use function src\slimConfiguration;

use App\Controllers\PostgreSQL\AuthenticateController;
use App\Controllers\PostgreSQL\CityController;
use App\Controllers\PostgreSQL\PersonController;
use App\Controllers\PostgreSQL\UserController;
use App\Controllers\PostgreSQL\ProfessionalCouncilController;
use App\Controllers\PostgreSQL\ProfessionalController;
use App\Controllers\PostgreSQL\OccupationController;
use App\Controllers\PostgreSQL\CompanyController;
use App\Controllers\PostgreSQL\CompanyUserController;
use App\Controllers\PostgreSQL\ProfessionalOccupationController;
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

$app->post('/login', AuthenticateController::class . ':login');

$app->get('/blood-version', function ($request, $response, $args) {
    return $response
        ->withStatus(200)
        ->withjson([
            'descricao' => 'Projeto HEMO - Sistema de gerenciamento de transfusçao sanguínea',
            'versao-api' => '01.000.00'
        ]);
});

$app->group('',function() use ($app){

    $app->get('/person', PersonController::class . ':listPersons');
    $app->post('/person', PersonController::class . ':registerPerson');
    $app->put('/person', PersonController::class . ':updatePersonData');

    $app->get('/user', UserController::class . ':listUsers');
    $app->post('/user', UserController::class . ':registerUser');

    $app->get('/user-email/[{id}]', UserController::class . ':queryUserRest');

    $app->get('/cities', CityController::class . ':listCities');
    $app->post('/city', CityController::class . ':registerCity');
    $app->put('/city', CityController::class . ':updateDataCity');

    $app->post('/professional-council', ProfessionalCouncilController::class . ':registerProfessionalCouncil');
    $app->get('/professional-councils', ProfessionalCouncilController::class . ':listCouncils');
    $app->put('/professional-council', ProfessionalCouncilController::class . ':updateCouncilData');

    $app->post('/professional', ProfessionalController::class . ':registerProfessional');
    $app->get('/professionals', ProfessionalController::class . ':listProfessionals');
    $app->get('/professionals-company', ProfessionalController::class . ':listProfessionalsByCompany');
    $app->put('/professional', ProfessionalController::class . ':updateProfessionalData');

    $app->get('/occupations', OccupationController::class . ':listOccupations');
    $app->get('/occupation-name', OccupationController::class . ':getOccupationByName');
    $app->get('/occupation-cbo', OccupationController::class . ':getOccupationByCbo');
    $app->get('/occupation-id', OccupationController::class . ':getOccupationById');

    $app->post('/company', CompanyController::class . ':registerCompany');
    $app->get('/companies', CompanyController::class . ':listCompanies');
    $app->put('/company', CompanyController::class . ':updateCompanyData');
    
    $app->get('/companies-users', CompanyUserController::class . ':listCompanyUser');
    $app->post('/companies-users', CompanyUserController::class . ':registerCompanyUser');
    //$app->put('/companies-users[{idUsuario,idEmpresa,idPerfil}]', CompanyUserController::class . ':updateCompanyUser');

    $app->get('/professional-occupation/professional', ProfessionalOccupationController::class . ':listByProfessional');
    $app->get('/professional-occupation/occupation', ProfessionalOccupationController::class . ':listByOccupation');
    $app->get('/professional-occupation/company', ProfessionalOccupationController::class . ':listByCompany');

    $app->get('/verifica-autenticacao', function ($request, $response, $args) {
        return $response
                    ->withStatus(200);
    });
    
})
->add(
    function($request, $response, $next){
        $token = $request->getAttribute("jwt");
        $expireDate = date_format(new \DateTime($token['dateExpire']), 'Y-m-d H:i:s');
        $now = new \DateTime();
        $now = date_format($now, 'Y-m-d H:i:s');
        if($expireDate < $now)
            return $response->withJson([
                                "message" => 'Token expirou. Favor faça login'
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
        "relaxed" => ["localhost", "90.0.3.231"],
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