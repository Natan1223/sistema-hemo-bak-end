<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\ProfessionalOccupationDAO;
use App\Models\PostgreSQL\ProfessionalOccupationModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ProfessionalOccupationController
{

    // public function registerProfessionalOccupation(Request $request, Response $response, array $args): Response
    // {
    //     $data = $request->getParsedBody();

    //     //reject empty strings
    //     if (empty($data['description']) || empty($data['initials']) || empty($data['active'])){
    //         $response = $response
    //         ->withStatus(406)
    //         ->withjson([
    //             "message" => [
    //                 'pt' => 'Erro ao cadastrar conselho.',
    //                 'en' => 'Error registering council.'
    //             ],
    //             'result' => null
    //         ]);
                
    //             return $response;
    //         }

    //     $councilDAO = new ProfessionalCouncilDAO();
    //     $council = new ProfessionalCouncilModel();

    //     if($data){
    //         $council
    //         ->setDescription ($data['description'])
    //         ->setInitials ($data['initials'])
    //         ->setActive ($data['active']);

    //         $idProfessionalCouncil = $councilDAO->registerProfessionalCouncil($council); 
            
    //         if($idProfessionalCouncil){
    //             $response = $response->withjson([
    //                 "message" => [
    //                     "pt" => "Conselho cadastrado com sucesso...",
    //                     "en" => "Council register was successful."
    //                 ],
    //                 'result' => null
    //             ]);
    //         }else {
    //             $response = $response
    //             ->withStatus(406)
    //             ->withjson([
    //                 "message" => [
    //                     "pt" => "Erro ao cadastrar cidade...",
    //                     "en" => "Error registering city."
    //                 ],
    //                 'result' => null
    //             ]);
    //         }
    //     }else{
    //         $response = $response
    //         ->withStatus(406)
    //         ->withjson([
    //             "message" => [
    //                 "pt" => "Parametros não aceitaveis...",
    //                 "en" => "Unacceptable parameters."
    //             ],
    //             'result' => null
    //         ]);
    //     }
    
    //     return $response;
    // }

    public function listByProfessional(Request $request, Response $response, array $args): Response
    {
        $professional = new ProfessionalOccupationDAO();

        $data = $professional->listByProfessional();

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

    public function listByOccupation(Request $request, Response $response, array $args): Response
    {
        $occupation = new ProfessionalOccupationDAO();

        $data = $occupation->listByOccupation();

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

    public function listByCompany(Request $request, Response $response, array $args): Response
    {
        $professional = new ProfessionalOccupationDAO();

        $data = $professional->listByCompany();

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

    // public function updateCouncilData(Request $request, Response $response, array $args): Response
    // {
    //     $data = $request->getParsedBody();
    //     $queryParams = $request->getQueryParams();
        
    //     //reject empty strings
    //     if ($data['description'] == ""){
    //         $response = $response
    //         ->withStatus(406)
    //         ->withjson([
    //             "message" => [
    //                 'pt' => 'Erro ao atualizar conselho.',
    //                 'en' => 'Error updating council.'
    //             ],
    //             'result' => null
    //         ]);
                
    //             return $response;
    //         }
                
    //     // $id = $args['id'];
    //     $id = (int) $queryParams['id'];
    //     $councilDAO = new ProfessionalCouncilDAO();
    //     $council = new ProfessionalCouncilModel();
    //     if($data){
    //         $council
    //         ->setDescription ($data['description'])
    //         ->setInitials ($data['initials'])
    //         ->setActive ($data['active']);
            
    //     $councilDAO->updateCouncilData($council, $id);

    //     if($councilDAO){
    //         $response = $response->withjson([
    //             "message" => [
    //                 'pt' => 'Conselho atualizado com sucesso.',
    //                 'en' => 'Council update was successful.'
    //             ],
    //             'result' => null
    //         ]);
    //     }else {
    //         $response = $response
    //         ->withStatus(406)
    //         ->withjson([
    //             "message" => [
    //                 'pt' => 'Erro ao atualizar cidade.',
    //                 'en' => 'Error updating city.'
    //             ],
    //             'result' => null
    //         ]);
    //     }
    // }else{
    //     $response = $response
    //     ->withStatus(406)
    //     ->withjson([
    //         "message" => [
    //             'pt' => 'Parâmetro não aceitáveis.',
    //             'en' => 'Unacceptable parameters.'
    //         ],
    //         'result' => null
    //     ]);
    // }

    // return $response;

    //     return $response;
    // }
}