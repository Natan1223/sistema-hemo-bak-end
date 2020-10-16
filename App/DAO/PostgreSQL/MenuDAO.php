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
                            idmenu,
                            idperfil,
                            descricao,
                            path,
                            idmenu_titulo,
                            ativo
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

    public function updateMenu(MenuModel $menu)
    {
        $statement = $this->pdo
            ->prepare('UPDATE administracao.menu SET
                descricao = :descricao,
                ativo = :ativo,
                path = :path,
                idmenu_titulo = :idmenu_titulo
            WHERE
                idmenu = :idmenu
            ;
        ');

        $statement->execute([
            'idmenu' => $menu->getIdMenu(),
            'descricao' => $menu->getDescription(),
            'ativo' => $menu->getActive(),
            'path' => $menu->getPath(),
            'idmenu_titulo' => $menu->getIdMenuTitle()
        ]);
        
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function getMenuByIdProfile($idProfile): array
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            *
                        FROM administracao.menu m
                        JOIN administracao.perfil p
                        ON m.idperfil = p.idperfil
                        AND p.idperfil = :idperfil
                        ORDER BY m.idperfil
            ');
        $statement->execute([
            'idperfil' => $idProfile
        ]);
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $response;
    }
}