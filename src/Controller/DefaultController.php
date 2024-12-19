<?php
declare (strict_types = 1);
namespace MyApp\Controller;
use MyApp\Service\DependencyContainer;
use Twig\Environment;


class DefaultController
{
    private $twig;
  
    public function __construct(Environment $twig, DependencyContainer $dependencyContainer)
    {
        $this->twig = $twig;
    }

    public function home()
    {
        echo $this->twig->render('defaultController/home.html.twig', []);
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
