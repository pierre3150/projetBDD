<?php
namespace MyApp\Service;

use PDO;
use MyApp\Model\UserModel;

class DependencyContainer
{
    private $instances = [];

    public function __construct()
    {
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
            default:
                throw new \Exception("No service found for key: " . $key);
        }
    }

}
?>
