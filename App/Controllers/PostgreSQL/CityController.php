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

        $cityDAO = new CityDAO();
        $city = new CityModel();

        if($data){
            $city
            ->setDescription((string)$data['description']);

            $idCity = $cityDAO->registerCity($city); 
            
            if($idCity){
                $response = $response->withjson([
                    "message" => [
                        "pt" => "Cidade cadastrada com sucesso...",
                        "en" => "City register was successful."
                    ]
                ]);
            }else {
                $response = $response
                ->withStatus(406)
                ->withjson([
                    "message" => [
                        "pt" => "Erro ao cadastrar cidade...",
                        "en" => "Error registering city."
                    ]
                ]);
            }
        }else{
            $response = $response
            ->withStatus(406)
            ->withjson([
                "message" => [
                    "pt" => "Parametros não aceitaveis...",
                    "en" => "Unacceptable parameters."
                ]
            ]);
        }
    
        return $response;
    }

    public function listCities(Request $request, Response $response, array $args): Response
    {
        $city = new CityDAO();

        $result = $city->listCities();

        $response = $response
            ->withjson($result);

        return $response;
    }

    public function updateDataCity(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $cityDAO = new CityDAO();
        $city = new CityModel();
        if($data){
            $city
            ->setIdCity ($data['idCity'])
            ->setDescricao ($data['description']);
            
        $cityDAO->updateDataCity($city);

        if($cityDAO){
            $response = $response->withjson([
                "message" => [
                    'pt' => 'Cidade atualizada com sucesso.',
                    'en' => 'City update was successful.'
                ]
            ]);
        }else {
            $response = $response
            ->withStatus(406)
            ->withjson([
                "message" => [
                    'pt' => 'Erro ao atualizar cidade.',
                    'en' => 'Error updating city.'
                ]
            ]);
        }
    }else{
        $response = $response
        ->withStatus(406)
        ->withjson([
            "message" => [
                'pt' => 'Parâmetro não aceitáveis.',
                'en' => 'Unacceptable parameters.'
            ]
        ]);
    }

    return $response;

        return $response;
    }
}