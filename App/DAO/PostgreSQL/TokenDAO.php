<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Conexao;
use App\Models\PostgreSQL\TokenModel;

final class TokenDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct(); 
    }

    public function criaToken(TokenModel $token): void
    {
        $statement = $this->pdo
            ->prepare('INSERT INTO administracao.token
                (
                    token,
                    idusuario,
                    refreshtoken,
                    dataexpira
                )
                VALUES
                (
                    :token,
                    :idUsuario,
                    :refreshToken,
                    :dataExpira
                )
            ');
        $statement->execute([
            'token' => $token->getToken(),
            'idUsuario' => $token->getIdUsuario(),
            'refreshToken' => $token->getRefreshToken(),
            'dataExpira' => $token->getDataExpira()
        ]);
        
    }
    
}