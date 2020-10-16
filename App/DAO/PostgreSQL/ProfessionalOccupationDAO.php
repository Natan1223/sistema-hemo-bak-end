<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\ProfessionalOccupationModel;

final class ProfessionalOccupationDAO extends Connection
{
    public function __construct()
    {
        parent::__construct(); 
    }

    public function registerProfessionalOccupation(ProfessionalOccupationModel $professionalOccupation)
    {
        $statement = $this->pdo
            ->prepare(' SELECT
                            *
                        FROM administracao.profissional AS p,
                            administracao.ocupacao AS o,
                            administracao.empresa AS e
                        WHERE
                            :idprofissional = p.idprofissional OR 
                            :idocupacao = o.idocupacao OR
                            :idempresa = e.idempresa

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


            
            return getIdProfessional();
 
    }

    public function listByProfessional(): array
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

    public function listByOccupation(): array
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            *
                        FROM administracao.ocupacao
                        ORDER BY idocupacao
            ');
        $statement->execute();
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $response;
    }

    public function listByCompany(): array
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            *
                        FROM administracao.empresa
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