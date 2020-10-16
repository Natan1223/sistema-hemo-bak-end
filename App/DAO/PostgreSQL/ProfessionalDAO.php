<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\ProfessionalModel;

final class ProfessionalDAO extends Connection
{
    public function __construct()
    {
        parent::__construct(); 
    }

    public function registerProfessional(ProfessionalModel $professional)
    {
        $statement = $this->pdo
            ->prepare(' SELECT
                            *
                        FROM administracao.pessoa, administracao.conselho_profissional, administracao.profissional
                        WHERE
                            :idpessoa = administracao.profissional.idpessoa OR 
                            :matricula = administracao.profissional.matricula

            ');
        $statement->execute([
            'idpessoa'=>$professional->getIdPerson(),
            'matricula'=>$professional->getRegistry()
        ]);
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        //Se não existe uma pessoa cadastrada com esse ID, então não é possivel cadastrar um profissional
        if(count($response)>0){
            return null;
        }

        $statement = $this->pdo
        ->prepare(' INSERT INTO 
                    administracao.profissional (
                        idpessoa,
                        idconselho_profissional,
                        numero_conselho,
                        matricula,
                        ativo
                    ) VALUES (
                        :idpessoa,
                        :idconselho_profissional,
                        :numero_conselho,
                        :matricula,
                        :ativo 
                    );
        ');
            $statement->execute([
                'idpessoa'=>$professional->getIdPerson(),
                'idconselho_profissional'=>$professional->getIdProfessionalCouncil(),
                'numero_conselho'=>$professional->getCouncilNumber(),
                'matricula'=>$professional->getRegistry(),
                'ativo'=>$professional->getActive()
            ]);

            $idProfessional = $this->pdo->lastInsertId();
            
            return $idProfessional;
 
    }

    public function listProfessionals(): array
    {
        $statement = $this->pdo
            ->prepare(' SELECT
                            p.idprofissional,
                            p.idpessoa,
                            p.idconselho_profissional,
                            p.numero_conselho,
                            p.matricula,
                            p.ativo

                        FROM administracao.profissional  p

                        JOIN administracao.pessoa  pe
                        ON p.idpessoa = pe.idpessoa 

                        JOIN administracao.conselho_profissional  cp
                        ON p.idconselho_profissional = cp.idconselho_profissional

                        ORDER BY p.idprofissional
            ');
        $statement->execute();
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $response;
    }

    // public function listProfessionalsByCompany(): array
    // {
    //     $statement = $this->pdo
    //         ->prepare(' SELECT 
    //                         *
    //                     FROM administracao.profissional p
    //                     JOIN administracao.profissional_ocupacao po
    //                     ON p.idprofissional = po.idprofissional
    //                     AND po.idempresa = 1
    //                     ORDER BY p.idprofissional
    //         ');
    //     $statement->execute();
    //     $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
    //     return $response;
    // }

    public function updateProfessionalData(ProfessionalModel $professional): array
    {
        $statement = $this->pdo
            ->prepare(' UPDATE administracao.profissional SET
                            idpessoa = :idpessoa,
                            idconselho_profissional = :idconselho_profissional,
                            numero_conselho = :numero_conselho,
                            matricula = :matricula,
                            ativo = :ativo
                        WHERE
                            idpessoa = :idpessoa'
                            );

        $statement->execute([
            'idpessoa' => $professional->getIdPerson(),
            'idconselho_profissional' => $professional->getIdProfessionalCouncil(),
            'numero_conselho' => $professional->getCouncilNumber(),
            'matricula' => $professional->getRegistry(),
            'ativo' => $professional->getActive()
        ]);
        
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

}