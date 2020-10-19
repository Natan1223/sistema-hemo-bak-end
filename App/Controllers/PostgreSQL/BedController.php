<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\BedDAO;
use App\Models\PostgreSQL\BedModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class BedController
{
    public function listBedIdClinic(Request $request, Response $response, array $args): Response
    {
        $data = $request->getQueryParams();
        $idClinic = $data['idClinic'];
        $bed = new BedDAO();

        $data = $bed->listBedIdClinic($idClinic);

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