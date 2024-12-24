<?php
declare(strict_types=1);

namespace MyApp\Entity;

class Equipes
{
    private ?string $id_equipe = null;
    private ?string $nom_equipe;
    private ?string $code_pays;

    public function __construct(
        ?string $id_equipe,
        ?string $nom_equipe,
        ?string $code_pays
    ) {
        $this->id_equipe = $id_equipe;
        $this->nom_equipe = $nom_equipe;
        $this->code_pays = $code_pays;
    }

    public function getIdEquipe(): ?string
    {
        return $this->id_equipe;
    }

    public function setIdEquipe(?string $id_equipe): void
    {
        $this->id_equipe = $id_equipe;
    }

    public function getNomEquipe(): ?string
    {
        return $this->nom_equipe;
    }

    public function setNomEquipe(?string $nom_equipe): void
    {
        $this->nom_equipe = $nom_equipe;
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