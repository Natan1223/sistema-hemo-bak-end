<?php

use function src\slimConfiguration;

use App\Controllers\PostgreSQL\AttendanceController;
use App\Controllers\PostgreSQL\AuthenticateController;
use App\Controllers\PostgreSQL\CityController;
use App\Controllers\PostgreSQL\HealthInsuranceController;
use App\Controllers\PostgreSQL\PersonController;
use App\Controllers\PostgreSQL\UserController;
use App\Controllers\PostgreSQL\ProfileController;
use App\Controllers\PostgreSQL\MenuController;
use App\Controllers\PostgreSQL\PatientController;
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
    
    $app->get('/profile', ProfileController::class . ':listProfiles');
    $app->post('/profile', ProfileController::class . ':registerProfile');
    $app->put('/profile', ProfileController::class . ':updateProfile');

    $app->get('/menu', MenuController::class . ':listMenus');

    $app->get('/usercompanyprofile', UserCompanyProfileController::class . ':listUserCompanyProfile');

    $app->get('/type-attendance', AttendanceController::class . ':listTypeAttendance');

    $app->get('/patient/[{nome}]', PatientController::class . ':listPatient');

    $app->get('/health-insurance-company', HealthInsuranceController::class . ':listHealthInsuranceCompany');

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