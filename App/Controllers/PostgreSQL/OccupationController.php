<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\OccupationDAO;
use App\Models\PostgreSQL\OccupationModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class OccupationController
{
 
    public function listOccupations(Request $request, Response $response, array $args): Response
    {
        $occupation = new OccupationDAO();

        $data = $occupation->listOccupations();

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

    public function getOccupationByName(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $occupation = new OccupationDAO();

        $name = $data['name'];

        $data = $occupation->getOccupationByName($name);

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

    public function getOccupationByCbo(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $cbo = $data['cbo'];

        $occupation = new OccupationDAO();

        $data = $occupation->getOccupationByCbo($cbo);

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

    public function getOccupationById(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $id = $data['idOccupation'];

        $occupation = new OccupationDAO();

        $data = $occupation->getOccupationById($id);

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