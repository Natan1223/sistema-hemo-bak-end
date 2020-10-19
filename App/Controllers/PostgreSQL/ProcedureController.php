<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\ProcedureDAO;
use App\Models\PostgreSQL\ProcedureModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ProcedureController
{
    public function listTypeProcedure(Request $request, Response $response, array $args): Response
    {
        $procedure = new ProcedureDAO();

        $data = $procedure->listTypeProcedure();

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

    public function registerProcedure(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $procedureDAO = new ProcedureDAO();
        $procedure = new ProcedureModel();

        if($data){
            
            $procedure
                ->setIdAttendance($data['idAttemdance'])
                ->setIdTypeProcedure($data['idTypeProcedure'])
                ->setObservation($data['observation'])
                ->setDateSolicitation(getenv('DATA_HORA_SISTEMA'));

            $idProcedure = $procedureDAO->registerProcedure($procedure); 
            
            if($idProcedure){

                $dataResult = [
                    "idProcedure" => $idProcedure
                ];
                
                $response = $response
                ->withStatus(200)
                ->withjson([
                    "message" => [
                        "pt" => "Procedimento cadastrado com sucesso...",
                        "en" => "Procedure successfully registered."
                    ],
                    'result' => $dataResult
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
}