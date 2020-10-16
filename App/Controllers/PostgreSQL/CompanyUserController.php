<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\CompanyUserDAO;
use App\Models\PostgreSQL\CompanyUserModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class CompanyUserController
{
    public function listCompanyUser(Request $request, Response $response, array $args): Response
    {
        
        $companyUserDAO = new CompanyUserDAO();

        $data = $companyUserDAO->listCompanyUser();

        $result = [
            'message' => [
                'pt' => null,
                'en' => null
            ],
            'result' => $data
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
        ->setIdProfile($queryParams["idPerfil"])
        ->setActive($data["ativo"]);

        $idCompanyUser = $companyUserDAO->updateCompanyUser($companyUser);

        if($idCompanyUser){
            $result = [
                'message' => [
                    'pt' => 'Atualizado com sucesso.',
                    'en' => 'Updated registered.'
                ],
                'result' => null
            ]; 
            $response = $response->withjson($result)->withStatus(200);
        }else {
            $result = [
                'message' => [
                    'pt' => 'Erro ao atualizar.',
                    'en' => 'update registering.'
                ],
                'result' => null
            ]; 
            $response = $response->withjson($result)->withStatus(500);
        }
            
        return $response;
    }
}