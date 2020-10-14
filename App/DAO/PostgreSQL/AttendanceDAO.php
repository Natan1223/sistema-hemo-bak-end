<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\AttendanceModel;

final class AttendanceDAO extends Connection
{
    public function __construct()
    {
        parent::__construct(); 
    }

    public function listAttendance(): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT 
                            * 
                        FROM administracao.atendimento
                        ");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function listTypeAttendance(): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT 
                            idtipo_atendimento as idtipoatendimento,
                            descricao
                        FROM prontuario.tipo_atendimento
                        WHERE ativo = 'T'
                        ");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function registerAttendance(AttendanceModel $attendance)
    {
        $statement = $this->pdo
            ->prepare(' INSERT INTO administracao.atendimento (
                            idempresa,
                            idtipo_atendimento,
                            idpaciente,
                            data_atendimento
                        ) VALUES (
                            :idEmpresa,
                            :idTipoAtendimento,
                            :idPaciente,
                            :dataAtendimento
                        );
            ');
        $statement->execute([
            'idEmpresa' => $attendance->getIdCompany(),
            'idTipoAtendimento' => $attendance->getIdTypeAttendance(),
            'idPaciente' => $attendance->getIdPatient(),
            'dataAtendimento' => $attendance->getDateAttendance()
        ]);

        $idAttendance =  $this->pdo->lastInsertId();
        
        return $idAttendance;
 
    }
    
}