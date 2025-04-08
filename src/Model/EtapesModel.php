<?php
declare (strict_types = 1);

namespace MyApp\Model;

use PDO;

class EtapesModel
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAllEtapes(): array
    {
        $sql = 'SELECT
        Etapes.date_etape AS dateEtape,
        Etapes.type_etape AS typeEtape,
        Etapes.distance,
        Etapes.repos_transfert AS reposTransfert,
        Etapes.num_ville_dep,
        Etapes.num_ville_arr,
        VillesDep.nom_ville AS ville_dep,
        VillesArr.nom_ville AS ville_arr
    FROM Etapes
    LEFT JOIN Villes AS VillesDep ON Etapes.num_ville_dep = VillesDep.Id_Ville
    LEFT JOIN Villes AS VillesArr ON Etapes.num_ville_arr = VillesArr.Id_Ville;';

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
