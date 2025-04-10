<?php
declare (strict_types = 1);

namespace MyApp\Model;

use PDO;

class ClassementEtapeModel
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getClassementEtape(): array
    {
        $sql = 'SELECT
        r.num_etape,
        e.nom_Equipe,
        c.nom_coureur,
        SEC_TO_TIME(r.chrono) AS temps,
        RANK() OVER (PARTITION BY r.num_etape ORDER BY r.chrono ASC) AS rang_coureur,
        SEC_TO_TIME(r.chrono - (SELECT MIN(r2.chrono) FROM Resultats r2 WHERE r2.num_etape = r.num_etape)) AS ecart_avec_meilleur,
        (SELECT SUM(r3.distance) FROM Etapes r3 WHERE r3.num_etape = r.num_etape) AS distance_totale
    FROM
        Resultats r
    INNER JOIN
        Coureurs c ON r.num_dossard = c.Id_Dossard
    INNER JOIN
        Equipes e ON c.num_equipe = e.Id_Equipe
    WHERE
        r.num_etape = :etape_id
    ORDER BY
        r.chrono ASC;';

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
