<?php

declare (strict_types = 1);

namespace MyApp\Controller;

use MyApp\Service\DependencyContainer;
use Twig\Environment;
use MyApp\Model\EtapesModel;
use MyApp\Model\EquipesModel;

class DefaultController
{
    private $twig;
    private $etapesModel;
    private $equipesModel;

    public function __construct(Environment $twig, DependencyContainer $dependencyContainer)
    {
        $this->twig = $twig;
        $this->etapesModel = $dependencyContainer->get('EtapesModel');
        $this->equipesModel = $dependencyContainer->get('EquipesModel');
    }

    public function home()
    {
        $equipes = $this->equipesModel->getAllEquipes();
        $etapes = $this->etapesModel->getAllEtapes();
        echo $this->twig->render('defaultController/home.html.twig', ['etapes'=>$etapes, 'equipes'=>$equipes]);
    }

    public function error404()
    {
        echo $this->twig->render('defaultController/error404.html.twig', []);
    }

    public function error500()
    {
        echo $this->twig->render('defaultController/error500.html.twig', []);
    }
}