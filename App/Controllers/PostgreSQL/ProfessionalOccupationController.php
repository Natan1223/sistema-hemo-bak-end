<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\ProfessionalOccupationDAO;
use App\Models\PostgreSQL\ProfessionalOccupationModel;

use App\DAO\PostgreSQL\ProfessionalDAO;
use App\DAO\PostgreSQL\OccupationDAO;
use App\DAO\PostgreSQL\CompanyDAO;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ProfessionalOccupationController
{

    public function registerProfessionalOccupation(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $professionalOccupationDAO = new ProfessionalOccupationDAO();
        $professionalOccupation = new ProfessionalOccupationModel();

        if($data){
            $professionalOccupation
            ->setIdProfessional ($data['idProfessional'])
            ->setIdOccupation ($data['idOccupation'])
            ->setIdCompany ($data['idCompany']);

            $professionalOccupation = $professionalOccupationDAO->registerProfessionalOccupation($professionalOccupation); 
            
            if($professionalOccupation){
                $response = $response->withjson([
                    "message" => [
                        "pt" => "Sucesso no cadastro",
                        "en" => "Registering success"
                    ],
                    'result' => null
                ]);
            }else {
                $response = $response
                ->withStatus(406)
                ->withjson([
                    "message" => [
                        "pt" => "Erro no cadastro",
                        "en" => "Registering error"
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

    public function listRegistros(Request $request, Response $response, array $args): Response
    {

        $professionalOccupation = new ProfessionalOccupationDAO();

        $data = $professionalOccupation->listRegistros();

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

    public function listProfessionalsByCompany(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $idCompany = $data['idCompany'];

        $professionalOccupation = new ProfessionalOccupationDAO();
        $professional = new ProfessionalDAO();
        $occupation = new OccupationDAO();
        $company = new CompanyDAO();

        $data = $professionalOccupation->listProfessionalsByCompany($idCompany);

        foreach($data as &$dataProfessional){
            $_professional = $professional->getProfessionalById($dataProfessional['idprofissional']);
            $_company = $company->getCompanyById($idCompany);
            $_occupation = $occupation->getOccupationById($dataProfessional['idocupacao']);
            
            $dataProfessional['profissional'] = $_professional;
            $dataProfessional['empresa'] = $_company;
            $dataProfessional['ocupacao'] = $_occupation;
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

    public function listProfessionalsByOccupation(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $idOccupation = $data['idOccupation'];

        $professionalOccupation = new ProfessionalOccupationDAO();
        $professional = new ProfessionalDAO();
        $occupation = new OccupationDAO();
        $company = new CompanyDAO();

        $data = $professionalOccupation->listProfessionalsByCompany($idOccupation);

        foreach($data as &$dataProfessional){
            $_occupation = $occupation->getOccupationById($idOccupation);
            $_professional = $professional->getProfessionalById($dataProfessional['idprofissional']);
            $_company = $company->getCompanyById($dataProfessional['idocupacao']);
            
            $dataProfessional['ocupacao'] = $_occupation;
            $dataProfessional['profissional'] = $_professional;
            $dataProfessional['empresa'] = $_company;
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