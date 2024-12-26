<?php

declare(strict_types=1);

namespace MyApp\Controller;

use MyApp\Entity\User;
use MyApp\Service\DependencyContainer;
use PDO;
use Twig\Environment;

class UserController
{
    private $twig;
    private $db;

    public function __construct(Environment $twig, DependencyContainer $dependencyContainer)
    {
        $this->twig = $twig;
        $this->db = $dependencyContainer->get('PDO');
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = '';

            // Check if email already exists
            $stmt = $this->db->prepare('SELECT salt, email FROM User');
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($users as $user) {
                $hashedEmail = hash('sha256', $email . $user['salt']);
                if ($hashedEmail === $user['email']) {
                    echo 'Email already exists. Please use a different email address.';
                    echo '<script>
                setTimeout(function() {
                    window.location.href = "/projetBDD/index.php?page=register";
                }, 2000);
              </script>';
                    return;
                }
            }

            // Validate password
            if (!$this->isValidPassword($password)) {
                echo 'Password must be at least 12 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.';
                return;
            }

            // Hash and salt the email
            $salt = bin2hex(random_bytes(16));
            $hashedEmail = hash('sha256', $email . $salt);

            // Hash and salt the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $this->db->prepare('INSERT INTO User (email, password, role, salt) VALUES (:email, :password, :role, :salt)');
            $stmt->bindParam(':email', $hashedEmail);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':salt', $salt);
            $stmt->execute();

            echo 'Registration successful!';
            echo '<script>
                setTimeout(function() {
                    window.location.href = "/projetBDD/index.php?page=login";
                }, 2000);
              </script>';
        } else {
            echo $this->twig->render('user/register.html.twig');
        }
    }

    private function isValidPassword(string $password): bool
    {
        return preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{12,}$/', $password) === 1;
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Retrieve the salt for the given email
            $stmt = $this->db->prepare('SELECT * FROM User');
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($users as $user) {
                $hashedEmail = hash('sha256', $email . $user['salt']);
                if ($hashedEmail === $user['email']) {
                    // Verify the password
                    if (password_verify($password, $user['password'])) {
                        session_start();
                        $_SESSION['user_id'] = $user['id_user'];
                        $_SESSION['email'] = $user['email'];
                        $_SESSION['role'] = $user['role'];
                        echo 'Login successful!';
                        return;
                    } else {
                        echo 'Invalid email or password.';
                        return;
                    }
                }
            }
            echo 'Invalid email or password.';
        } else {
            echo $this->twig->render('user/login.html.twig');
        }
    }
}