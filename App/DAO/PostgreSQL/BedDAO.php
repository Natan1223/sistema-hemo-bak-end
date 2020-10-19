<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\BedModel;

final class BedDAO extends Connection
{
    public function __construct()
    {
        parent::__construct(); 
    }

    public function listBedIdClinic(int $idClinic): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT 
                            l.idleito,
                            l.descricao
                        FROM administracao.leito_clinica lc 
                        join administracao.leito l
                            on lc.idleito = l.idleito
                        where lc.idclinica = :idClinic
            ");
        $statement->bindParam(':idClinic', $idClinic);       
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    
}