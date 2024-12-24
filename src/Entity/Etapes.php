<?php
declare(strict_types=1);

namespace MyApp\Entity;

class Etapes
{
    private ?int $id = null;
    private ?string $date_etape;
    private ?string $type_etape;
    private ?string $distance;
    private ?bool $repos_transfert;
    private ?int $num_ville_dep;
    private ?int $num_ville_arr;

    public function __construct(
        ?int $id,
        ?string $date_etape,
        ?string $type_etape,
        ?string $distance,
        ?bool $repos_transfert,
        ?int $num_ville_dep,
        ?int $num_ville_arr
    ) {
        $this->id = $id;
        $this->date_etape = $date_etape;
        $this->type_etape = $type_etape;
        $this->distance = $distance;
        $this->repos_transfert = $repos_transfert;
        $this->num_ville_dep = $num_ville_dep;
        $this->num_ville_arr = $num_ville_arr;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getDateEtape(): ?string
    {
        return $this->date_etape;
    }

    public function setDateEtape(?string $date_etape): void
    {
        $this->date_etape = $date_etape;
    }

    public function getTypeEtape(): ?string
    {
        return $this->type_etape;
    }

    public function setTypeEtape(?string $type_etape): void
    {
        $this->type_etape = $type_etape;
    }

    public function getDistance(): ?string
    {
        return $this->distance;
    }

    public function setDistance(?string $distance): void
    {
        $this->distance = $distance;
    }

    public function getReposTransfert(): ?bool
    {
        return $this->repos_transfert;
    }

    public function setReposTransfert(?bool $repos_transfert): void
    {
        $this->repos_transfert = $repos_transfert;
    }

    public function getNumVilleDep(): ?int
    {
        return $this->num_ville_dep;
    }

    public function setNumVilleDep(?int $num_ville_dep): void
    {
        $this->num_ville_dep = $num_ville_dep;
    }

    public function getNumVilleArr(): ?int
    {
        return $this->num_ville_arr;
    }

    public function setNumVilleArr(?int $num_ville_arr): void
    {
        $this->num_ville_arr = $num_ville_arr;
    }
}