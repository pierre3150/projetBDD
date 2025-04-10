<?php

declare (strict_types = 1);

namespace MyApp\Controller;

use MyApp\Service\DependencyContainer;
use Twig\Environment;
use MyApp\Model\ClassementGeneralModel;
use MyApp\Model\ClassementEquipeModel;
use MyApp\Model\ClassementEtapeModel;

class ClassementController
{
    private $twig;
    private $classementGeneralModel;
    private $classementEquipeModel;
    private $classementEtapeModel;

    public function __construct(Environment $twig, DependencyContainer $container)
    {
        $this->twig = $twig;
        $this->classementGeneralModel = $container->get('ClassementGeneralModel');
        $this->classementEquipeModel = $container->get('ClassementEquipeModel');
        $this->ClassementEtapeModel = $container->get('ClassementEtapeModel');
    }

    public function classementGeneral()
    {
        $general = $this->classementGeneralModel->getClassementGeneral();
        echo $this->twig->render('classement/classementGeneral.html.twig', ['general' => $general]);
    }

    public function classementEquipe()
    {
        $equipe = $this->classementEquipeModel->getClassementEquipe();
        echo $this->twig->render('classement/classementEquipe.html.twig', ['equipe' => $equipe]);
    }

    public function classementEtape()
    {
        $etape = $this->classementEtapeModel->getClassementEtape();
        echo $this->twig->render('classement/classementEtape.html.twig', ['etape' => $etape]);
    }
}
