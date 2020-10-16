<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\DiagnosisModel;

final class DiagnosisDAO extends Connection
{
    public function __construct()
    {
        parent::__construct(); 
    }

    public function listVWDiagnosis(string $descricao): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT 
                            vd.iddiagnostico, 
                            UPPER(vd.descricao) 
                        FROM prontuario.vw_diagnostico vd
                        WHERE UPPER(vd.descricao) like :descricao
                        ORDER BY vd.descricao
            ");
        $statement->bindValue(':descricao', '%'.$descricao.'%');
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    
}