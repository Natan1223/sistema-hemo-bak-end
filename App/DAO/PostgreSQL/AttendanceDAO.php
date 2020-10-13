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
                            idtipo_atendimento,
                            descricao
                        FROM administracao.tipo_atendimento
                        WHERE ativo = 'T'
                        ");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    

    
}