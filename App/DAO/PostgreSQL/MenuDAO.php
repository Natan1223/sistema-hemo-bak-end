<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\MenuModel;

final class MenuDAO extends Connection
{
    public function __construct()
    {
        parent::__construct(); 
    }

    public function listMenus(): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT 
                            * 
                        FROM administracao.menu
                        ");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }
    
    public function registerMenu(MenuModel $menu)
    {
        $statement = $this->pdo
            ->prepare('INSERT INTO administracao.menu (
                descricao,
                ativo,
                path,
                idperfil
            )
            VALUES(
                :descricao,
                :ativo,
                :path, 
                :idperfil 
            );
        ');

        $statement->execute([
            'descricao' => $menu->getDescription(),
            'ativo' => $menu->getActive(),
            'path' => $menu->getPath(),
            'idperfil' => $menu->getIdProfile()
        ]);
        
        $idMenu =  $this->pdo->lastInsertId();
            
        return $idMenu;
    }
}