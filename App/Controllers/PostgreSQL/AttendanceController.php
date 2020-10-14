<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\AttendanceDAO;
use App\Models\PostgreSQL\AttendanceModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AttendanceController
{
    public function listTypeAttendance(Request $request, Response $response, array $args): Response
    {
        $attendance = new AttendanceDAO();

        $data = $attendance->listTypeAttendance();

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

    public function registerAttendance(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $attendanceDAO = new AttendanceDAO();
        $attendance = new AttendanceModel();

        if($data){
            $attendance
                ->setIdCompany($_SESSION['idCompany'])
                ->setIdPatient($data['idPatient'])
                ->setIdTypeAttendance($data['idTypeAttendance'])
                ->setDateAttendance(getenv('DATA_HORA_SISTEMA'));

            $idAttendance = $attendanceDAO->registerAttendance($attendance); 
            
            $dataResult = [
                "idAttendance" => $idAttendance
            ];
            
            $response = $response
            ->withStatus(406)
            ->withjson([
                "message" => [
                    "pt" => "Atendimento cadastrado com sucesso...",
                    "en" => "Attendance successfully registered."
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