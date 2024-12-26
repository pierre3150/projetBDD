<?php
declare(strict_types=1);

namespace MyApp\Entity;

class User
{
    private ?int $id_user = null;
    private ?string $email;
    private ?string $password;
    private ?string $role;

    public function __construct(
        ?int $id_user,
        ?string $email,
        ?string $password,
        ?string $role
    ) {
        $this->id_user = $id_user;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public function getIdUser(): ?int
    {
        return $this->id_user;
    }

    public function setIdUser(?int $id_user): void
    {
        $this->id_user = $id_user;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): void
    {
        $this->role = $role;
    }
}