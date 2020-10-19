<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\PatientModel;

final class PatientDAO extends Connection
{
    public function __construct()
    {
        parent::__construct(); 
    }

    public function listPatient(string $nome): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT 
                            p.idpaciente,
                            p2.nome,
                            pp.numero_prontuario as numeroprontuario
                        FROM prontuario.paciente p
                        join administracao.pessoa p2
                            on p.idpessoa = p2.idpessoa
                        join prontuario.prontuario_paciente pp 
                            on p.idpaciente = pp.idpaciente 
                            and pp.idempresa = :idEmpresa
                        WHERE p2.nome like :nome
                        ");
        $statement->bindValue(':nome', '%'.$nome.'%');
        $statement->bindValue(':idEmpresa', $_SESSION['idEmpresa']);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

}