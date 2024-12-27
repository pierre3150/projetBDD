<?php

declare (strict_types = 1);

namespace MyApp\Routing;

use MyApp\Controller\DefaultController;
use MyApp\Controller\UserController;
use MyApp\Service\DependencyContainer;

class Router
{
    private $dependencyContainer;
    private $pageMappings;
    private $defaultPage;
    private $errorPage;

    public function __construct(DependencyContainer $dependencyContainer)
    {
        $this->dependencyContainer = $dependencyContainer;
        $this->pageMappings = [
            'home' => [DefaultController::class, 'home'],
            'register' => [UserController::class, 'register'],
            'login' => [UserController::class, 'login'],
            '404' => [DefaultController::class, 'error404'],
            '500' => [DefaultController::class, 'error500'],
            'profile' => [UserController::class, 'profile'],
            'logout' => [UserController::class, 'logout'],
        ];
        $this->defaultPage = 'home';
        $this->errorPage = '404';
    }

    public function route($twig)
    {
        $requestedPage = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);

        if (!$requestedPage) {
            $requestedPage = $this->defaultPage;
        } else {
            if (!array_key_exists($requestedPage, $this->pageMappings)) {
                $requestedPage = $this->errorPage;
            }
        }

        $controllerInfo = $this->pageMappings[$requestedPage];
        [$controllerClass, $method] = $controllerInfo;

        if (class_exists($controllerClass) && method_exists($controllerClass, $method)) {
            $controller = new $controllerClass($twig, $this->dependencyContainer);
            call_user_func([$controller, $method]);
        } else {
            $error500Info = $this->pageMappings['500'];
            [$errorControllerClass, $errorMethod] = $error500Info;
            $errorController = new $errorControllerClass($twig, $this->dependencyContainer);
            call_user_func([$errorController, $errorMethod]);
        }
    }
}