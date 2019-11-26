<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Typefraisforfait
 *
 * @ORM\Table(name="TYPEFRAISFORFAIT")
 * @ORM\Entity
 */
class Typefraisforfait
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="LIBELLE", type="string", length=32, nullable=true, options={"fixed"=true})
     */
    private $libelle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="MONTANT_UNITAIRE", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $montantUnitaire;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getMontantUnitaire(): ?string
    {
        return $this->montantUnitaire;
    }

    public function setMontantUnitaire(?string $montantUnitaire): self
    {
        $this->montantUnitaire = $montantUnitaire;

        return $this;
    }


}
