<?php
declare (strict_types = 1);

namespace MyApp\Model;

use PDO;

class ClassementGeneralModel
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getClassementGeneral(): array
    {
        $meilleurTempsTotal = '68:26:38'; 

        
        $sql = 'SELECT
            c.nom_coureur,
            r.num_dossard,
            c.num_equipe,
            SEC_TO_TIME(IFNULL(SUM(r.chrono), 0)) AS temps_total
        FROM Resultats r
        INNER JOIN Coureurs c ON r.num_dossard = c.Id_Dossard
        WHERE r.chrono IS NOT NULL
        GROUP BY c.nom_coureur, c.num_equipe, c.code_pays, r.num_dossard
        ORDER BY temps_total ASC;';

        $stmt = $this->db->query($sql);
        $classements = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $classementsFiltres = [];
        foreach ($classements as $coureur) {
            $coureur['temps_total_seconds'] = $this->convertTimeToSeconds($coureur['temps_total']);
            $meilleurTempsTotalSeconds = $this->convertTimeToSeconds($meilleurTempsTotal);
            $coureur['ecart_seconds'] = $coureur['temps_total_seconds'] - $meilleurTempsTotalSeconds;

            if ($coureur['ecart_seconds'] < 0) {
                $coureur['ecart_seconds'] = 0;
            }

            $coureur['ecart_format'] = $this->convertSecondsToTime($coureur['ecart_seconds']);

            $classementsFiltres[] = $coureur;
        }

        return $classementsFiltres;
    }

    private function convertTimeToSeconds(string $time): int
    {
        if ($time === '00:00:00' || empty($time)) {
            return 0;
        }

        list($h, $m, $s) = explode(':', $time);
        return $h * 3600 + $m * 60 + $s;
    }

    // Convertir un écart en secondes au format H:i:s
    private function convertSecondsToTime(int $seconds): string
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;
        return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
    }
}
