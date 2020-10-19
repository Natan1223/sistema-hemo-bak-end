<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\ClinicModel;

final class ClinicDAO extends Connection
{
    public function __construct()
    {
        parent::__construct(); 
    }

    public function listClinic(): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT 
                            c.idclinica,
	                        c.descricao
                        FROM administracao.clinica c 
                        WHERE c.idempresa =  1  --alterar para sessão com codigo da empresa do usuario autenticado
                        and c.ativo = 'T'
                        ");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    
}