<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\DiagnosisDAO;
use App\Models\PostgreSQL\DiagnosisModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class DiagnosisController
{

    public function listVWDiagnosis(Request $request, Response $response, array $args): Response
    {
        $queryParams = $request->getQueryParams();
        $descricao = strtoupper($queryParams['descricao']);

        $diagnosis = new DiagnosisDAO();

        $data = $diagnosis->listVWDiagnosis($descricao);

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