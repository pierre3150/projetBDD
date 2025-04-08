<?php

declare(strict_types=1);

namespace MyApp\Controller;

use Twig\Environment;
use MyApp\Service\DependencyContainer;
use MyApp\Model\EtapesModel;

class EtapesController
{
    private $twig;
    private $etapesModel;

    public function __construct(Environment $twig, DependencyContainer $container)
    {
        $this->twig = $twig;
        $this->etapesModel = $container->get('EtapesModel');
    }

    public function etapes()
    {
        $etapes = $this->etapesModel->getAllEtapes();
        echo $this->twig->render('etapes/etapes.html.twig', ['etapes' => $etapes]);    
    }
}