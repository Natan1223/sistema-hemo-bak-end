<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\ClinicDAO;
use App\Models\PostgreSQL\ClinicModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ClinicController
{
    public function listClinic(Request $request, Response $response, array $args): Response
    {
        $clinic = new ClinicDAO();

        $data = $clinic->listClinic();

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