<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Fraisforfaitise
 *
 * @ORM\Table(name="FRAISFORFAITISE", indexes={@ORM\Index(name="I_FK_FRAISFORFAITISE_FICHE", columns={"ID_FICHE"}), @ORM\Index(name="I_FK_FRAISFORFAITISE_TYPEFRAISFORFAIT", columns={"ID_TYPE"})})
 * @ORM\Entity
 */
class Fraisforfaitise
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
     * @var bigint|null
     *
     * @ORM\Column(name="QUANTITE", type="integer", nullable=true)
     */
    private $quantite;

    /**
     * @var \Fiche
     *
     * @ORM\ManyToOne(targetEntity="Fiche")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_FICHE", referencedColumnName="ID")
     * })
     */
    private $idFiche;

    /**
     * @var \Typefraisforfait
     *
     * @ORM\ManyToOne(targetEntity="Typefraisforfait")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_TYPE", referencedColumnName="ID")
     * })
     */
    private $idType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(?int $quantite): self
    {
        $this->quantite = $quantite;

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

    public function getIdType(): ?Typefraisforfait
    {
        return $this->idType;
    }

    public function setIdType(?Typefraisforfait $idType): self
    {
        $this->idType = $idType;

        return $this;
    }


}
