<?php
declare(strict_types=1);

namespace MyApp\Entity;

class Resultats
{
    private ?int $id_resultat = null;
    private ?int $num_etape;
    private ?int $num_dossard;
    private ?int $bonification;
    private ?string $chrono;

    public function __construct(
        ?int $id_resultat,
        ?int $num_etape,
        ?int $num_dossard,
        ?int $bonification,
        ?string $chrono
    ) {
        $this->id_resultat = $id_resultat;
        $this->num_etape = $num_etape;
        $this->num_dossard = $num_dossard;
        $this->bonification = $bonification;
        $this->chrono = $chrono;
    }

    public function getIdResultat(): ?int
    {
        return $this->id_resultat;
    }

    public function setIdResultat(?int $id_resultat): void
    {
        $this->id_resultat = $id_resultat;
    }

    public function getNumEtape(): ?int
    {
        return $this->num_etape;
    }

    public function setNumEtape(?int $num_etape): void
    {
        $this->num_etape = $num_etape;
    }

    public function getNumDossard(): ?int
    {
        return $this->num_dossard;
    }

    public function setNumDossard(?int $num_dossard): void
    {
        $this->num_dossard = $num_dossard;
    }

    public function getBonification(): ?int
    {
        return $this->bonification;
    }

    public function setBonification(?int $bonification): void
    {
        $this->bonification = $bonification;
    }

    public function getChrono(): ?string
    {
        return $this->chrono;
    }

    public function setChrono(?string $chrono): void
    {
        $this->chrono = $chrono;
    }
}