<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\CompanyUserDAO;
use App\DAO\PostgreSQL\UserDAO;
use App\DAO\PostgreSQL\PersonDAO;
use App\DAO\PostgreSQL\ProfileDAO;
use App\DAO\PostgreSQL\CompanyDAO;

use App\Models\PostgreSQL\CompanyUserModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class CompanyUserController
{
    public function listCompanyUserByStatus(Request $request, Response $response, array $args): Response
    {
        $queryParams = $request->getQueryParams();
        $status = $queryParams["status"];

        $companyUserDAO = new CompanyUserDAO();
        $userDAO = new UserDAO();
        $personDAO = new PersonDAO();
        $profileDAO = new ProfileDAO();
        $companyDAO = new CompanyDAO();

        $companyUser = new CompanyUserModel();

        if($status != 'T' && $status != 'F'){
            $result = [
                'message' => [
                    'pt' => 'Status deve ter valor \'T\' ou \'F\'.',
                    'en' => 'Status must have a value of \'T\' or \'F\'.'
                ],
                'result' => null
            ];
            $response = $response->withjson($result);
            $response->withStatus(406);
            return $response;
        }
        
        $companiesUsers = $companyUserDAO->listCompanyUserByStatus($status);

        for ($i = 0; $i < count($companiesUsers); $i++) {
            $companiesUsers[$i]['usuario'] = $userDAO->getUserByIdUser($companiesUsers[$i]['idusuario']);
            $companiesUsers[$i]['pessoa' ] = $personDAO->getPersonByIdUser($companiesUsers[$i]['idusuario']);
            $companiesUsers[$i]['empresa'] = $companyDAO->getCompanyByIdCompany($companiesUsers[$i]['idempresa']);
            $companiesUsers[$i]['perfil' ] = $profileDAO->getProfileByIdProfile($companiesUsers[$i]['idperfil']);
        }

        $result = [
            'message' => [
                'pt' => null,
                'en' => null
            ],
            'result' => $companiesUsers
        ];

        $response = $response
            ->withjson($result);
            
        return $response;
    }

    public function registerCompanyUser(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $companyUserDAO = new CompanyUserDAO();
        $companyUser = new CompanyUserModel();

        // -------- Validate information -------- //
        if(
            !is_int($data['idUsuario']) || 
            !is_int($data['idEmpresa']) || 
            !is_int($data['idPerfil'])
        ){
            $result = [
                'message' => [
                    'pt' => '\'idUsuario\', \'idEmpresa\' e \'idPerfil\' precisam ser do tipo inteiro',
                    'en' => '\'idUser\', \'idCompany\' and \'idProfile\' must be of the entire type'
                ],
                'result' => null
            ];
            $response = $response->withjson($result);
            $response->withStatus(406);
            return $response;
        }
        if(strlen($data['ativo']) != 1){
            $result = [
                'message' => [
                    'pt' => 'Atributo \'ativo\'  é invalido.',
                    'en' => '\'Active\' attribute is invalid.'
                ],
                'result' => null
            ];
            $response = $response->withjson($result);
            $response->withStatus(406);
            return $response;
        }

        $companyUser
        ->setIdUser($data["idUsuario"])
        ->setIdCompany($data["idEmpresa"])
        ->setIdProfile($data["idPerfil"])
        ->setActive($data["ativo"]);

        $exists = $companyUserDAO->checkIfCompanyUserExists($companyUser);

        if(!$exists){
            $idCompanyUser = $companyUserDAO->registerCompanyUser($companyUser);
        }else{
            $result = [
                'message' => [
                    'pt' => 'Existe um \'idUsuario\', \'idEmpresa\' e \'idPerfil\' com a mesma descrição.',
                    'en' => 'There is a \'idUser\', \'idCompany\' and \'idProfile\' with the same description.'
                ],
                'result' => null
            ];
            $response = $response->withjson($result);
            $response->withStatus(500);
            return $response;
        }

        if($idCompanyUser){
            $result = [
                'message' => [
                    'pt' => 'Cadastrado com sucesso.',
                    'en' => 'Successfully registered.'
                ],
                'result' => null
            ]; 
            $response = $response->withjson($result)->withStatus(200);
        }else {
            $result = [
                'message' => [
                    'pt' => 'Erro ao cadastrar.',
                    'en' => 'Error registering.'
                ],
                'result' => null
            ]; 
            $response = $response->withjson($result)->withStatus(500);
        }
            
        return $response;
    }

    public function updateCompanyUser(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $queryParams = $request->getQueryParams();
        
        $companyUserDAO = new CompanyUserDAO();
        $companyUser = new CompanyUserModel();

        if(strlen($data['ativo']) != 1){
            $result = [
                'message' => [
                    'pt' => 'Atributo \'ativo\'  é invalido.',
                    'en' => '\'Active\' attribute is invalid.'
                ],
                'result' => null
            ];
            $response = $response->withjson($result);
            $response->withStatus(406);
            return $response;
        }
        $companyUser
        ->setIdUser($queryParams["idUsuario"])
        ->setIdCompany($queryParams["idEmpresa"])
        ->setActive($data["ativo"]);

        $profiles = $data["perfil"];
        //check if all profiles exist for this user in this company
        for ($i = 0; $i < count($profiles); $i++) {
            $companyUser->setIdProfile($profiles[$i]['idPerfil']);
            $exists = $companyUserDAO->checkIfCompanyUserExists($companyUser);
            //if not, then it will be possible to update the information
            if(!$exists){
                $result = [
                    'message' => [
                        'pt' => 'É possivel que o perfil '.$profiles[$i]['idPerfil'].' ainda não esteja pre-registrado para este usuario nesta empresa',
                        'en' => 'It is possible that the '.$profiles[$i]['idPerfil'].' profile is not yet pre-registered for this user in this company'
                    ],
                    'result' => null
                ];
                $response = $response->withjson($result);
                $response->withStatus(406);
                return $response;
            }
        }
        //if the algorithm is here, then it means that the user has all the profiles sent by the request
        for ($i = 0; $i < count($profiles); $i++) {
            $companyUser->setIdProfile($profiles[$i]['idPerfil']);
            $idCompanyUser = $companyUserDAO->updateCompanyUser($companyUser);
            //checks if the CompanyUser has been updated
            if(!$idCompanyUser){
                $result = [
                    'message' => [
                        'pt' => 'Erro ao atualizar.',
                        'en' => 'update registering.'
                    ],
                    'result' => null
                ]; 
                $response = $response->withjson($result)->withStatus(500);
            }
        }
        //if the algorithm is here, then everything has been updated successfully
        $result = [
            'message' => [
                'pt' => 'Atualizado com sucesso.',
                'en' => 'Updated registered.'
            ],
            'result' => null
        ]; 
        $response = $response->withjson($result)->withStatus(200);
            
        return $response;
    }
}