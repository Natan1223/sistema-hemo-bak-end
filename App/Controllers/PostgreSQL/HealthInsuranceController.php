<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\HealthInsuranceDAO;
use App\Models\PostgreSQL\HealthInsuranceModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class HealthInsuranceController
{

    public function listHealthInsuranceCompany(Request $request, Response $response, array $args): Response
    {
        $healthInsurance = new HealthInsuranceDAO();

        $data = $healthInsurance->listHealthInsuranceCompany();

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

}