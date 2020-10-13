<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\AttendanceDAO;
use App\Models\PostgreSQL\AttendanceModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AttendanceController
{
    public function listTypeAttendance(Request $request, Response $response, array $args): Response
    {
        $attendance = new AttendanceDAO();

        $data = $attendance->listTypeAttendance();

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

    
}