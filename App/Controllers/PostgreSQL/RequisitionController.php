<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\RequisitionDAO;
use App\Models\PostgreSQL\RequisitionModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class RequisitionController
{
    public function listTransfusionModality(Request $request, Response $response, array $args): Response
    {
        $transfusionModality = new RequisitionDAO();

        $data = $transfusionModality->listTransfusionModality();

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

    public function registerRequisition(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $requisitionDAO = new RequisitionDAO();
        $requisition = new RequisitionModel();

        if($data){
            
            $requisition
                ->setIdProcedure($data['idProcedure'])
                ->setIdUser($_SESSION['idUsuario'])
                ->setIdStatusRequisition($data['idStatusRequisition'])
                ->setIdTypeTransfusion($data['idTypeTransfusion'])
                ->setIdCompany($_SESSION['idEmpresa'])
                ->setIdClinic($data['idClinic'])
                ->setIdBed($data['idBed'])
                ->setIdProfessionalMedical(2) //alterar para a sessao do profisional
                ->setWeight($data['weight'])
                ->setPlatelets($data['platelets'])
                ->setHematoctro($data['hematoctro'])
                ->setHemoglobin($data['hemoglobin'])
                ->setObservation($data['observation'])
                ->setDateTimeRegister(getenv('DATA_HORA_SISTEMA'));
               

            $idRequisition = $requisitionDAO->registerRequisition($requisition); 
            

            $dataResult = [
                "idRequisition" => $idRequisition
            ];
            
            $response = $response
            ->withStatus(200)
            ->withjson([
                "message" => [
                    "pt" => "Requisição cadastrada com sucesso...",
                    "en" => "Requisition successfully registered."
                ],
                'result' => $dataResult
            ]);   

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