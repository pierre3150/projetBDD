<?php
declare (strict_types = 1);

namespace MyApp\Model;

use PDO;

class ClassementEquipeModel
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getClassementEquipe(): array
    {
        $sql = '
        Select e.nom_Equipe, SEC_TO_TIME(SUM(top3.chrono)) AS temps_total
        FROM Equipes e
        INNER JOIN Coureurs c ON e.Id_Equipe = c.num_equipe
        INNER  JOIN (Select r1.num_etape, c1.num_equipe, r1.num_dossard, r1.chrono FROM Resultats r1 INNER  JOIN Coureurs c1 ON r1.num_dossard = c1.Id_Dossard WHERE r1.num_etape <= 13 AND ( Select COUNT(*) FROM Resultats r2 INNER  JOIN Coureurs c2 ON r2.num_dossard = c2.Id_Dossard WHERE r2.num_etape = r1.num_etape AND c2.num_equipe = c1.num_equipe AND r2.chrono < r1.chrono) < 3  ) AS top3 ON c.Id_Dossard = top3.num_dossard
        GROUP BY e.nom_Equipe
        ORDER BY temps_total ASC;        
    ';

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
