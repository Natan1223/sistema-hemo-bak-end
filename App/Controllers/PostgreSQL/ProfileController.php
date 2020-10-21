<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\ProfileDAO;
use App\DAO\PostgreSQL\MenuDAO;
use App\Models\PostgreSQL\ProfileModel;
use App\Models\PostgreSQL\MenuModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ProfileController
{
    public function registerProfile(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $profileDAO = new ProfileDAO();
        $menuDAO = new MenuDAO();

        $profile = new ProfileModel();
        $menu = new MenuModel();

        // -------- Validate information -------- //
        // Profile data
        if(strlen($data['descricao']) <= 1 ){
            $result = [
                'message' => [
                    'pt' => 'Atributo \'descrição\' do perfil é invalido.',
                    'en' => 'Profile \'description\' attribute is invalid.'
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
                    'pt' => 'Atributo \'ativo\' do perfil é invalido.',
                    'en' => 'Profile \'active\' attribute is invalid.'
                ],
                'result' => null
            ];
            $response = $response->withjson($result);
            $response->withStatus(406);
            return $response;
        }

        // -------- Validate information -------- //
        // Menu data
        if(strlen($data['menu']['descricao']) <= 1 ){
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
        if(strlen($data['menu']['ativo']) != 1){
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
        $profile
        ->setDescription ($data['descricao'])
        ->setActive ($data['ativo']);
        $menu
        ->setDescription ($data['menu']['descricao'])
        ->setActive ($data['menu']['ativo'])
        ->setPath ($data['menu']['path']);
  
        $exist = $profileDAO->checkIfProfileExists($profile); 

        if(!$exist){
            $idProfile = $profileDAO->registerProfile($profile);
            // Add profile id for create menu
            $menu->setIdProfile (intval($idProfile));
            $idMenu = $menuDAO->registerMenu($menu);
            
        }else{
            $result = [
                'message' => [
                    'pt' => 'Existe um perfil com a mesma descrição.',
                    'en' => 'There is a profile with the same description.'
                ],
                'result' => null
            ];
            $response = $response->withjson($result);
            $response->withStatus(500);
            return $response;
        }
        
        if($idProfile){
            $result = [
                'message' => [
                    'pt' => 'Perfil cadastrado com sucesso.',
                    'en' => 'Profile successfully registered.'
                ],
                'result' => null
            ]; 
            $response = $response->withjson($result)->withStatus(200);
        }else {
            $result = [
                'message' => [
                    'pt' => 'Erro ao cadastrar perfil.',
                    'en' => 'Error registering profile.'
                ],
                'result' => null
            ]; 
            $response = $response->withjson($result)->withStatus(500);
        }
        
        return $response;
    }

    public function updateProfile(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $profileDAO = new ProfileDAO();
        $profile = new ProfileModel();

        // -------- Validate information -------- //
        // Profile data
        if(strlen($data['descricao']) <= 1 ){
            $result = [
                'message' => [
                    'pt' => 'Atributo \'descrição\' do perfil é invalido.',
                    'en' => 'Profile \'description\' attribute is invalid.'
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
                    'pt' => 'Atributo \'ativo\' do perfil é invalido.',
                    'en' => 'Profile \'active\' attribute is invalid.'
                ],
                'result' => null
            ];
            $response = $response->withjson($result);
            $response->withStatus(406);
            return $response;
        }

        // -------- Validated information -------- //
        $profile
        ->setDescription ($data['descricao'])
        ->setActive ($data['ativo'])
        ->setIdProfile ($data['idPerfil']);
        
        $idProfile = $profileDAO->updateProfile($profile);

        if($idProfile){
            $result = [
                'message' => [
                    'pt' => 'Perfil atualizado com sucesso.',
                    'en' => 'Profile updated registered.'
                ],
                'result' => null
            ]; 
            $response = $response->withjson($result)->withStatus(200);
        }else {
            $result = [
                'message' => [
                    'pt' => 'Erro ao atualizar perfil.',
                    'en' => 'Error update profile.'
                ],
                'result' => null
            ]; 
            $response = $response->withjson($result)->withStatus(500);
        }
        
        return $response;
    }

    public function listProfilesUser(Request $request, Response $response, array $args): Response
    {
        $data = $request->getQueryParams();
        $idEmpresa = $data['idEmpresa'];

        $profileDAO = new ProfileDAO();
        $menuDAO = new MenuDAO();

        $profilesUser = $profileDAO->listProfilesUser($idEmpresa);
        
        foreach($profilesUser as $dataTitulo){

            $perfilMenu = $menuDAO->getMenuByIdProfile($dataTitulo['idperfil']);
            
            foreach($perfilMenu as $dataPerfil){

                
                $dataMenu = $menuDAO->listMenuPath($dataPerfil['idmenu']);

                foreach($dataMenu as $dataDescricaoMenu){
                
                    $dataPerfil['menu'][] = $dataDescricaoMenu;
                    
                }
                $dataTituloMenu[] = $dataPerfil;
                $dataTitulo['menuTitulo']= $dataTituloMenu;
               
            }
            $perfilTitulo['perfil'][]= $dataTitulo;
            
        }
        
        $resultado[]= $perfilTitulo;
        
        $result = [
            'message' => [
                'pt' => null,
                'en' => null
            ],
            'result' => $resultado
        ];

        $response = $response
            ->withjson($result);
            
        return $response;
    }
}