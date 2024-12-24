<?php
namespace MyApp\Service;

use MyApp\Model\EtapesModel;
use MyApp\Model\EquipesModel;
use PDO;
use Dotenv\Dotenv;

class DependencyContainer
{
    private $instances = [];

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
    }

    public function get($key)
    {
        if (!isset($this->instances[$key])) {
            $this->instances[$key] = $this->createInstance($key);
        }

        return $this->instances[$key];
    }

    private function createInstance($key)
    {
        switch ($key) {
            case 'PDO':
                return $this->createPDOInstance();
            case 'EtapesModel':
                $pdo = $this->get('PDO');
                return new EtapesModel($pdo);
            case 'EquipesModel':
                $pdo = $this->get('PDO');
                return new EquipesModel($pdo);
            default:
                throw new \Exception("No service found for key: " . $key);
        }
    }

    private function createPDOInstance()
    {
        $dsn = sprintf('mysql:host=%s;dbname=%s', $_ENV['DB_HOST'], $_ENV['DB_NAME']);
        $username = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASS'];
        return new PDO($dsn, $username, $password);
    }
}