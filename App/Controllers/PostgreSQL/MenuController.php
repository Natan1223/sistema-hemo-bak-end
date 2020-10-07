<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\MenuDAO;
use App\Models\PostgreSQL\MenuModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class MenuController
{
    public function listMenus(Request $request, Response $response, array $args): Response
    {
        $Menu = new MenuDAO();

        $data = $Menu->listMenus();

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