<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\ProfessionalOccupationModel;

final class ProfessionalOccupationDAO extends Connection
{
    public function __construct(\PDO $connection = null)
    {
        parent::__construct(); 
        if (isset($connection)) {
            $this->pdo = $connection;
        }
    }

    public function registerProfessionalOccupation(ProfessionalOccupationModel $professionalOccupation)
    {
        $statement = $this->pdo
            ->prepare(' SELECT
                            *
                        FROM administracao.profissional_ocupacao
                        WHERE
                            :idprofissional = idprofissional AND 
                            :idocupacao = idocupacao AND
                            :idempresa = idempresa

            ');
        $statement->execute([
            'idprofissional'=>$professionalOccupation->getIdProfessional(),
            'idocupacao'=>$professionalOccupation->getIdOccupation(),
            'idempresa'=>$professionalOccupation->getIdCompany()
        ]);
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        //Se não existe uma pessoa cadastrada com esse ID, então não é possivel cadastrar um profissional
        if(count($response)>0){
            return null;
        }

        $statement = $this->pdo
        ->prepare(' INSERT INTO 
                    administracao.profissional_ocupacao (
                        idprofissional,
                        idocupacao,
                        idempresa
                    ) VALUES (
                        :idprofissional,
                        :idocupacao,
                        :idempresa
                    );
        ');
        $statement->execute([
            'idprofissional'=>$professionalOccupation->getIdProfessional(),
            'idocupacao'=>$professionalOccupation->getIdOccupation(),
            'idempresa'=>$professionalOccupation->getIdCompany()
        ]);

        $success = $statement->rowCount() === 1;

        
        return $success;
 
    }

    public function listRegistros(): array
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            *
                        FROM administracao.profissional_ocupacao 
                        
                        ORDER BY idprofissional
            ');
        $statement->execute();
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $response;
    }

    public function listProfessionalsByCompany(int $id): array
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            po.idprofissional,
                            po.idocupacao,
                            po.idempresa
                        FROM administracao.profissional_ocupacao po
                        
                        JOIN administracao.profissional p
                        ON po.idprofissional = p.idprofissional
                        AND po.idempresa = :id
                        ORDER BY po.idempresa
            ');
        $statement->bindValue('id', $id);
        $statement->execute();
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $response;
    }

    public function listProfessionalsByOccupation(int $id): array
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            po.idprofissional,
                            po.idocupacao,
                            po.idempresa
                        FROM administracao.profissional_ocupacao po
                        
                        JOIN administracao.profissional p
                        ON po.idprofissional = p.idprofissional
                        AND po.ocupacao = :id
                        ORDER BY po.idocupacao
            ');
        $statement->bindValue('id', $id);
        $statement->execute();
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $response;
    }

    public function listByCompany(): array
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            *
                        FROM administracao.profissional_ocupacao
                        ORDER BY idempresa
            ');
        $statement->execute();
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $response;
    }

    public function updateProfessionalOccupationData(ProfessionalOccupationModel $professionalOccupation): array
    {
        $statement = $this->pdo
            ->prepare(' SELECT
                            *
                        FROM administracao.profissional, administracao.ocupacao, administracao.profissional_ocupacao
                        WHERE
                            :idprofissional = administracao.profissional.idprofissional OR 
                            :idocupacao = administracao.ocupacao.idocupacao OR
                            :idempresa = administracao.empresa.idempresa

            ');
        $statement->execute([
            'idprofissional'=>$professionalOccupation->getIdProfessional(),
            'idocupacao'=>$professionalOccupation->getIdOccupation(),
            'idempresa'=>$professionalOccupation->getIdCompany()
        ]);
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        //Se não existe uma pessoa cadastrada com esse ID, então não é possivel cadastrar um profissional
        if(count($response)>0){
            return null;
        }

        $statement = $this->pdo
        ->prepare(' UPDATE administracao.profissional_ocupacao SET
                        idprofissional,
                        idocupacao,
                        idempresa
                    WHERE 
        ');
            $statement->execute([
                'idprofissional'=>$professionalOccupation->getIdProfessional(),
                'idocupacao'=>$professionalOccupation->getIdOccupation(),
                'idempresa'=>$professionalOccupation->getIdCompany()
            ]);


            
            return getIdProfessional();

    }

}