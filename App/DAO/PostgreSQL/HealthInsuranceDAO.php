<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\HealthInsuranceModel;

final class HealthInsuranceDAO extends Connection
{
    public function __construct()
    {
        parent::__construct(); 
    }

    public function listHealthInsuranceCompany(): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT 
                            c.idconvenio,
                            c.descricao
                        FROM administracao.empresa_convenio ec 
                        join administracao.convenio c 
                            on ec.idconvenio = c.idconvenio 
                        WHERE ec.idempresa = 1  --alterar para sessão com codigo da empresa do usuario autenticado
                        and ec.ativo = 'T'
                        ");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    
}