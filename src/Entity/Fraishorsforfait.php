<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Fraishorsforfait
 *
 * @ORM\Table(name="FRAISHORSFORFAIT", indexes={@ORM\Index(name="I_FK_FRAISHORSFORFAIT_FICHE", columns={"ID_FICHE"})})
 * @ORM\Entity
 */
class Fraishorsforfait
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
     * @var \DateTime
     *
     * @ORM\Column(name="DATE", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="MONTANT", type="decimal", precision=10, scale=2, nullable=false)
     * @Assert\Positive(message="La valeur doit être un nombre positif")
     */

    private $montant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="LIBELLE", type="string", length=255, nullable=true, options={"fixed"=true})
     */
    private $libelle;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="VALIDITE", type="boolean", nullable=true)
     */
    private $validite;

    /**
     * @var \Fiche
     *
     * @ORM\ManyToOne(targetEntity="Fiche")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_FICHE", referencedColumnName="ID")
     * })
     */
    private $idFiche;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): self
    {
        $this->montant = $montant;

        return $this;
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

    public function getValidite(): ?bool
    {
        return $this->validite;
    }

    public function setValidite(?bool $validite): self
    {
        $this->validite = $validite;

        return $this;
    }

    public function getIdFiche(): ?Fiche
    {
        return $this->idFiche;
    }

    public function setIdFiche(?Fiche $idFiche): self
    {
        $this->idFiche = $idFiche;

        return $this;
    }


}
