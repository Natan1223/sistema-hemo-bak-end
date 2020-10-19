<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\RequisitionModel;

final class RequisitionDAO extends Connection
{
    public function __construct()
    {
        parent::__construct(); 
    }

    public function listTransfusionModality(): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT
                            tt.idtipo_transfusao as idtipotransfusao,
                            tt.descricao
                        FROM prontuario.tipo_transfusao tt
                        ");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function registerRequisition(AttendanceModel $attendance)
    {
        $statement = $this->pdo
            ->prepare(' INSERT INTO prontuario.atendimento (
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