<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\CityDAO;
use App\Models\PostgreSQL\CityModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class CityController
{

    public function registerCity(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        //reject empty strings
        if ($data['description'] == ""){
            $response = $response
                ->withStatus(406)
                ->withjson([
                    "message" => [
                        "pt" => "Erro ao cadastrar cidade...",
                        "en" => "Error registering city."
                    ],
                    'result' => null
                ]);

            return $response;
        }

        $cityDAO = new CityDAO();
        $city = new CityModel();

        if($data){
            $city
            ->setDescription ($data['description']);

            $idCity = $cityDAO->registerCity($city); 
            
            if($idCity){
                $response = $response->withjson([
                    "message" => [
                        "pt" => "Cidade cadastrada com sucesso...",
                        "en" => "City register was successful."
                    ],
                    'result' => null
                ]);
            }else {
                $response = $response
                ->withStatus(406)
                ->withjson([
                    "message" => [
                        "pt" => "Erro ao cadastrar cidade...",
                        "en" => "Error registering city."
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

    public function listCities(Request $request, Response $response, array $args): Response
    {
        $city = new CityDAO();

        $data = $city->listCities();

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

    public function updateCityData(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $queryParams = $request->getQueryParams();
        
        //reject empty strings
        if ($data['description'] == ""){
            $response = $response
            ->withStatus(406)
            ->withjson([
                "message" => [
                    'pt' => 'Erro ao atualizar cidade.',
                    'en' => 'Error updating city.'
                ],
                'result' => null
            ]);
                
                return $response;
            }
                
        // $id = $args['id'];
        $id = (int) $queryParams['id'];
        $cityDAO = new CityDAO();
        $city = new CityModel();
        if($data){
            $city
            ->setDescription ($data['description']);
            
        $cityDAO->updateCityData($city, $id);

        if($cityDAO){
            $response = $response->withjson([
                "message" => [
                    'pt' => 'Cidade atualizada com sucesso.',
                    'en' => 'City update was successful.'
                ],
                'result' => null
            ]);
        }else {
            $response = $response
            ->withStatus(406)
            ->withjson([
                "message" => [
                    'pt' => 'Erro ao atualizar cidade.',
                    'en' => 'Error updating city.'
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