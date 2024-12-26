<?php
declare(strict_types=1);

namespace MyApp\Entity;

class Pays
{
    private ?string $code_pays;
    private ?string $nom_pays;

    public function __construct(?string $code_pays, ?string $nom_pays)
    {
        $this->code_pays = $code_pays;
        $this->nom_pays = $nom_pays;
    }

    public function getCodePays(): ?string
    {
        return $this->code_pays;
    }

    public function setCodePays(?string $code_pays): void
    {
        $this->code_pays = $code_pays;
    }

    public function getNomPays(): ?string
    {
        return $this->nom_pays;
    }

    public function setNomPays(?string $nom_pays): void
    {
        $this->nom_pays = $nom_pays;
    }
}