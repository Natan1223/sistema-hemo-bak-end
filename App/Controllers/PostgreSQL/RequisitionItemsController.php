<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\RequisitionItemsDAO;
use App\Models\PostgreSQL\RequisitionItemsModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class RequisitionItemsController
{
    public function listProduct(Request $request, Response $response, array $args): Response
    {
        $itemsRequisition = new RequisitionItemsDAO();

        $data = $itemsRequisition->listProduct();

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

    // public function listAttendance(Request $request, Response $response, array $args): Response
    // {
    //     $attendance = new AttendanceDAO();

    //     $data = $attendance->listAttendance();

    //     $result = [
    //         'message' => [
    //             'pt' => null,
    //             'en' => null
    //         ],
    //         'result' => $data
    //     ];

    //     $response = $response
    //         ->withjson($result);

    //     return $response;
    // }

    public function registerItemsRequisition(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $itemsRequisitionDAO = new RequisitionItemsDAO();
        $itemsRequisition = new RequisitionItemsModel();
        
        if($data){
            
            $itemsRequisition
                ->setIdRequisition($data['idRequisition'])
                ->setIdProducts($data['idProduct'])
                ->setAbo($data['abo'])
                ->setRhd($data['rhd'])
                ->setUnitQuantity($data['unitQuantity'])
                ->setMlQuantity($data['mlQuantity'])
                ->setPhenotyped($data['phenotyped'])
                ->setInterval($data['interval'])
                ->setDateScheduled($data['dateScheduled'])
                ->setDateTimeRegister(getenv('DATA_HORA_SISTEMA'));

            $itemsRequisitionDAO->registerItemsRequisition($itemsRequisition); 
                
            $response = $response
            ->withStatus(200)
            ->withjson([
                "message" => [
                    "pt" => "Atendimento cadastrado com sucesso...",
                    "en" => "Attendance successfully registered."
                ],
                'result' => null
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