<?php

declare(strict_types=1);

namespace MyApp\Controller;

use Twig\Environment;
use MyApp\Service\DependencyContainer;

class CoureursController
{
    private $twig;
    private $db;

    public function __construct(Environment $twig, DependencyContainer $dependencyContainer)
    {
        $this->twig = $twig;
        $this->db = $dependencyContainer->get('PDO');
    }

    public function listCoureurs()
    {
        $search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);
        $teamId = filter_input(INPUT_GET, 'teamid', FILTER_VALIDATE_INT);
        $params = [];

        if ($teamId) {
            $sql = 'SELECT id_dossard, nom_coureur, prenom_coureur, code_pays, num_equipe FROM Coureurs WHERE num_equipe = :team_id';
            $params[':team_id'] = $teamId;
        } else {
            $sql = 'SELECT id_dossard, nom_coureur, prenom_coureur, code_pays, num_equipe FROM Coureurs';
        }

        if ($search) {
            $sql .= ' WHERE nom_coureur LIKE :search OR prenom_coureur LIKE :search';
            $params[':search'] = '%' . $search . '%';
        }

        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        $coureurs = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Fetch teams and countries
        $teams = $this->getTeams();
        $countries = $this->getCountries();

        echo $this->twig->render('coureurs/list.html.twig', [
            'coureurs' => $coureurs,
            'search' => $search,
            'teams' => $teams,
            'countries' => $countries
        ]);
    }

    private function getTeams()
    {
        $stmt = $this->db->query('SELECT id_equipe, nom_equipe FROM Equipes');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    private function getCountries()
    {
        $stmt = $this->db->query('SELECT code_pays, nom_pays FROM Pays');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addCoureur()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom_coureur'];
            $prenom = $_POST['prenom_coureur'];
            $date_naissance = $_POST['date_naissance'];
            $code_pays = $_POST['code_pays'] ?? null;
            $num_equipe = $_POST['num_equipe'] ?? null;

            $stmt = $this->db->prepare('INSERT INTO Coureurs (nom_coureur, prenom_coureur, date_naissance, code_pays, num_equipe) VALUES (:nom, :prenom, :date_naissance, :code_pays, :num_equipe)');
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':date_naissance', $date_naissance);
            $stmt->bindParam(':code_pays', $code_pays);
            $stmt->bindParam(':num_equipe', $num_equipe);
            $stmt->execute();

            header('Location: /projetBDD/index.php?page=list_coureurs');
            exit;
        }
    }

    public function editCoureur()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_dossard'];
            $nom = $_POST['nom_coureur'];
            $prenom = $_POST['prenom_coureur'];
            $date_naissance = $_POST['date_naissance'];
            $code_pays = $_POST['code_pays'];
            $num_equipe = $_POST['num_equipe'];

            $stmt = $this->db->prepare('UPDATE Coureurs SET nom_coureur = :nom, prenom_coureur = :prenom, date_naissance = :date_naissance, code_pays = :code_pays, num_equipe = :num_equipe WHERE id_dossard = :id');
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':date_naissance', $date_naissance);
            $stmt->bindParam(':code_pays', $code_pays);
            $stmt->bindParam(':num_equipe', $num_equipe);
            $stmt->execute();

            header('Location: /projetBDD/index.php?page=list_coureurs');
            exit;
        }
    }

    public function deleteCoureur()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $stmt = $this->db->prepare('DELETE FROM Coureurs WHERE id_dossard = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        header('Location: /projetBDD/index.php?page=list_coureurs');
        exit;
    }

    public function showCoureur()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $stmt = $this->db->prepare('SELECT * FROM Coureurs WHERE id_dossard = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $coureur = $stmt->fetch(\PDO::FETCH_ASSOC);

        echo $this->twig->render('coureurs/show.html.twig', ['coureur' => $coureur]);
    }
}