<?php
declare(strict_types=1);

namespace MyApp\Model;

use PDO;

class EquipesModel
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAllEquipes(): array
    {
        $sql = 'SELECT
            `Equipes`.`nom_equipe`,
            GROUP_CONCAT(CONCAT(`Coureurs`.`nom_coureur`, \' \', `Coureurs`.`prenom_coureur`) SEPARATOR \', \') AS `coureurs`
        FROM
            `Equipes`
        LEFT JOIN
            `Coureurs` ON `Coureurs`.`num_equipe` = `Equipes`.`Id_Equipe`
        GROUP BY
            `Equipes`.`nom_equipe`;';
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}