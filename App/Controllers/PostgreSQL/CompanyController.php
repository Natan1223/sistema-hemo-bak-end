<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\CompanyDAO;
use App\Models\PostgreSQL\CompanyModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class CompanyController
{

    public function registerCompany(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        //reject empty strings
        if (empty($data['name']) || empty($data['telephone']) || empty($data['active'])){
            $response = $response
            ->withStatus(406)
            ->withjson([
                "message" => [
                    'pt' => 'Erro ao cadastrar empresa.',
                    'en' => 'Error registering company.'
                ],
                'result' => null
            ]);
                
                return $response;
            }

        $companyDAO = new CompanyDAO();
        $company = new CompanyModel();

        if($data){
            $company
            ->setName ($data['name'])
            ->setTelephone ($data['telephone'])
            ->setActive ($data['active']);

            $idCompany = $companyDAO->registerCompany($company); 
            
            if($idCompany){
                $response = $response->withjson([
                    "message" => [
                        "pt" => "Empresa cadastrada com sucesso...",
                        "en" => "Company register was successful."
                    ],
                    'result' => null
                ]);
            }else {
                $response = $response
                ->withStatus(406)
                ->withjson([
                    "message" => [
                        "pt" => "Erro ao cadastrar empresa...",
                        "en" => "Error registering company."
                    ],
                    'result' => null
                ]);
            }
        }else{
            $response = $response
            ->withStatus(406)
            ->withjson([
                "message" => [
                    "pt" => "Parametros não aceitaveis...",
                    "en" => "Unacceptable parameters."
                ],
                'result' => null
            ]);
        }
    
        return $response;
    }

    public function listCompanies(Request $request, Response $response, array $args): Response
    {
        $company = new CompanyDAO();

        $data = $company->listCompanies();

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

    public function updateCompanyData(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        
        //reject empty strings
        if (empty($data['name']) || empty($data['telephone']) || empty($data['active'])){
            $response = $response
            ->withStatus(406)
            ->withjson([
                "message" => [
                    'pt' => 'Erro ao atualizar empresa.',
                    'en' => 'Error updating company.'
                ],
                'result' => null
            ]);
                
                return $response;
            }
                
        $id = $data['idCompany'];
        $companyDAO = new CompanyDAO();
        $company = new CompanyModel();
        if($data){
            $company
            ->setIdCompany ($data['idCompany'])
            ->setName ($data['name'])
            ->setTelephone ($data['telephone'])
            ->setActive ($data['active']);
            
        $companyDAO->updateCompanyData($company, $id);

        if($companyDAO){
            $response = $response->withjson([
                "message" => [
                    'pt' => 'Empresa atualizada com sucesso.',
                    'en' => 'Company update was successful.'
                ],
                'result' => null
            ]);
        }else {
            $response = $response
            ->withStatus(406)
            ->withjson([
                "message" => [
                    'pt' => 'Erro ao atualizar empresa.',
                    'en' => 'Error updating company.'
                ],
                'result' => null
            ]);
        }
    }else{
        $response = $response
        ->withStatus(406)
        ->withjson([
            "message" => [
                'pt' => 'Parâmetro não aceitáveis.',
                'en' => 'Unacceptable parameters.'
            ],
            'result' => null
        ]);
    }

    return $response;

        return $response;
    }
}