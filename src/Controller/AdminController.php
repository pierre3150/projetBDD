<?php

declare(strict_types=1);

namespace MyApp\Controller;

use Twig\Environment;
use MyApp\Service\DependencyContainer;

class AdminController
{
    private $twig;
    private $db;

    public function __construct(Environment $twig, DependencyContainer $dependencyContainer)
    {
        $this->twig = $twig;
        $this->db = $dependencyContainer->get('PDO');
    }

    public function admin()
    {
        // Récupérer les étapes depuis la base de données avec les villes de départ et d'arrivée
        $sql = 'SELECT 
                Etapes.id_etape, 
                Etapes.date_etape, 
                Etapes.type_etape, 
                Etapes.distance, 
                Etapes.repos_transfert, 
                VillesDep.nom_ville AS ville_dep, 
                VillesArr.nom_ville AS ville_arr 
            FROM Etapes
            LEFT JOIN Villes AS VillesDep ON Etapes.num_ville_dep = VillesDep.id_ville
            LEFT JOIN Villes AS VillesArr ON Etapes.num_ville_arr = VillesArr.id_ville';
        $stmt = $this->db->query($sql);
        $etapes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Rendre le template avec les données des étapes
        echo $this->twig->render('admin/admin.html.twig', ['etapes' => $etapes]);
    }

    public function editStage()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_etape = $_POST['id_etape'];
            $date_etape = $_POST['date_etape'];
            $type_etape = $_POST['type_etape'];
            $distance = $_POST['distance'];
            $repos_transfert = $_POST['repos_transfert'];
            $ville_dep = $_POST['ville_dep'];
            $ville_arr = $_POST['ville_arr'];

