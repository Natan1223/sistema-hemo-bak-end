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
    
    public function updateMenu(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $menuDAO = new MenuDAO();
        $menu = new MenuModel();

        // -------- Validate information -------- //
        // Menu data
        if(strlen($data['descricao']) <= 1 ){
            $result = [
                'message' => [
                    'pt' => 'Atributo \'descrição\' do menu é invalido.',
                    'en' => 'Menu \'description\' attribute is invalid.'
                ],
                'result' => null
            ];
            $response = $response->withjson($result);
            $response->withStatus(406);
            return $response;
        }
        if(strlen($data['ativo']) != 1){
            $result = [
                'message' => [
                    'pt' => 'Atributo \'ativo\' do menu é invalido.',
                    'en' => 'Menu \'active\' attribute is invalid.'
                ],
                'result' => null
            ];
            $response = $response->withjson($result);
            $response->withStatus(406);
            return $response;
        }

        // -------- Validated information -------- //
        $menu
        ->setIdMenu ($data['idMenu'])
        ->setDescription ($data['descricao'])
        ->setActive ($data['ativo'])
        ->setPath ($data['path'])
        ->setIdMenuTitle ($data['idMenuTitulo']);

        $idMenu = $menuDAO->updateMenu($menu);
        
        if($idMenu){
            $result = [
                'message' => [
                    'pt' => 'Menu atualizado com sucesso.',
                    'en' => 'Menu updated registered.'
                ],
                'result' => null
            ]; 
            $response = $response->withjson($result)->withStatus(200);
        }else {
            $result = [
                'message' => [
                    'pt' => 'Erro ao atualizar menu.',
                    'en' => 'Error update menu.'
                ],
                'result' => null
            ]; 
            $response = $response->withjson($result)->withStatus(500);
        }
        
        return $response;
    }
}