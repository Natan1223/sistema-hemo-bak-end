<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\PatientDAO;
use App\Models\PostgreSQL\PatientModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class PatientController
{

    public function listPatient(Request $request, Response $response, array $args): Response
    {
        $queryParams = $request->getQueryParams();
        $nome = $queryParams['nome'];

        $patient = new PatientDAO();

        $data = $patient->listPatient($nome);

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