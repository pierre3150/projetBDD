<?php
namespace MyApp\Service;

use Dotenv\Dotenv;
use MyApp\Model\ClassementEquipeModel;
use MyApp\Model\ClassementEtapeModel;
use MyApp\Model\ClassementGeneralModel;
use MyApp\Model\EquipesModel;
use MyApp\Model\EtapesModel;
use PDO;

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
            case 'ClassementGeneralModel':
                $pdo = $this->get('PDO');
                return new ClassementGeneralModel($pdo);
            case 'ClassementEquipeModel':
                $pdo = $this->get('PDO');
                return new ClassementEquipeModel($pdo);
            case 'ClassementEtapeModel':
                $pdo = $this->get('PDO');
                return new ClassementEtapeModel($pdo);
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