            // Check if stage ID already exists
            $stmt = $this->db->prepare('SELECT COUNT(*) FROM Etapes WHERE id_etape = :id_etape AND id_etape != :current_id');
            $stmt->bindParam(':id_etape', $id_etape);
            $stmt->bindParam(':current_id', $id);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $error_message = 'Stage ID already exists. Please use a different ID.';
                echo $this->twig->render('admin/edit_stage.html.twig', [
                    'error_message' => $error_message,
                    'etape' => [
                        'id_etape' => $id_etape,
                        'date_etape' => $date_etape,
                        'type_etape' => $type_etape,
                        'distance' => $distance,
                        'repos_transfert' => $repos_transfert,
                        'ville_dep' => $ville_dep,
                        'ville_arr' => $ville_arr
                    ]
                ]);
                return;
            }

            // Check if departure city exists, if not, redirect to add city page
            $stmt = $this->db->prepare('SELECT id_ville FROM Villes WHERE nom_ville = :nom_ville');
            $stmt->bindParam(':nom_ville', $ville_dep);
            $stmt->execute();
            $ville_dep_id = $stmt->fetchColumn();
            if (!$ville_dep_id) {
                header('Location: /projetBDD/index.php?page=add_city&stage_id=' . $id . '&city=' . urlencode($ville_dep));
                exit;
            }

            // Check if arrival city exists, if not, redirect to add city page
            $stmt = $this->db->prepare('SELECT id_ville FROM Villes WHERE nom_ville = :nom_ville');
            $stmt->bindParam(':nom_ville', $ville_arr);
            $stmt->execute();
            $ville_arr_id = $stmt->fetchColumn();
            if (!$ville_arr_id) {
                header('Location: /projetBDD/index.php?page=add_city&stage_id=' . $id . '&city=' . urlencode($ville_arr));
                exit;
            }

            // Update the stage with the new information
            $stmt = $this->db->prepare('UPDATE Etapes SET id_etape = :id_etape, date_etape = :date_etape, type_etape = :type_etape, distance = :distance, repos_transfert = :repos_transfert, num_ville_dep = :num_ville_dep, num_ville_arr = :num_ville_arr WHERE id_etape = :current_id');
            $stmt->bindParam(':id_etape', $id_etape);
            $stmt->bindParam(':date_etape', $date_etape);
            $stmt->bindParam(':type_etape', $type_etape);
            $stmt->bindParam(':distance', $distance);
            $stmt->bindParam(':repos_transfert', $repos_transfert);
            $stmt->bindParam(':num_ville_dep', $ville_dep_id);
            $stmt->bindParam(':num_ville_arr', $ville_arr_id);
            $stmt->bindParam(':current_id', $id);
            $stmt->execute();

            echo 'Stage updated successfully!';
            echo '<script>
            setTimeout(function() {
                window.location.href = "/projetBDD/index.php?page=admin";
            }, 2000);
        </script>';
        } else {
            // Retrieve the current stage information
            $stmt = $this->db->prepare('SELECT Etapes.*, VillesDep.nom_ville AS ville_dep, VillesArr.nom_ville AS ville_arr FROM Etapes LEFT JOIN Villes AS VillesDep ON Etapes.num_ville_dep = VillesDep.id_ville LEFT JOIN Villes AS VillesArr ON Etapes.num_ville_arr = VillesArr.id_ville WHERE id_etape = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $etape = $stmt->fetch(\PDO::FETCH_ASSOC);

            echo $this->twig->render('admin/edit_stage.html.twig', ['etape' => $etape]);
        }
    }

    public function deleteStage()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $stmt = $this->db->prepare('DELETE FROM Etapes WHERE id_etape = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        echo 'Stage deleted successfully!';
        echo '<script>
            setTimeout(function() {
                window.location.href = "/projetBDD/index.php?page=admin";
            }, 2000);
        </script>';
    }

    public function addStage()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_etape = $_POST['id_etape'];
            $date_etape = $_POST['date_etape'];
            $type_etape = $_POST['type_etape'];
            $distance = $_POST['distance'];
            $repos_transfert = $_POST['repos_transfert'];
            $ville_dep = $_POST['ville_dep'];
            $ville_arr = $_POST['ville_arr'];

            // Check if stage ID already exists
            $stmt = $this->db->prepare('SELECT COUNT(*) FROM Etapes WHERE id_etape = :id_etape');
            $stmt->bindParam(':id_etape', $id_etape);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $error_message = 'Stage ID already exists. Please use a different ID.';
                echo $this->twig->render('admin/add_stage.html.twig', [
                    'error_message' => $error_message,
                    'id_etape' => $id_etape,
                    'date_etape' => $date_etape,
                    'type_etape' => $type_etape,
                    'distance' => $distance,
                    'repos_transfert' => $repos_transfert,
                    'ville_dep' => $ville_dep,
                    'ville_arr' => $ville_arr
                ]);
                return;
            }

            // Check if departure city exists, if not, insert it
            $stmt = $this->db->prepare('SELECT id_ville FROM Villes WHERE nom_ville = :nom_ville');
            $stmt->bindParam(':nom_ville', $ville_dep);
            $stmt->execute();
            $ville_dep_id = $stmt->fetchColumn();
            if (!$ville_dep_id) {
                $stmt = $this->db->prepare('INSERT INTO Villes (nom_ville) VALUES (:nom_ville)');
                $stmt->bindParam(':nom_ville', $ville_dep);
                $stmt->execute();
                $ville_dep_id = $this->db->lastInsertId();
            }

            // Check if arrival city exists, if not, insert it
            $stmt = $this->db->prepare('SELECT id_ville FROM Villes WHERE nom_ville = :nom_ville');
            $stmt->bindParam(':nom_ville', $ville_arr);
            $stmt->execute();
            $ville_arr_id = $stmt->fetchColumn();
            if (!$ville_arr_id) {
                $stmt = $this->db->prepare('INSERT INTO Villes (nom_ville) VALUES (:nom_ville)');
                $stmt->bindParam(':nom_ville', $ville_arr);
                $stmt->execute();
                $ville_arr_id = $this->db->lastInsertId();
            }

            // Insert the new stage
            $stmt = $this->db->prepare('INSERT INTO Etapes (id_etape, date_etape, type_etape, distance, repos_transfert, num_ville_dep, num_ville_arr) VALUES (:id_etape, :date_etape, :type_etape, :distance, :repos_transfert, :num_ville_dep, :num_ville_arr)');
            $stmt->bindParam(':id_etape', $id_etape);
            $stmt->bindParam(':date_etape', $date_etape);
            $stmt->bindParam(':type_etape', $type_etape);
            $stmt->bindParam(':distance', $distance);
            $stmt->bindParam(':repos_transfert', $repos_transfert);
            $stmt->bindParam(':num_ville_dep', $ville_dep_id);
            $stmt->bindParam(':num_ville_arr', $ville_arr_id);
            $stmt->execute();

            echo 'Stage added successfully!';
            echo '<script>
            setTimeout(function() {
                window.location.href = "/projetBDD/index.php?page=admin";
            }, 2000);
        </script>';
        } else {
            echo $this->twig->render('admin/add_stage.html.twig');
        }
    }

    public function addCity()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom_ville = $_POST['nom_ville'];
            $code_pays = $_POST['code_pays'];
            $id_ville = $_POST['id_ville'];

            // Insert the new city
            $stmt = $this->db->prepare('INSERT INTO Villes (nom_ville, code_pays, id_ville) VALUES (:nom_ville, :code_pays, :id_ville)');
            $stmt->bindParam(':nom_ville', $nom_ville);
            $stmt->bindParam(':code_pays', $code_pays);
            $stmt->bindParam(':id_ville', $id_ville);
            $stmt->execute();

            echo 'City added successfully!';
            echo '<script>
            setTimeout(function() {
                window.location.href = "/projetBDD/index.php?page=edit_stage&id=' . $_GET['stage_id'] . '";
            }, 2000);
        </script>';
        } else {
            echo $this->twig->render('admin/add_city.html.twig', ['stage_id' => $_GET['stage_id']]);
        }
    }
}