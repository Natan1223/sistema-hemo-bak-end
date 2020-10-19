<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\ProcedureModel;

final class ProcedureDAO extends Connection
{
    public function __construct()
    {
        parent::__construct(); 
    }

    public function listTypeProcedure(): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT 
                            tp.idtipo_procedimento as idtipoprocedimento,
                            tp.descricao
                        FROM prontuario.tipo_procedimento tp 
                        WHERE tp.ativo = 'T'
            ");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function registerProcedure(ProcedureModel $procedure)
    {
        $statement = $this->pdo
            ->prepare(' INSERT INTO prontuario.procedimento (
                            idatendimento,
                            idtipo_procedimento,
                            observacao,
                            data_solicitacao
                        ) VALUES (
                            :idAtendimento,
                            :idTipoProcedimento,
                            :observacao,
                            :dataSolicitacao
                        );
            ');
        $statement->execute([
            'idAtendimento' => $procedure->getIdAttendance(),
            'idTipoProcedimento' => $procedure->getIdTypeProcedure(),
            'observacao' => $procedure->getObservation(),
            'dataSolicitacao' => $procedure->getDateSolicitation()
        ]);

        $idProcedure =  $this->pdo->lastInsertId();
        
        return $idProcedure;
    }
    
}