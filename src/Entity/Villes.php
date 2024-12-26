<?php
declare(strict_types=1);

namespace MyApp\Entity;

class Villes
{
    private ?int $id_ville = null;
    private ?string $nom_ville;
    private ?string $code_pays;

    public function __construct(
        ?int $id_ville,
        ?string $nom_ville,
        ?string $code_pays
    ) {
        $this->id_ville = $id_ville;
        $this->nom_ville = $nom_ville;
        $this->code_pays = $code_pays;
    }

    public function getIdVille(): ?int
    {
        return $this->id_ville;
    }

    public function setIdVille(?int $id_ville): void
    {
        $this->id_ville = $id_ville;
    }

    public function getNomVille(): ?string
    {
        return $this->nom_ville;
    }

    public function setNomVille(?string $nom_ville): void
    {
        $this->nom_ville = $nom_ville;
    }

    public function getCodePays(): ?string
    {
        return $this->code_pays;
    }

    public function setCodePays(?string $code_pays): void
    {
        $this->code_pays = $code_pays;
    }
}