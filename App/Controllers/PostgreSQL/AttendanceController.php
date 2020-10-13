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


    
}