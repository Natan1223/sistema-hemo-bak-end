<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\ProfessionalCouncilModel;

final class ProfessionalCouncilDAO extends Connection
{
    public function __construct()
    {
        parent::__construct(); 
    }

    public function registerProfessionalCouncil(ProfessionalCouncilModel $council)
    {
            $statement = $this->pdo
                ->prepare(' INSERT INTO 
                            administracao.conselho_profissional (
                                descricao,
                                sigla,
                                ativo
                            ) VALUES (
                                :descricao,
                                :sigla,
                                :ativo
                            );
                ');
            $statement->execute([
                'descricao'=>$council->getDescription(),
                'sigla'=>$council->getInitials(),
                'ativo'=>$council->getActive()
            ]);

            $idProfessionalCouncil =  $this->pdo->lastInsertId();
            
            return $idProfessionalCouncil;
 
    }

    public function listCouncils(): array
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            idconselho_profissional,
                            descricao,
                            sigla,
                            ativo
                        FROM administracao.conselho_profissional
                        ORDER BY idconselho_profissional
            ');
        $statement->execute();
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $response;
    }

    public function getCouncilById(int $id): array
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            idconselho_profissional,
                            descricao,
                            sigla,
                            ativo
                        FROM administracao.conselho_profissional
                        WHERE idconselho_profissional = :id
                        ORDER BY idconselho_profissional
            ');
        $statement->bindValue('id', $id);
        $statement->execute();
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $response;
    }

    public function updateCouncilData(ProfessionalCouncilModel $council, int $id): void
    {
        $statement = $this->pdo
            ->prepare(' UPDATE administracao.conselho_profissional SET
                            descricao = :descricao,
                            sigla = :sigla,
                            ativo = :ativo
                        WHERE
                            idconselho_profissional = :id
                        ');

        $statement->bindValue('id', $id);
        $statement->execute([
            'id' => $council->getIdProfessionalCouncil(),
            'descricao' => $council->getDescription(),
            'sigla' => $council->getInitials(),
            'ativo' => $council->getActive()
        ]);
        return;
    }

}