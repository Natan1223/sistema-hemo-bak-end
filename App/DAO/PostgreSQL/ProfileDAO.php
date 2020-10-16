<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\ProfileModel;

final class ProfileDAO extends Connection
{
    public function __construct()
    {
        parent::__construct(); 
    }

    public function checkIfProfileExists(ProfileModel $profile): bool
    {
        $exist = false;

        $statement = $this->pdo
            ->prepare(' SELECT 
                            *
                        FROM administracao.perfil
                        WHERE :descricao = descricao
                        ;');
        $statement->execute([
            'descricao' => $profile->getDescription()
        ]);

        $result = $statement->fetchAll(\PDO::FETCH_ASSOC); 
    
        if ($result){
            $exist = true;
        }else{
            $exist = false;
        }

        return $exist;
    }

    public function listProfiles(): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT 
                            * 
                        FROM administracao.perfil
                        ");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function registerProfile(ProfileModel $profile)
    {
        $statement = $this->pdo
            ->prepare('INSERT INTO administracao.perfil (
                descricao,
                ativo
            )
            VALUES(
                :descricao,
                :ativo
            );
        ');

        $statement->execute([
            'descricao' => $profile->getDescription(),
            'ativo' => $profile->getActive(),
        ]);
        
        $idProfile =  $this->pdo->lastInsertId();
            
        return $idProfile;
    }

    public function updateProfile(ProfileModel $profile): array
    {
        $statement = $this->pdo
            ->prepare('UPDATE administracao.perfil SET
                descricao = :descricao,
                ativo = :ativo
            WHERE
                idperfil = :idperfil
            ;
        ');

        $statement->execute([
            'descricao' => $profile->getDescription(),
            'ativo' => $profile->getActive(),
            'idperfil' => $profile->getIdProfile()
        ]);

        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }
}