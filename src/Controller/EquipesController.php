<?php

declare(strict_types=1);

namespace MyApp\Controller;

use Twig\Environment;
use MyApp\Service\DependencyContainer;

class EquipesController
{
    private $twig;
    private $db;

    public function __construct(Environment $twig, DependencyContainer $dependencyContainer)
    {
        $this->twig = $twig;
        $this->db = $dependencyContainer->get('PDO');
    }

    public function listEquipes()
    {
        $stmt = $this->db->query('SELECT id_equipe, nom_equipe FROM Equipes');
        $equipes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        echo $this->twig->render('equipes/list.html.twig', ['equipes' => $equipes]);
    }
}