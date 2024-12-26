<?php
declare(strict_types=1);

namespace MyApp\Entity;

class Coureurs
{
    private ?int $id_dossard = null;
    private ?string $nom_coureur;
    private ?string $prenom_coureur;
    private ?string $date_naissance;
    private ?string $code_pays;
    private ?string $num_equipe;

    public function __construct(
        ?int $id_dossard,
        ?string $nom_coureur,
        ?string $prenom_coureur,
        ?string $date_naissance,
        ?string $code_pays,
        ?string $num_equipe
    ) {
        $this->id_dossard = $id_dossard;
        $this->nom_coureur = $nom_coureur;
        $this->prenom_coureur = $prenom_coureur;
        $this->date_naissance = $date_naissance;
        $this->code_pays = $code_pays;
        $this->num_equipe = $num_equipe;
    }

    public function getIdDossard(): ?int
    {
        return $this->id_dossard;
    }

    public function setIdDossard(?int $id_dossard): void
    {
        $this->id_dossard = $id_dossard;
    }

    public function getNomCoureur(): ?string
    {
        return $this->nom_coureur;
    }

    public function setNomCoureur(?string $nom_coureur): void
    {
        $this->nom_coureur = $nom_coureur;
    }

    public function getPrenomCoureur(): ?string
    {
        return $this->prenom_coureur;
    }

    public function setPrenomCoureur(?string $prenom_coureur): void
    {
        $this->prenom_coureur = $prenom_coureur;
    }

    public function getDateNaissance(): ?string
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(?string $date_naissance): void
    {
        $this->date_naissance = $date_naissance;
    }

    public function getCodePays(): ?string
    {
        return $this->code_pays;
    }

    public function setCodePays(?string $code_pays): void
    {
        $this->code_pays = $code_pays;
    }

    public function getNumEquipe(): ?string
    {
        return $this->num_equipe;
    }

    public function setNumEquipe(?string $num_equipe): void
    {
        $this->num_equipe = $num_equipe;
    }
}