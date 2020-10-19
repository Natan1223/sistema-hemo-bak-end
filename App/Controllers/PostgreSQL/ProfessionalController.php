<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\ProfessionalDAO;
use App\DAO\PostgreSQL\PersonDAO;
use App\DAO\PostgreSQL\ProfessionalCouncilDAO;

use App\DAO\PostgreSQL\OccupationDAO;
use App\Models\PostgreSQL\ProfessionalModel;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ProfessionalController
{

    public function registerProfessional(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        //reject empty strings
        if (empty($data['councilNumber']) || empty($data['registry']) || empty($data['active'])){
            $response = $response
            ->withStatus(406)
            ->withjson([
                "message" => [
                    'pt' => 'Erro ao cadastrar profissional.',
                    'en' => 'Error registering professional.'
                ],
                'result' => null
            ]);
                
                return $response;
            }

        $professionalDAO = new ProfessionalDAO();
        $professional = new ProfessionalModel();

        if($data){
            $professional
            ->setIdPerson((int)$data['idPerson'])
            ->setIdProfessionalCouncil((int)$data['idProfessionalCouncil'])
            ->setCouncilNumber($data['councilNumber'])
            ->setRegistry($data['registry'])
            ->setActive ($data['active']);

            $idProfessional = $professionalDAO->registerProfessional($professional); 
            
            if($idProfessional){
                $response = $response->withjson([
                    "message" => [
                        "pt" => "Profissional cadastrado com sucesso...",
                        "en" => "Professional register was successful."
                    ],
                    'result' => null
                ]);
            }else {
                $response = $response
                ->withStatus(406)
                ->withjson([
                    "message" => [
                        "pt" => "Erro ao cadastrar profissional...",
                        "en" => "Error registering professional."
                    ],
                    'result' => null
                ]);
            }
        }else{
            $response = $response
            ->withStatus(406)
            ->withjson([
                "message" => [
                    "pt" => "Parametros não aceitaveis...",
                    "en" => "Unacceptable parameters."
                ],
                'result' => null
            ]);
        }
    
        return $response;
    }

    public function listProfessionals(Request $request, Response $response, array $args): Response
    {
        $professional = new ProfessionalDAO();
        $person = new PersonDAO();
        $council = new ProfessionalCouncilDAO();

        $data = $professional->listProfessionals();

        foreach($data as &$dataProfessional){
            $_person = $person->getPersonById($dataProfessional['idpessoa']);
            $_council = $council->getCouncilById($dataProfessional['idconselho_profissional']);
            
            $dataProfessional['pessoa'] = $_person;
            $dataProfessional['conselho_profissional'] = $_council;
        }


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

    public function updateProfessionalData(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        //reject empty strings
        if (empty($data['councilNumber']) || empty($data['registry']) || empty($data['active'])){
            $response = $response
            ->withStatus(406)
            ->withjson([
                "message" => [
                    'pt' => 'Erro ao cadastrar profissional.',
                    'en' => 'Error registering professional.'
                ],
                'result' => null
            ]);
                
                return $response;
            }

        $professionalDAO = new ProfessionalDAO();
        $professional = new ProfessionalModel();
        if($data){
            $professional
            ->setIdPerson((int)$data['idPerson'])
            ->setIdProfessionalCouncil((int)$data['idProfessionalCouncil'])
            ->setCouncilNumber($data['councilNumber'])
            ->setRegistry($data['registry'])
            ->setActive ($data['active']);
            
        $professionalDAO->updateProfessionalData($professional);

        if($professionalDAO){
            $response = $response->withjson([
                "message" => [
                    'pt' => 'Profissional atualizado com sucesso.',
                    'en' => 'Professional update was successful.'
                ],
                'result' => null
            ]);
        }else {
            $response = $response
            ->withStatus(406)
            ->withjson([
                "message" => [
                    'pt' => 'Erro ao atualizar dados.',
                    'en' => 'Error updating data.'
                ],
                'result' => null
            ]);
        }
    }else{
        $response = $response
        ->withStatus(406)
        ->withjson([
            "message" => [
                'pt' => 'Parâmetro não aceitáveis.',
                'en' => 'Unacceptable parameters.'
            ],
            'result' => null
        ]);
    }

    return $response;

        return $response;
    }
}